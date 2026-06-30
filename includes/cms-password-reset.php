<?php
declare(strict_types=1);

/**
 * Email-based password reset (link + 6-digit backup code). Token state in .private/cms_reset_pending.json
 * Rate limits + generic responses to reduce enumeration.
 */

function cms_pr_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])
        && strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
        return true;
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_SSL'])
        && strtolower((string) $_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
        return true;
    }
    if (isset($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443') {
        return true;
    }
    return false;
}

/** Base URL for /admin (no trailing slash), for links in email. */
function cms_pr_admin_base_url(): string
{
    $scheme = cms_pr_https() ? 'https' : 'http';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $sn = (string) ($_SERVER['SCRIPT_NAME'] ?? '/admin/forgot.php');
    $dir = str_replace('\\', '/', dirname($sn));
    if ($dir === '/' || $dir === '.' || $dir === '') {
        $dir = '/admin';
    }
    return $scheme . '://' . $host . rtrim($dir, '/');
}

function cms_pr_pending_path(): string
{
    return __DIR__ . '/../.private/cms_reset_pending.json';
}

function cms_pr_rate_file_ip(): string
{
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? '0');
    $hash = hash('sha256', $ip);
    return __DIR__ . '/../.private/cms_reset_rate_' . $hash . '.txt';
}

function cms_pr_rate_file_global(): string
{
    return __DIR__ . '/../.private/cms_reset_rate_global.txt';
}

function cms_pr_rate_allow(): bool
{
    $now = time();
    $global = cms_pr_rate_file_global();
    if (is_readable($global)) {
        $last = (int) trim((string) file_get_contents($global));
        if ($last > 0 && ($now - $last) < 90) {
            return false;
        }
    }
    $ipf = cms_pr_rate_file_ip();
    if (is_readable($ipf)) {
        $last = (int) trim((string) file_get_contents($ipf));
        if ($last > 0 && ($now - $last) < 600) {
            return false;
        }
    }
    return true;
}

function cms_pr_rate_touch(): void
{
    $dir = dirname(cms_pr_rate_file_global());
    if (!is_dir($dir)) {
        mkdir($dir, 0700, true);
    }
    file_put_contents(cms_pr_rate_file_global(), (string) time(), LOCK_EX);
    file_put_contents(cms_pr_rate_file_ip(), (string) time(), LOCK_EX);
}

/**
 * @return array{ok: true}|array{ok: false, error: string}
 */
function cms_pr_request_reset(string $email, array $config): array
{
    $target = strtolower(trim($email));
    $configured = strtolower(trim((string) ($config['reset_email'] ?? '')));
    if ($configured === '') {
        return ['ok' => false, 'error' => 'reset_disabled'];
    }
    if (!cms_pr_rate_allow()) {
        return ['ok' => true];
    }
    if ($target !== $configured) {
        return ['ok' => true];
    }

    $token = bin2hex(random_bytes(32));
    $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $payload = [
        'token_hash' => hash('sha256', $token),
        'code_hash' => hash('sha256', $code),
        'expires_at' => time() + 3600,
        'attempts' => 0,
    ];
    $pending = cms_pr_pending_path();
    $dir = dirname($pending);
    if (!is_dir($dir)) {
        mkdir($dir, 0700, true);
    }
    file_put_contents(
        $pending,
        json_encode($payload, JSON_THROW_ON_ERROR),
        LOCK_EX
    );

    $base = cms_pr_admin_base_url();
    $link = $base . '/reset.php?t=' . rawurlencode($token);
    $subject = 'Portfolio CMS — password reset';
    $body = "Use this link within one hour (or enter the code on the reset page):\r\n\r\n"
        . $link . "\r\n\r\n"
        . "Backup code: {$code}\r\n\r\n"
        . "If you did not request this, ignore this email.\r\n";

    $from = trim((string) ($config['reset_mail_from'] ?? ''));
    if ($from === '') {
        $from = $configured;
    }
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from,
    ];

    cms_pr_rate_touch();
    @mail($configured, $subject, $body, implode("\r\n", $headers));

    return ['ok' => true];
}

/**
 * @return array{ok: true, token: string}|array{ok: false}
 */
function cms_pr_verify_token(string $token): array
{
    $pending = cms_pr_pending_path();
    if (!is_readable($pending)) {
        return ['ok' => false];
    }
    try {
        /** @var array{token_hash?: string, code_hash?: string, expires_at?: int, attempts?: int} $data */
        $data = json_decode((string) file_get_contents($pending), true, 512, JSON_THROW_ON_ERROR);
    } catch (Throwable $e) {
        return ['ok' => false];
    }
    $th = (string) ($data['token_hash'] ?? '');
    if ($th === '' || !hash_equals($th, hash('sha256', $token))) {
        return ['ok' => false];
    }
    if ((int) ($data['expires_at'] ?? 0) < time()) {
        return ['ok' => false];
    }
    return ['ok' => true, 'token' => $token];
}

/**
 * @return array{ok: true}|array{ok: false}
 */
function cms_pr_verify_code(string $code): array
{
    $pending = cms_pr_pending_path();
    if (!is_readable($pending)) {
        return ['ok' => false];
    }
    try {
        /** @var array{token_hash?: string, code_hash?: string, expires_at?: int, attempts?: int} $data */
        $data = json_decode((string) file_get_contents($pending), true, 512, JSON_THROW_ON_ERROR);
    } catch (Throwable $e) {
        return ['ok' => false];
    }
    if ((int) ($data['expires_at'] ?? 0) < time()) {
        return ['ok' => false];
    }
    $attempts = (int) ($data['attempts'] ?? 0);
    if ($attempts >= 8) {
        return ['ok' => false];
    }

    $normalized = preg_replace('/\D/', '', $code) ?? '';
    if (strlen($normalized) !== 6) {
        return ['ok' => false];
    }
    $ch = (string) ($data['code_hash'] ?? '');
    $ok = $ch !== '' && hash_equals($ch, hash('sha256', $normalized));
    if (!$ok) {
        $data['attempts'] = $attempts + 1;
        file_put_contents(cms_pr_pending_path(), json_encode($data, JSON_THROW_ON_ERROR), LOCK_EX);
        return ['ok' => false];
    }
    return ['ok' => true];
}

function cms_pr_clear_pending(): void
{
    $p = cms_pr_pending_path();
    if (is_file($p)) {
        @unlink($p);
    }
}

/**
 * Apply new password after token (email link) or verified 6-digit code (session flag).
 *
 * @return string Empty on success, otherwise user-facing error message.
 */
function cms_pr_apply_new_password(
    array $config,
    string $pass1,
    string $pass2,
    ?string $token,
    bool $codeSessionOk
): string {
    if ($pass1 !== $pass2) {
        return 'Passwords do not match.';
    }
    if (strlen($pass1) < 10) {
        return 'Use at least 10 characters.';
    }
    if (!is_readable(cms_pr_pending_path())) {
        return 'Reset link expired or already used. Request a new one.';
    }
    $allowed = false;
    if ($token !== null && $token !== '') {
        $allowed = cms_pr_verify_token($token)['ok'];
    } elseif ($codeSessionOk) {
        $allowed = true;
    }
    if (!$allowed) {
        return 'Invalid or expired reset. Try again.';
    }
    if (!cms_pr_save_new_password_hash($pass1, $config)) {
        return 'Could not save the new password. Check that .private/ is writable.';
    }
    cms_pr_clear_pending();
    return '';
}

/**
 * Write new bcrypt hash to `.private/cms-overrides.php`, preserving other keys.
 */
function cms_pr_save_new_password_hash(string $newPlain, array $config): bool
{
    $hash = password_hash($newPlain, PASSWORD_DEFAULT);
    if ($hash === false) {
        return false;
    }
    $path = __DIR__ . '/../.private/cms-overrides.php';
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0700, true);
    }
    $existing = [];
    if (is_readable($path)) {
        $x = require $path;
        if (is_array($x)) {
            $existing = $x;
        }
    }
    $existing['admin_password_hash'] = $hash;
    if (trim((string) ($existing['reset_email'] ?? '')) === '' && trim((string) ($config['reset_email'] ?? '')) !== '') {
        $existing['reset_email'] = $config['reset_email'];
    }
    $export = var_export($existing, true);
    $out = "<?php\ndeclare(strict_types=1);\n\nreturn {$export};\n";
    return file_put_contents($path, $out, LOCK_EX) !== false;
}

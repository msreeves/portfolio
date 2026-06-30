<?php
declare(strict_types=1);

/**
 * Session cookies must be configured before session_start(). On live HTTPS (and behind
 * X-Forwarded-Proto), Secure + correct detection fixes "can't handle request" / login loops.
 */
function cms_request_is_https(): bool
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

/**
 * Cookie path = directory of the running script (e.g. /admin) so it works at site root or in a subfolder.
 */
function cms_session_cookie_path(): string
{
    $sn = $_SERVER['SCRIPT_NAME'] ?? '';
    if ($sn === '') {
        return '/';
    }
    $dir = str_replace('\\', '/', dirname($sn));
    if ($dir === '/' || $dir === '.' || $dir === '') {
        return '/';
    }
    return rtrim($dir, '/') . '/';
}

function cms_session_bootstrap(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $secure = cms_request_is_https();
    $path = cms_session_cookie_path();
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $path,
        'domain' => '',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

cms_session_bootstrap();

function cms_logged_in(): bool
{
    return !empty($_SESSION['cms_ok']);
}

/** Display name for the signed-in admin (set at login). */
function cms_current_username(): string
{
    $u = $_SESSION['cms_username'] ?? '';
    return is_string($u) && $u !== '' ? $u : 'Admin';
}

function cms_require_login(): void
{
    if (!cms_logged_in()) {
        header('Location: index.php', true, 302);
        exit;
    }
}

function cms_login(string $username, string $password): bool
{
    $config = require __DIR__ . '/../includes/cms-config.php';
    $expectedUser = trim((string) ($config['admin_username'] ?? ''));
    $givenUser = trim($username);
    if ($expectedUser !== '' && !hash_equals($expectedUser, $givenUser)) {
        return false;
    }
    $hash = $config['admin_password_hash'] ?? '';
    if ($hash === '' || !password_verify($password, $hash)) {
        return false;
    }
    session_regenerate_id(true);
    $_SESSION['cms_ok'] = true;
    $_SESSION['cms_username'] = $expectedUser !== '' ? $expectedUser : ($givenUser !== '' ? $givenUser : 'Admin');
    if (empty($_SESSION['cms_csrf'])) {
        $_SESSION['cms_csrf'] = bin2hex(random_bytes(16));
    }
    return true;
}

function cms_logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

function cms_csrf_token(): string
{
    return $_SESSION['cms_csrf'] ?? '';
}

function cms_verify_csrf(string $token): bool
{
    return isset($_SESSION['cms_csrf']) && hash_equals($_SESSION['cms_csrf'], $token);
}

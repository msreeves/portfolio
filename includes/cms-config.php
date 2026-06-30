<?php
declare(strict_types=1);

/**
 * Portfolio CMS — password hash and optional settings.
 *
 * Password: php -r "echo password_hash('your_new_password', PASSWORD_DEFAULT), PHP_EOL;"
 *
 * Optional file `.private/cms-overrides.php` (not in git) merges over these defaults — used after
 * a successful email reset or to set reset_email without editing this file.
 *
 * Password reset: set `reset_email` to an address you control. You will receive a link and a
 * 6-digit code. SMS is not included (would need Twilio etc.).
 */
$defaults = [
    /** If non-empty, sign-in must use this exact username. If empty, username is not checked (password only). */
    'admin_username' => 'msreeves',
    'admin_password_hash' => '$2y$12$yNgAgAu4neFTbIMkhIPxs./hQFVGvSCNrUIOzomuaHzIvkzl3obNK',
    /** If empty, “Forgot password” is disabled. Must match the address you type on the forgot form. */
    'reset_email' => '',
    /** Optional From: header for reset mail (defaults to reset_email). Use a mailbox @ your domain on shared hosting. */
    'reset_mail_from' => '',
];

$overridePath = __DIR__ . '/../.private/cms-overrides.php';
if (is_readable($overridePath)) {
    /** @var mixed $o */
    $o = require $overridePath;
    if (is_array($o)) {
        return array_merge($defaults, $o);
    }
}

return $defaults;

<?php
declare(strict_types=1);
/**
 * Contact / booking form handler.
 * POST target from contact.php. Sends email via PHP mail().
 * On success/failure redirects back to /contact with ?status=sent or ?status=error.
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['contact_submit'])) {
    header('Location: ../contact', true, 303);
    exit;
}

// ─── Honeypot check ───────────────────────────────────────────────────────────
if (!empty($_POST['_hp_field'])) {
    // Silent discard — bot filled honeypot
    header('Location: ../contact?status=sent', true, 303);
    exit;
}

// ─── Rate-limit: one submission per 30 s per session ─────────────────────────
session_start();
$now = time();
if (isset($_SESSION['hk_last_contact']) && ($now - (int) $_SESSION['hk_last_contact']) < 30) {
    header('Location: ../contact?status=error&reason=rate', true, 303);
    exit;
}

// ─── Collect and validate fields ─────────────────────────────────────────────
$name    = trim((string) ($_POST['contact_name'] ?? ''));
$contact = trim((string) ($_POST['contact_contact'] ?? ''));
$service = trim((string) ($_POST['contact_service'] ?? ''));
$date    = trim((string) ($_POST['contact_date'] ?? ''));
$message = trim((string) ($_POST['contact_message'] ?? ''));

if ($name === '' || $contact === '' || $message === '') {
    header('Location: ../contact?status=error&reason=validation', true, 303);
    exit;
}

// ─── Load recipient email from content JSON ───────────────────────────────────
$_contentPath = dirname(__FILE__) . '/../content/site-content.json';
$_mc = [];
if (is_readable($_contentPath)) {
    $_mc = json_decode((string) file_get_contents($_contentPath), true) ?? [];
}
$toEmail = (string) ($_mc['contact']['email'] ?? 'hcr37@hotmail.co.uk');
$brand   = (string) ($_mc['site']['brandName'] ?? 'Hayley Kharsa Hair Studio');

// ─── Build email ──────────────────────────────────────────────────────────────
$subject = 'Booking Enquiry' . ($service !== '' ? " – {$service}" : '') . " | {$brand}";
$body    = "New booking enquiry received via the website.\n\n";
$body   .= "Name:    {$name}\n";
$body   .= "Contact: {$contact}\n";
if ($service !== '') $body .= "Service: {$service}\n";
if ($date    !== '') $body .= "Date:    {$date}\n";
$body   .= "\nMessage:\n{$message}\n\n";
$body   .= "--\nSent from: " . $_SERVER['HTTP_HOST'] . "\n";

$headers  = "From: no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "\r\n";
$headers .= "Reply-To: {$contact}\r\n";
$headers .= "X-Mailer: PHP/" . PHP_VERSION . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = @mail($toEmail, $subject, $body, $headers);

$_SESSION['hk_last_contact'] = $now;

header('Location: ../contact?status=' . ($sent ? 'sent' : 'error'), true, 303);
exit;

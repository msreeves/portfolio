<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../includes/cms-password-reset.php';

$config = require __DIR__ . '/../includes/cms-config.php';
$resetConfigured = trim((string) ($config['reset_email'] ?? '')) !== '';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$csrf = (string) ($_POST['csrf'] ?? '');
	if (!cms_verify_csrf($csrf)) {
		$error = 'Invalid session. Reload the page and try again.';
	} elseif (!$resetConfigured) {
		$error = 'Password reset is not configured on this server.';
	} else {
		$email = (string) ($_POST['email'] ?? '');
		$result = cms_pr_request_reset($email, $config);
		if (isset($result['error']) && $result['error'] === 'reset_disabled') {
			$error = 'Password reset is not configured.';
		} else {
			$message = 'If that address matches the one on file, you will receive an email shortly with a link and a backup code.';
		}
	}
}

$csrf = cms_csrf_token();
if ($csrf === '') {
	$_SESSION['cms_csrf'] = bin2hex(random_bytes(16));
	$csrf = cms_csrf_token();
}
$cmsPageTitle = 'My Portfolio — Forgot password';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<?php require __DIR__ . '/layout-head.php'; ?>
</head>
<body class="cms-admin">
  <div class="container cms-admin__wrap">
    <h1 class="cms-admin__title">Forgot password</h1>
    <?php if ($message !== '') { ?>
      <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php } ?>
    <?php if ($error !== '') { ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php } ?>
    <?php if (!$resetConfigured) { ?>
      <p class="text-muted small">Add <code>reset_email</code> in <code>includes/cms-config.php</code> or <code>.private/cms-overrides.php</code> (see <code>.private/cms-overrides.example.php</code>).</p>
    <?php } else { ?>
    <form method="post" class="card shadow-sm p-4">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>" />
      <label class="form-label" for="email">Email on file</label>
      <input type="email" name="email" id="email" class="form-control mb-3" required autocomplete="email" />
      <button type="submit" class="btn btn-primary w-100">Send reset link</button>
    </form>
    <?php } ?>
    <p class="mt-3 mb-0"><a href="index.php">Back to sign in</a></p>
  </div>
</body>
</html>

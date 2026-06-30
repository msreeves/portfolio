<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';

if (cms_logged_in()) {
	header('Location: edit.php', true, 302);
	exit;
}

$error = '';
$resetOk = isset($_GET['reset']) && $_GET['reset'] === '1';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user = (string) ($_POST['username'] ?? '');
	$pass = (string) ($_POST['password'] ?? '');
	if (cms_login($user, $pass)) {
		header('Location: edit.php', true, 302);
		exit;
	}
	$error = 'Invalid username or password.';
}
$cmsPageTitle = 'My Portfolio — Login';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<?php require __DIR__ . '/layout-head.php'; ?>
</head>
<body class="cms-admin">
  <div class="container cms-admin__wrap">
    <h1 class="cms-admin__title">My Portfolio</h1>
    <?php if ($resetOk) { ?>
      <div class="alert alert-success">Password updated. Sign in with your new password.</div>
    <?php } ?>
    <?php if ($error !== '') { ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php } ?>
    <form method="post" class="card shadow-sm p-4">
      <label class="form-label" for="username">Username</label>
      <input type="text" name="username" id="username" class="form-control mb-3" required autocomplete="username" />
      <label class="form-label" for="password">Password</label>
      <div class="input-group mb-3" data-password-toggle="password">
        <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password" />
        <button type="button" class="btn btn-outline-secondary" data-password-toggle-btn aria-label="Show password" aria-pressed="false" title="Show password">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="password-toggle__icon-show" viewBox="0 0 16 16" aria-hidden="true"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/></svg>
          <svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="password-toggle__icon-hide d-none" viewBox="0 0 16 16" aria-hidden="true"><path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/><path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/></svg>
        </button>
      </div>
      <button type="submit" class="btn btn-primary w-100">Sign in</button>
    </form>
    <p class="mt-3 mb-0"><a href="forgot.php">Forgot password?</a></p>
    <p class="text-muted small mt-3 mb-0">Optional username: set <code>admin_username</code> in <code>includes/cms-config.php</code> or <code>.private/cms-overrides.php</code>. Password hash is in those files; after reset, hash is stored in <code>.private/cms-overrides.php</code>.</p>
  </div>
  <script src="password-toggle.js" defer></script>
</body>
</html>

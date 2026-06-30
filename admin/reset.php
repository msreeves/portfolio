<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/../includes/cms-password-reset.php';

$config = require __DIR__ . '/../includes/cms-config.php';

$csrf = cms_csrf_token();
if ($csrf === '') {
    $_SESSION['cms_csrf'] = bin2hex(random_bytes(16));
    $csrf = cms_csrf_token();
}

if (isset($_GET['step']) && $_GET['step'] === 'new' && empty($_SESSION['cms_pwreset_via_code'])) {
    header('Location: reset.php', true, 303);
    exit;
}

$error = '';
$info = '';

// --- POST: verify 6-digit code (step 1) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'verify_code') {
    $tok = (string) ($_POST['csrf'] ?? '');
    if (!cms_verify_csrf($tok)) {
        $error = 'Invalid session. Reload and try again.';
    } else {
        $code = (string) ($_POST['code'] ?? '');
        $v = cms_pr_verify_code($code);
        if ($v['ok']) {
            $_SESSION['cms_pwreset_via_code'] = true;
            header('Location: reset.php?step=new', true, 303);
            exit;
        }
        $error = 'Invalid or expired code.';
    }
}

// --- POST: set new password ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save') {
    $tok = (string) ($_POST['csrf'] ?? '');
    if (!cms_verify_csrf($tok)) {
        $error = 'Invalid session. Reload and try again.';
    } else {
        $p1 = (string) ($_POST['password'] ?? '');
        $p2 = (string) ($_POST['password2'] ?? '');
        $t = trim((string) ($_POST['t'] ?? ''));
        $viaSession = !empty($_SESSION['cms_pwreset_via_code']);
        $err = cms_pr_apply_new_password($config, $p1, $p2, $t !== '' ? $t : null, $viaSession);
        if ($err === '') {
            unset($_SESSION['cms_pwreset_via_code']);
            header('Location: index.php?reset=1', true, 303);
            exit;
        }
        $error = $err;
    }
}

$tokenGet = trim((string) ($_POST['t'] ?? $_GET['t'] ?? ''));
$stepNew = isset($_GET['step']) && $_GET['step'] === 'new';
$tokenValid = false;
if ($tokenGet !== '') {
    $tokenValid = cms_pr_verify_token($tokenGet)['ok'];
    if (!$tokenValid) {
        $error = $error !== '' ? $error : 'This reset link is invalid or has expired.';
    }
}

$showPasswordForm = ($tokenGet !== '' && $tokenValid) || ($stepNew && !empty($_SESSION['cms_pwreset_via_code']));
$cmsPageTitle = 'My Portfolio — Reset password';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<?php require __DIR__ . '/layout-head.php'; ?>
</head>
<body class="cms-admin">
  <div class="container cms-admin__wrap">
    <h1 class="cms-admin__title">Reset password</h1>
    <?php if ($info !== '') { ?>
      <div class="alert alert-info"><?= htmlspecialchars($info, ENT_QUOTES, 'UTF-8') ?></div>
    <?php } ?>
    <?php if ($error !== '') { ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php } ?>

    <?php if ($showPasswordForm) { ?>
    <form method="post" class="card shadow-sm p-4">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>" />
      <input type="hidden" name="action" value="save" />
      <?php if ($tokenGet !== '' && $tokenValid) { ?>
      <input type="hidden" name="t" value="<?= htmlspecialchars($tokenGet, ENT_QUOTES, 'UTF-8') ?>" />
      <?php } ?>
      <label class="form-label" for="password">New password</label>
      <div class="input-group mb-2" data-password-toggle="password">
        <input type="password" name="password" id="password" class="form-control" required minlength="10" autocomplete="new-password" />
        <button type="button" class="btn btn-outline-secondary" data-password-toggle-btn aria-label="Show password" aria-pressed="false" title="Show password">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="password-toggle__icon-show" viewBox="0 0 16 16" aria-hidden="true"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/></svg>
          <svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="password-toggle__icon-hide d-none" viewBox="0 0 16 16" aria-hidden="true"><path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/><path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/></svg>
        </button>
      </div>
      <label class="form-label" for="password2">Confirm</label>
      <div class="input-group mb-3" data-password-toggle="password2">
        <input type="password" name="password2" id="password2" class="form-control" required minlength="10" autocomplete="new-password" />
        <button type="button" class="btn btn-outline-secondary" data-password-toggle-btn aria-label="Show password" aria-pressed="false" title="Show password">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="password-toggle__icon-show" viewBox="0 0 16 16" aria-hidden="true"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/></svg>
          <svg xmlns="http://www.w3.org/2000/svg" width="1.15em" height="1.15em" fill="currentColor" class="password-toggle__icon-hide d-none" viewBox="0 0 16 16" aria-hidden="true"><path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/><path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/></svg>
        </button>
      </div>
      <button type="submit" class="btn btn-primary w-100">Save password</button>
    </form>
    <?php } else { ?>
    <p class="text-muted small">Open the link in your email, or enter the 6-digit code from the email.</p>
    <form method="post" class="card shadow-sm p-4 mb-3">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>" />
      <input type="hidden" name="action" value="verify_code" />
      <label class="form-label" for="code">6-digit code</label>
      <input type="text" name="code" id="code" class="form-control mb-3" inputmode="numeric" pattern="[0-9]*" maxlength="12" autocomplete="one-time-code" placeholder="000000" />
      <button type="submit" class="btn btn-outline-primary w-100">Continue</button>
    </form>
    <?php } ?>

    <p class="mt-3 mb-0"><a href="index.php">Back to sign in</a></p>
  </div>
  <script src="password-toggle.js" defer></script>
</body>
</html>

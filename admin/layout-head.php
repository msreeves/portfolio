<?php
declare(strict_types=1);
/**
 * Shared head for CMS auth pages (login, forgot, reset).
 *
 * @var string $cmsPageTitle Page title for <title>.
 */
require_once __DIR__ . '/../includes/vendor-assets.php';
$t = $cmsPageTitle ?? 'My Portfolio';
?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($t, ENT_QUOTES, 'UTF-8') ?></title>
<?php require __DIR__ . '/includes/vendor-head.php'; ?>
  <link rel="stylesheet" href="cms-admin.css" />

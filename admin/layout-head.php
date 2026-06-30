<?php
declare(strict_types=1);
/**
 * Shared head for CMS auth pages (login, forgot, reset).
 *
 * @var string $cmsPageTitle Page title for <title>.
 */
$t = $cmsPageTitle ?? 'My Portfolio';
?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($t, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" />
  <link rel="stylesheet" href="cms-admin.css" />

<?php
declare(strict_types=1);
/**
 * Self-hosted Bootstrap + Inter for CMS admin (CONS-C1).
 * Requires vendor-assets.php (via site-bootstrap path from caller).
 */
?>
  <link rel="stylesheet" href="<?= htmlspecialchars(cms_vendor_href_admin('fonts/inter/inter.css'), ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= htmlspecialchars(cms_vendor_href_admin('bootstrap/css/bootstrap.min.css'), ENT_QUOTES, 'UTF-8') ?>" />

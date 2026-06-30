<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
cms_logout();
header('Location: index.php', true, 302);
exit;

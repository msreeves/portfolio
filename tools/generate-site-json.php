<?php
declare(strict_types=1);

$root = dirname(__DIR__);
require $root . '/includes/site-bootstrap.php';

$path = $root . '/data/site.json';
$data = cms_build_defaults();
file_put_contents(
    $path,
    json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
);
echo "Wrote $path (" . count($data) . " keys)\n";

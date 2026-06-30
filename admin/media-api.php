<?php
declare(strict_types=1);

/**
 * JSON API for media library: list, upload, delete (files under public_html/media/).
 * Requires CMS session; changes appear in Hostinger File Manager for the same folder.
 */

require __DIR__ . '/auth.php';
require __DIR__ . '/../includes/site-bootstrap.php';

cms_require_login();

header('Content-Type: application/json; charset=utf-8');

const CMS_MEDIA_MAX_BYTES = 15728640; // 15 MiB

/** @return list<string> */
function cms_media_allowed_extensions(): array
{
    return ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf'];
}

function cms_media_base_path(): ?string
{
    $p = realpath(__DIR__ . '/../media');
    return ($p !== false && is_dir($p)) ? $p : null;
}

/**
 * Resolve ./media/relative/path.ext to absolute file under media/, or null if unsafe / missing.
 */
function cms_media_resolve_existing_file(string $webPath): ?string
{
    $webPath = trim($webPath);
    if ($webPath === '' || !preg_match('#^\./media/(.+)$#', $webPath, $m)) {
        return null;
    }
    $rel = $m[1];
    if (str_contains($rel, '..') || str_contains($rel, "\0")) {
        return null;
    }
    $base = cms_media_base_path();
    if ($base === null) {
        return null;
    }
    $full = $base . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
    $real = realpath($full);
    if ($real === false || !is_file($real) || !str_starts_with($real, $base)) {
        return null;
    }
    $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
    if (!in_array($ext, cms_media_allowed_extensions(), true)) {
        return null;
    }

    return $real;
}

function cms_media_json_lists(): array
{
    return [
        'ok' => true,
        'images' => cms_list_media_image_paths(),
        'pdfs' => cms_list_media_pdf_paths(),
    ];
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'GET' && ($_GET['action'] ?? '') === 'list') {
    try {
        echo json_encode(cms_media_json_lists(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not encode list']);
    }
    exit;
}

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$csrf = (string) ($_POST['csrf'] ?? '');
if (!cms_verify_csrf($csrf)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'Invalid session (CSRF). Reload the page.']);
    exit;
}

$base = cms_media_base_path();
if ($base === null) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'The media/ folder is missing. Create public_html/media/ on the server.']);
    exit;
}

$action = (string) ($_POST['action'] ?? '');

if ($action === 'list') {
    try {
        echo json_encode(cms_media_json_lists(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not encode list']);
    }
    exit;
}

if ($action === 'delete') {
    $path = trim((string) ($_POST['path'] ?? ''));
    $abs = cms_media_resolve_existing_file($path);
    if ($abs === null) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Invalid or unknown file path.']);
        exit;
    }
    if (!@unlink($abs)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not delete the file. Check permissions.']);
        exit;
    }
    try {
        $out = cms_media_json_lists();
        echo json_encode($out, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Deleted but could not refresh list.']);
    }
    exit;
}

if ($action === 'upload') {
    if (!isset($_FILES['file']) || !is_array($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'No file uploaded.']);
        exit;
    }
    $err = (int) ($_FILES['file']['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($err !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Upload failed (code ' . $err . ').']);
        exit;
    }
    $size = (int) ($_FILES['file']['size'] ?? 0);
    if ($size <= 0 || $size > CMS_MEDIA_MAX_BYTES) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'File too large or empty (max 15 MB).']);
        exit;
    }
    $tmp = (string) ($_FILES['file']['tmp_name'] ?? '');
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Invalid upload.']);
        exit;
    }
    $origName = (string) ($_FILES['file']['name'] ?? 'file');
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    if (!in_array($ext, cms_media_allowed_extensions(), true)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'File type not allowed. Use images (jpg, png, gif, webp, svg) or PDF.']);
        exit;
    }
    $sub = $ext === 'pdf' ? 'pdf' : 'images';
    $destDir = $base . DIRECTORY_SEPARATOR . $sub;
    if (!is_dir($destDir) && !@mkdir($destDir, 0755, true)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not create folder media/' . $sub . '/']);
        exit;
    }
    $baseName = pathinfo($origName, PATHINFO_FILENAME);
    $baseName = preg_replace('/[^a-zA-Z0-9._-]+/', '_', $baseName) ?? 'file';
    $baseName = trim($baseName, '._-');
    if ($baseName === '') {
        $baseName = 'upload';
    }
    $safe = $baseName . '.' . $ext;
    $dest = $destDir . DIRECTORY_SEPARATOR . $safe;
    $n = 0;
    while (file_exists($dest)) {
        ++$n;
        $safe = $baseName . '_' . $n . '.' . $ext;
        $dest = $destDir . DIRECTORY_SEPARATOR . $safe;
    }
    if (!@move_uploaded_file($tmp, $dest)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not save file. Check folder permissions.']);
        exit;
    }
    @chmod($dest, 0644);
    $webPath = './media/' . $sub . '/' . $safe;
    try {
        $out = cms_media_json_lists();
        $out['path'] = $webPath;
        echo json_encode($out, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Saved but could not refresh list.']);
    }
    exit;
}

http_response_code(400);
echo json_encode(['ok' => false, 'error' => 'Unknown action.']);

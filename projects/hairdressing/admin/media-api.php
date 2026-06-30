<?php
declare(strict_types=1);
/**
 * Media API for the hairdressing CMS.
 * Actions: list/list_pdf (GET), upload/upload_pdf (POST), delete/delete_pdf (POST).
 * Image files live under ../assets/images/ (./assets/images/...).
 * PDF files live under ../assets/pdf/ (./assets/pdf/...).
 */

const HK_SESSION_KEY = 'hk_cms_authed';
const HK_MAX_UPLOAD  = 15728640; // 15 MiB
const HK_ALLOWED_IMG_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
const HK_ALLOWED_PDF_EXT = ['pdf'];

session_start();
header('Content-Type: application/json; charset=utf-8');

// ─── Auth check ───────────────────────────────────────────────────────────────
if (empty($_SESSION[HK_SESSION_KEY])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Not authenticated.']);
    exit;
}

// ─── CSRF check (POST only) ────────────────────────────────────────────────────
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method === 'POST') {
    $token = (string) ($_POST['csrf'] ?? '');
    $sess  = (string) ($_SESSION['hk_csrf'] ?? '');
    if ($token === '' || $sess === '' || !hash_equals($sess, $token)) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'Invalid session token. Reload the page.']);
        exit;
    }
}

// ─── Helpers ──────────────────────────────────────────────────────────────────
function hk_images_base(): ?string
{
    $p = realpath(__DIR__ . '/../assets/images');
    return ($p !== false && is_dir($p)) ? $p : null;
}

function hk_pdf_base(): ?string
{
    $base = __DIR__ . '/../assets/pdf';
    if (!is_dir($base) && !@mkdir($base, 0755, true)) return null;
    $p = realpath($base);
    return ($p !== false && is_dir($p)) ? $p : null;
}

/** @return list<string> */
function hk_list_images(): array
{
    $base = hk_images_base();
    if ($base === null) return [];

    $result = [];
    try {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($it as $file) {
            if (!$file->isFile()) continue;
            $ext = strtolower($file->getExtension());
            if (!in_array($ext, HK_ALLOWED_IMG_EXT, true)) continue;
            // Ensure file is safely within base
            $real = realpath($file->getPathname());
            if ($real === false || !str_starts_with($real, $base)) continue;
            $rel = str_replace('\\', '/', substr($real, strlen($base)));
            $result[] = './assets/images' . $rel;
        }
    } catch (Throwable) {
        return [];
    }
    sort($result);
    return $result;
}

function hk_resolve_path(string $webPath): ?string
{
    $webPath = trim($webPath);
    if (!preg_match('#^\./assets/images/(.+)$#', $webPath, $m)) return null;
    $rel = $m[1];
    if (str_contains($rel, '..') || str_contains($rel, "\0")) return null;
    $base = hk_images_base();
    if ($base === null) return null;
    $full = $base . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
    $real = realpath($full);
    if ($real === false || !is_file($real) || !str_starts_with($real, $base)) return null;
    $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
    if (!in_array($ext, HK_ALLOWED_IMG_EXT, true)) return null;
    return $real;
}

/** @return list<string> */
function hk_list_pdf(): array
{
    $base = hk_pdf_base();
    if ($base === null) return [];
    $result = [];
    try {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($it as $file) {
            if (!$file->isFile()) continue;
            $ext = strtolower($file->getExtension());
            if (!in_array($ext, HK_ALLOWED_PDF_EXT, true)) continue;
            $real = realpath($file->getPathname());
            if ($real === false || !str_starts_with($real, $base)) continue;
            $rel = str_replace('\\', '/', substr($real, strlen($base)));
            $result[] = './assets/pdf' . $rel;
        }
    } catch (Throwable) {
        return [];
    }
    sort($result);
    return $result;
}

function hk_resolve_pdf_path(string $webPath): ?string
{
    $webPath = trim($webPath);
    if (!preg_match('#^\./assets/pdf/(.+)$#', $webPath, $m)) return null;
    $rel = $m[1];
    if (str_contains($rel, '..') || str_contains($rel, "\0")) return null;
    $base = hk_pdf_base();
    if ($base === null) return null;
    $full = $base . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
    $real = realpath($full);
    if ($real === false || !is_file($real) || !str_starts_with($real, $base)) return null;
    $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
    if (!in_array($ext, HK_ALLOWED_PDF_EXT, true)) return null;
    return $real;
}

function hk_json_list(): array
{
    return ['ok' => true, 'images' => hk_list_images()];
}

function hk_json_list_pdf(): array
{
    return ['ok' => true, 'files' => hk_list_pdf()];
}

// ─── GET list ─────────────────────────────────────────────────────────────────
if ($method === 'GET') {
    $gAction = (string) ($_GET['action'] ?? '');
    try {
        $out = $gAction === 'list_pdf' ? hk_json_list_pdf() : hk_json_list();
        echo json_encode($out, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not encode list.']);
    }
    exit;
}

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed.']);
    exit;
}

$action = (string) ($_POST['action'] ?? '');

// ─── POST list ────────────────────────────────────────────────────────────────
if ($action === 'list') {
    try {
        echo json_encode(hk_json_list(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not encode list.']);
    }
    exit;
}

// ─── POST list (pdf) ───────────────────────────────────────────────────────────
if ($action === 'list_pdf') {
    try {
        echo json_encode(hk_json_list_pdf(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not encode list.']);
    }
    exit;
}

// ─── DELETE ───────────────────────────────────────────────────────────────────
if ($action === 'delete') {
    $path = trim((string) ($_POST['path'] ?? ''));
    $abs  = hk_resolve_path($path);
    if ($abs === null) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Invalid or unknown file path.']);
        exit;
    }
    if (!@unlink($abs)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not delete file. Check folder permissions.']);
        exit;
    }
    try {
        echo json_encode(hk_json_list(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Deleted but could not refresh list.']);
    }
    exit;
}

// ─── DELETE pdf ────────────────────────────────────────────────────────────────
if ($action === 'delete_pdf') {
    $path = trim((string) ($_POST['path'] ?? ''));
    $abs  = hk_resolve_pdf_path($path);
    if ($abs === null) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Invalid or unknown file path.']);
        exit;
    }
    if (!@unlink($abs)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not delete file. Check folder permissions.']);
        exit;
    }
    try {
        echo json_encode(hk_json_list_pdf(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Deleted but could not refresh list.']);
    }
    exit;
}

// ─── UPLOAD ───────────────────────────────────────────────────────────────────
if ($action === 'upload') {
    if (!isset($_FILES['file']) || !is_array($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'No file uploaded.']);
        exit;
    }
    $err = (int) ($_FILES['file']['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($err !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Upload error (code ' . $err . ').']);
        exit;
    }
    $size = (int) ($_FILES['file']['size'] ?? 0);
    if ($size <= 0 || $size > HK_MAX_UPLOAD) {
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
    if (!in_array($ext, HK_ALLOWED_IMG_EXT, true)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'File type not allowed. Use jpg, png, gif, or webp.']);
        exit;
    }
    $base    = hk_images_base();
    $destDir = $base . DIRECTORY_SEPARATOR . 'uploads';
    if (!is_dir($destDir) && !@mkdir($destDir, 0755, true)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not create uploads folder.']);
        exit;
    }
    $baseName = pathinfo($origName, PATHINFO_FILENAME);
    $baseName = preg_replace('/[^a-zA-Z0-9._-]+/', '_', $baseName) ?? 'upload';
    $baseName = trim($baseName, '._-') ?: 'upload';
    $safe     = $baseName . '.' . $ext;
    $dest     = $destDir . DIRECTORY_SEPARATOR . $safe;
    $n = 0;
    while (file_exists($dest)) {
        ++$n;
        $safe = $baseName . '_' . $n . '.' . $ext;
        $dest = $destDir . DIRECTORY_SEPARATOR . $safe;
    }
    if (!@move_uploaded_file($tmp, $dest)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not save file. Check permissions.']);
        exit;
    }
    @chmod($dest, 0644);
    $webPath = './assets/images/uploads/' . $safe;
    try {
        $out          = hk_json_list();
        $out['path']  = $webPath;
        echo json_encode($out, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Saved but could not refresh list.']);
    }
    exit;
}

// ─── UPLOAD pdf ────────────────────────────────────────────────────────────────
if ($action === 'upload_pdf') {
    if (!isset($_FILES['file']) || !is_array($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'No file uploaded.']);
        exit;
    }
    $err = (int) ($_FILES['file']['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($err !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Upload error (code ' . $err . ').']);
        exit;
    }
    $size = (int) ($_FILES['file']['size'] ?? 0);
    if ($size <= 0 || $size > HK_MAX_UPLOAD) {
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
    $origName = (string) ($_FILES['file']['name'] ?? 'file.pdf');
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    if (!in_array($ext, HK_ALLOWED_PDF_EXT, true)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'File type not allowed. Use PDF only.']);
        exit;
    }
    $base    = hk_pdf_base();
    if ($base === null) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not access PDF folder.']);
        exit;
    }
    $destDir = $base . DIRECTORY_SEPARATOR . 'uploads';
    if (!is_dir($destDir) && !@mkdir($destDir, 0755, true)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not create uploads folder.']);
        exit;
    }
    $baseName = pathinfo($origName, PATHINFO_FILENAME);
    $baseName = preg_replace('/[^a-zA-Z0-9._-]+/', '_', $baseName) ?? 'upload';
    $baseName = trim($baseName, '._-') ?: 'upload';
    $safe = $baseName . '.pdf';
    $dest = $destDir . DIRECTORY_SEPARATOR . $safe;
    $n = 0;
    while (file_exists($dest)) {
        ++$n;
        $safe = $baseName . '_' . $n . '.pdf';
        $dest = $destDir . DIRECTORY_SEPARATOR . $safe;
    }
    if (!@move_uploaded_file($tmp, $dest)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Could not save file. Check permissions.']);
        exit;
    }
    @chmod($dest, 0644);
    $webPath = './assets/pdf/uploads/' . $safe;
    try {
        $out = hk_json_list_pdf();
        $out['path'] = $webPath;
        echo json_encode($out, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Saved but could not refresh list.']);
    }
    exit;
}

http_response_code(400);
echo json_encode(['ok' => false, 'error' => 'Unknown action.']);

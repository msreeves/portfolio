<?php
declare(strict_types=1);

/**
 * Self-hosted vendor paths (CONS-C1) — see scripts/sync-vendor.mjs.
 */
function cms_vendor_manifest(): array
{
    static $manifest = null;
    if ($manifest !== null) {
        return $manifest;
    }
    $path = __DIR__ . '/../vendor/manifest.json';
    if (!is_readable($path)) {
        return $manifest = [];
    }
    $decoded = json_decode((string) file_get_contents($path), true);
    return $manifest = is_array($decoded) ? $decoded : [];
}

function cms_vendor_v(): string
{
    $m = cms_vendor_manifest();
    if ($m === []) {
        return '1';
    }
    $raw = ($m['bootstrap'] ?? '') . ($m['fontawesome'] ?? '') . ($m['generatedAt'] ?? '');
    return substr(hash('sha256', $raw), 0, 12);
}

function cms_vendor_uri(string $relative): string
{
    return 'vendor/' . ltrim($relative, '/');
}

function cms_vendor_href(string $relative): string
{
    $q = cms_vendor_v();
    return './' . cms_vendor_uri($relative) . '?v=' . rawurlencode($q);
}

/** Admin pages live under /admin/ — vendor is one level up. */
function cms_vendor_href_admin(string $relative): string
{
    $q = cms_vendor_v();
    return '../' . cms_vendor_uri($relative) . '?v=' . rawurlencode($q);
}

function cms_vendor_base_admin(string $relative): string
{
    return '../' . cms_vendor_uri($relative);
}

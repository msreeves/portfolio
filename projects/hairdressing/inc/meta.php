<?php
declare(strict_types=1);
/**
 * Shared PHP head include.
 * Set $page (string key) before requiring this file.
 * Provides: $metaTitle, $metaDesc, $ogImage, $brandName, $fallbackImagesJson
 */

$_incContentPath = dirname(__FILE__) . '/../content/site-content.json';
$_mcRaw = is_readable($_incContentPath) ? (string) file_get_contents($_incContentPath) : '{}';
$_mc = json_decode($_mcRaw, true) ?? [];

$_pageKey  = $page ?? 'home';
$brandName = htmlspecialchars((string) ($_mc['site']['brandName'] ?? 'Hayley Kharsa Hair Studio'), ENT_QUOTES, 'UTF-8');
$metaTitle = htmlspecialchars((string) ($_mc['pages'][$_pageKey]['metaTitle'] ?? $_mc['site']['brandName'] ?? 'Hayley Kharsa Hair Studio'), ENT_QUOTES, 'UTF-8');
$metaDesc  = htmlspecialchars((string) ($_mc['pages'][$_pageKey]['metaDescription'] ?? $_mc['site']['metaDescription'] ?? ''), ENT_QUOTES, 'UTF-8');
$ogImage   = htmlspecialchars((string) ($_mc['hero']['image']['url'] ?? ''), ENT_QUOTES, 'UTF-8');

$_fallbackPool = [
    'https://images.pexels.com/photos/3992873/pexels-photo-3992873.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'https://images.pexels.com/photos/853427/pexels-photo-853427.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'https://images.pexels.com/photos/3065171/pexels-photo-3065171.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'https://images.pexels.com/photos/3762800/pexels-photo-3762800.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'https://images.pexels.com/photos/3993323/pexels-photo-3993323.jpeg?auto=compress&cs=tinysrgb&w=1200',
    'https://images.pexels.com/photos/4619091/pexels-photo-4619091.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/3993440/pexels-photo-3993440.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/3757942/pexels-photo-3757942.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/4100672/pexels-photo-4100672.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/3738383/pexels-photo-3738383.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/2040189/pexels-photo-2040189.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/3993452/pexels-photo-3993452.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/3997988/pexels-photo-3997988.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/3065177/pexels-photo-3065177.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/1187079/pexels-photo-1187079.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/3738357/pexels-photo-3738357.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/1804481/pexels-photo-1804481.jpeg?auto=compress&cs=tinysrgb&w=900',
    'https://images.pexels.com/photos/897262/pexels-photo-897262.jpeg?auto=compress&cs=tinysrgb&w=900',
];
$fallbackImagesJson = json_encode($_fallbackPool, JSON_UNESCAPED_UNICODE);

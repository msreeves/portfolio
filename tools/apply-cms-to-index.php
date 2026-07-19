<?php
/**
 * One-time splice: replace fragment HTML in index.php with content_html() calls.
 * Re-run only if index.php is restored from backup.
 */
declare(strict_types=1);

$root = dirname(__DIR__);
$idxPath = $root . '/index.php';
$fragDir = $root . '/data/fragments/';

$map = [
    'introduction_1.html' => 'html_introduction_1',
    'introduction_2.html' => 'html_introduction_2',
    'recent_portfolio_1.html' => 'html_recent_portfolio_1',
    'recent_portfolio_2.html' => 'html_recent_portfolio_2',
    'work_bsi.html' => 'html_work_bsi',
    'work_nexus.html' => 'html_work_nexus',
    'work_markallen.html' => 'html_work_markallen',
    'work_gaming_intro.html' => 'html_work_gaming_intro',
    'work_rusi.html' => 'html_work_rusi',
    'work_indigo.html' => 'html_work_indigo',
    'skills_courses.html' => 'html_skills_courses',
    'testimonial_1.html' => 'html_testimonial_1',
    'testimonial_2.html' => 'html_testimonial_2',
    'testimonial_3.html' => 'html_testimonial_3',
    'portfolio_1.html' => 'html_portfolio_1',
    'portfolio_2.html' => 'html_portfolio_2',
    'portfolio_3.html' => 'html_portfolio_3',
    'portfolio_4.html' => 'html_portfolio_4',
    'portfolio_5.html' => 'html_portfolio_5',
    'portfolio_6.html' => 'html_portfolio_6',
    'games_tested.html' => 'html_games_tested',
    'timeline_1.html' => 'html_timeline_1',
    'timeline_2.html' => 'html_timeline_2',
    'timeline_3.html' => 'html_timeline_3',
    'timeline_4.html' => 'html_timeline_4',
    'timeline_5.html' => 'html_timeline_5',
    'timeline_6.html' => 'html_timeline_6',
    'timeline_7.html' => 'html_timeline_7',
];

$html = (string) file_get_contents($idxPath);
$origLen = strlen($html);

foreach ($map as $file => $key) {
    $path = $fragDir . $file;
    if (!is_readable($path)) {
        fwrite(STDERR, "Missing fragment: $file\n");
        continue;
    }
    $needle = file_get_contents($path);
    if ($needle === false) {
        continue;
    }
    $replacement = "\n<?php content_html(\$content, '" . $key . "'); ?>\n";
    $count = 0;
    $html = str_replace($needle, $replacement, $html, $count);
    if ($count !== 1) {
        fwrite(STDERR, "Replace $key: expected 1 match, got $count ($file)\n");
    }
}

if ($html === '') {
    fwrite(STDERR, "Empty result.\n");
    exit(1);
}

file_put_contents($idxPath, $html);
echo 'OK index.php updated, bytes ' . $origLen . ' -> ' . strlen($html) . PHP_EOL;

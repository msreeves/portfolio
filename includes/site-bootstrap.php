<?php
declare(strict_types=1);

/**
 * CMS html_* keys ↔ default snippet files under data/fragments/ (used when building defaults / key list; not shown in admin).
 */
function cms_fragment_map(): array
{
    return [
        'html_introduction_1' => 'introduction_1.html',
        'html_introduction_2' => 'introduction_2.html',
        'html_recent_portfolio_1' => 'recent_portfolio_1.html',
        'html_recent_portfolio_2' => 'recent_portfolio_2.html',
        'html_work_nexus' => 'work_nexus.html',
        'html_work_markallen' => 'work_markallen.html',
        'html_work_gaming_intro' => 'work_gaming_intro.html',
        'html_work_indigo' => 'work_indigo.html',
        'html_skills_courses' => 'skills_courses.html',
        'html_testimonial_1' => 'testimonial_1.html',
        'html_testimonial_2' => 'testimonial_2.html',
        'html_testimonial_3' => 'testimonial_3.html',
        'html_portfolio_1' => 'portfolio_1.html',
        'html_portfolio_2' => 'portfolio_2.html',
        'html_portfolio_3' => 'portfolio_3.html',
        'html_portfolio_4' => 'portfolio_4.html',
        'html_portfolio_5' => 'portfolio_5.html',
        'html_portfolio_6' => 'portfolio_6.html',
        'html_games_tested' => 'games_tested.html',
        'html_timeline_1' => 'timeline_1.html',
        'html_timeline_2' => 'timeline_2.html',
        'html_timeline_3' => 'timeline_3.html',
        'html_timeline_4' => 'timeline_4.html',
        'html_timeline_5' => 'timeline_5.html',
        'html_timeline_6' => 'timeline_6.html',
        'html_timeline_7' => 'timeline_7.html',
    ];
}

/** Max stored homepage timeline slides (html_timeline_N + img_timeline_N). */
function cms_timeline_max_slides(): int
{
    return 20;
}

/** Human-readable labels for HTML fragment fields (admin UI). */
function cms_fragment_labels(): array
{
    return [
        'html_introduction_1' => 'Introduction — block 1',
        'html_introduction_2' => 'Introduction — block 2',
        'html_recent_portfolio_1' => 'Recent portfolio — item 1',
        'html_recent_portfolio_2' => 'Recent portfolio — item 2',
        'html_work_nexus' => 'Work experience — Nexus',
        'html_work_markallen' => 'Work experience — Mark Allen Group',
        'html_work_gaming_intro' => 'Work experience — gaming / intro',
        'html_work_indigo' => 'Work experience — Indigo Pearl',
        'html_skills_courses' => 'Skills — online courses & list',
        'html_testimonial_1' => 'Testimonials accordion — panel 1 (name + quote)',
        'html_testimonial_2' => 'Testimonials accordion — panel 2 (name + quote)',
        'html_testimonial_3' => 'Testimonials accordion — panel 3 (name + quote)',
        'html_portfolio_1' => 'Portfolio overlay — piece 1',
        'html_portfolio_2' => 'Portfolio overlay — piece 2',
        'html_portfolio_3' => 'Portfolio overlay — piece 3',
        'html_portfolio_4' => 'Portfolio overlay — piece 4',
        'html_portfolio_5' => 'Portfolio overlay — piece 5',
        'html_portfolio_6' => 'Portfolio overlay — piece 6',
        'html_games_tested' => 'Games tested — list',
        'html_timeline_1' => 'Timeline carousel — slide 1 (role, dates, location, body)',
        'html_timeline_2' => 'Timeline carousel — slide 2 (role, dates, location, body)',
        'html_timeline_3' => 'Timeline carousel — slide 3 (role, dates, location, body)',
        'html_timeline_4' => 'Timeline carousel — slide 4 (role, dates, location, body)',
        'html_timeline_5' => 'Timeline carousel — slide 5 (role, dates, location, body)',
        'html_timeline_6' => 'Timeline carousel — slide 6 (role, dates, location, body)',
        'html_timeline_7' => 'Timeline carousel — slide 7 (role, dates, location, body)',
    ];
}

function cms_heading_defaults(): array
{
    return [
        'heading_recent_portfolio' => 'RECENT PORTFOLIO',
        'heading_work_for' => 'PREVIOUS WORK EXPERIENCE',
        'heading_skills' => 'MY SKILLS',
        'heading_testimonials' => 'TESTIMONIALS',
        'heading_portfolio' => 'PAST PORTFOLIO WORK',
        'heading_game_test' => 'GAMES TESTED',
        'heading_timeline' => 'TIMELINE',
        'footer_contact_heading' => 'Contact Me',
        'footer_copyright' => '© Copyright 2026 Michael Reeves | All rights reserved',
        'contact_band_heading' => 'Get in touch',
        'contact_band_intent' => 'Open to front-end, WordPress, and CMS roles — permanent, contract, or hybrid/remote.',
        'contact_band_email' => 'reevesy87@hotmail.co.uk',
    ];
}

/** Image paths (relative to site root, ./media/...). Editable in admin. */
function cms_image_paths_defaults(): array
{
    $base = [
        'img_intro_logo' => './media/images/icons/LOGO.jpg',
        'img_footer_logo' => './media/images/icons/LOGO.png',
        'img_gallery_1' => './media/images/icons/ei-logo.png',
        'img_gallery_2' => './media/images/icons/hi-logo.png',
        'img_gallery_3' => './media/images/icons/ct-logo.png',
        'img_gallery_4' => './media/images/icons/ct-oc.png',
        'img_gallery_5' => './media/images/icons/nmt-logo.png',
        'img_gallery_6' => './media/images/icons/nmt-oc-logo.png',
        'img_gallery_7' => './media/images/icons/bwie-logo.png',
        'img_gallery_8' => './media/images/icons/ism.png',
        'img_skill_canva' => './media/images/icons/canva.png',
        'img_skill_grip' => './media/images/icons/grip.png',
        'img_portfolio_1' => './media/images/portfolio/sample-article.png',
        'img_portfolio_2' => './media/images/portfolio/sample-tailwind.png',
        'img_portfolio_3' => './media/images/portfolio/moviedata.png',
        'img_portfolio_4' => './media/images/portfolio/hangmanicon.png',
        'img_portfolio_5' => './media/images/portfolio/wigportfolio.png',
        'img_portfolio_6' => './media/images/portfolio/mystory.png',
        'img_timeline_1' => './media/images/icons/Indigo_Game_logo.png',
        'img_timeline_2' => './media/images/icons/work-logo.png',
        'img_timeline_3' => './media/images/icons/Fern_Noble_logo.png',
        'img_timeline_4' => './media/images/icons/just-it.png',
        'img_timeline_5' => './media/images/icons/swansea-met-logo.png',
        'img_timeline_6' => './media/images/icons/coleg-gwent.png',
        'img_timeline_7' => './media/images/icons/coleg-gwent.png',
    ];
    $fallback = $base['img_timeline_7'];
    for ($i = 8; $i <= cms_timeline_max_slides(); ++$i) {
        $base['img_timeline_' . $i] = $fallback;
    }

    return $base;
}

function cms_image_labels(): array
{
    return [
        'img_intro_logo' => 'Intro — main photo (left column)',
        'img_footer_logo' => 'Footer — logo',
        'img_gallery_1' => 'About — Education Investor logo',
        'img_gallery_2' => 'About — Health Investor logo',
        'img_gallery_3' => 'About — Caring Times logo',
        'img_gallery_4' => 'About — CT Owners Club logo',
        'img_gallery_5' => 'About — NMT Magazine logo',
        'img_gallery_6' => 'About — NMT Owners Club logo',
        'img_gallery_7' => 'About — BWIE logo',
        'img_gallery_8' => 'About — ISM logo',
        'img_skill_canva' => 'Skills — Canva tile image',
        'img_skill_grip' => 'Skills — Grip tile image',
        'img_portfolio_1' => 'Portfolio — thumbnail 1 (Sample Articles)',
        'img_portfolio_2' => 'Portfolio — thumbnail 2 (Tailwind)',
        'img_portfolio_3' => 'Portfolio — thumbnail 3 (Movie Searcher)',
        'img_portfolio_4' => 'Portfolio — thumbnail 4 (Hangman)',
        'img_portfolio_5' => 'Portfolio — thumbnail 5 (Hairdressing)',
        'img_portfolio_6' => 'Portfolio — thumbnail 6 (My Story)',
        'img_timeline_1' => 'Timeline carousel — slide 1 icon',
        'img_timeline_2' => 'Timeline carousel — slide 2 icon',
        'img_timeline_3' => 'Timeline carousel — slide 3 icon',
        'img_timeline_4' => 'Timeline carousel — slide 4 icon',
        'img_timeline_5' => 'Timeline carousel — slide 5 icon',
        'img_timeline_6' => 'Timeline carousel — slide 6 icon',
        'img_timeline_7' => 'Timeline carousel — slide 7 icon',
    ];
}

/** Section ids on the homepage for in-page nav (scroll). */
function cms_site_nav_scroll_sections(): array
{
    return [
        'intro' => 'Home (top)',
        'introduction' => 'About Me',
        'recent-portfolio' => 'Featured Case Studies',
        'work-for' => 'Previous Work Experience',
        'skills' => 'Skills',
        'testimonials' => 'Testimonials',
        'portfolio' => 'Personal Portfolio',
        'game-test' => 'Games Tested',
        'timeline' => 'Timeline',
        'contact' => 'Contact',
        'contact-band' => 'Get in touch',
    ];
}

/** @return list<string> */
function cms_site_nav_scroll_id_whitelist(): array
{
    return array_keys(cms_site_nav_scroll_sections());
}

/**
 * Default header nav (matches legacy hard-coded menu).
 *
 * @return list<array{label: string, type: string, target: string}>
 */
function cms_site_nav_default_items(): array
{
    return [
        ['label' => 'Home', 'type' => 'scroll', 'target' => 'intro'],
        ['label' => 'About', 'type' => 'scroll', 'target' => 'introduction'],
        ['label' => 'Case Studies', 'type' => 'scroll', 'target' => 'recent-portfolio'],
        ['label' => 'Experience', 'type' => 'scroll', 'target' => 'work-for'],
        ['label' => 'Skills', 'type' => 'scroll', 'target' => 'skills'],
        ['label' => 'Contact', 'type' => 'scroll', 'target' => 'contact-band'],
    ];
}

function cms_site_nav_default_json(): string
{
    try {
        return json_encode(cms_site_nav_default_items(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        return '[]';
    }
}

function cms_sanitize_nav_url(string $u): string
{
    $u = trim($u);
    if ($u === '') {
        return './';
    }
    if (str_starts_with(strtolower($u), 'javascript:')) {
        return './';
    }
    if (preg_match('#^mailto:[^\s<>"\']+$#i', $u) === 1) {
        return $u;
    }
    if (preg_match('#^tel:[^\s<>"\']+$#i', $u) === 1) {
        return $u;
    }
    if (str_starts_with($u, '#') && preg_match('#^#[\w\-]+$#', $u) === 1) {
        return $u;
    }
    if (str_starts_with($u, './') && !str_contains($u, '..') && preg_match('#^\./[\w\-./%]+$#', $u) === 1) {
        return $u;
    }
    if (str_starts_with($u, '/') && !str_starts_with($u, '//') && preg_match('#^/[\w\-./%]*$#', $u) === 1) {
        return $u;
    }

    $normalized = cms_normalize_external_web_url($u);
    if ($normalized !== '') {
        return $normalized;
    }

    return './';
}

function cms_normalize_external_web_url(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '';
    }
    if (preg_match('#[<>"\'\s]#', $url) === 1) {
        return '';
    }

    $looksLikeDomain = preg_match(
        '#^(?:www\.)?[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?(?:\.[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?)+(?:[/?\#].*)?$#i',
        $url
    ) === 1;
    if (preg_match('#^[a-z][a-z0-9+\-.]*://#i', $url) !== 1 && $looksLikeDomain) {
        $url = 'https://' . $url;
    }

    if (preg_match('#^https?://[^\s<>"\']+$#i', $url) !== 1) {
        return '';
    }

    $parts = parse_url($url);
    if (!is_array($parts) || !isset($parts['host'])) {
        return '';
    }

    $scheme = strtolower((string) ($parts['scheme'] ?? 'https'));
    if (!in_array($scheme, ['http', 'https'], true)) {
        return '';
    }

    $host = strtolower((string) $parts['host']);
    if ($host === '') {
        return '';
    }

    $isLocal = $host === 'localhost' || filter_var($host, FILTER_VALIDATE_IP) !== false;
    if (!$isLocal && !str_starts_with($host, 'www.')) {
        $host = 'www.' . $host;
    }

    $rebuilt = $scheme . '://';
    if (isset($parts['user']) && $parts['user'] !== '') {
        $rebuilt .= $parts['user'];
        if (isset($parts['pass']) && $parts['pass'] !== '') {
            $rebuilt .= ':' . $parts['pass'];
        }
        $rebuilt .= '@';
    }
    $rebuilt .= $host;
    if (isset($parts['port'])) {
        $rebuilt .= ':' . (int) $parts['port'];
    }
    $rebuilt .= $parts['path'] ?? '/';
    if (isset($parts['query']) && $parts['query'] !== '') {
        $rebuilt .= '?' . $parts['query'];
    }
    if (isset($parts['fragment']) && $parts['fragment'] !== '') {
        $rebuilt .= '#' . $parts['fragment'];
    }

    return $rebuilt;
}

/**
 * @return list<array{label: string, type: string, target: string}>
 */
function cms_site_nav_decode_array(array $content): array
{
    $raw = trim((string) ($content['site_nav_json'] ?? ''));
    if ($raw === '') {
        return cms_site_nav_default_items();
    }
    try {
        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        return cms_site_nav_default_items();
    }
    if (!is_array($data)) {
        return cms_site_nav_default_items();
    }
    if ($data === []) {
        return [];
    }
    $whitelist = cms_site_nav_scroll_id_whitelist();
    $out = [];
    foreach ($data as $row) {
        if (!is_array($row)) {
            continue;
        }
        $label = trim((string) ($row['label'] ?? ''));
        if ($label === '') {
            continue;
        }
        $type = (($row['type'] ?? '') === 'url') ? 'url' : 'scroll';
        $target = trim((string) ($row['target'] ?? ''));
        if ($type === 'scroll') {
            if (!in_array($target, $whitelist, true)) {
                $target = 'intro';
            }
        } else {
            $target = cms_sanitize_nav_url($target);
        }
        $out[] = ['label' => $label, 'type' => $type, 'target' => $target];
    }

    return $out;
}

/**
 * @param array{label: string, type: string, target: string} $item
 */
function cms_site_nav_href(array $item): string
{
    $type = (($item['type'] ?? '') === 'url') ? 'url' : 'scroll';
    if ($type === 'scroll') {
        $id = (string) ($item['target'] ?? 'intro');
        if (!in_array($id, cms_site_nav_scroll_id_whitelist(), true)) {
            $id = 'intro';
        }

        return 'javascript:myscroll(\'' . $id . '\')';
    }

    return cms_sanitize_nav_url((string) ($item['target'] ?? './'));
}

/**
 * @return list<array{label: string, href: string}>
 */
function cms_site_nav_items_for_render(array $content): array
{
    $out = [];
    foreach (cms_site_nav_decode_array($content) as $it) {
        $out[] = [
            'label' => $it['label'],
            'href' => cms_site_nav_href($it),
        ];
    }

    return $out;
}

function cms_site_nav_encode_from_post(array $post): string
{
    /** @var mixed $labels */
    $labels = $post['nav_label'] ?? [];
    /** @var mixed $types */
    $types = $post['nav_type'] ?? [];
    /** @var mixed $scroll */
    $scroll = $post['nav_target_scroll'] ?? [];
    /** @var mixed $url */
    $url = $post['nav_target_url'] ?? [];
    if (!is_array($labels)) {
        $labels = [];
    }
    if (!is_array($types)) {
        $types = [];
    }
    if (!is_array($scroll)) {
        $scroll = [];
    }
    if (!is_array($url)) {
        $url = [];
    }
    $n = max(count($labels), count($types), count($scroll), count($url));
    $out = [];
    $whitelist = cms_site_nav_scroll_id_whitelist();
    for ($i = 0; $i < $n; ++$i) {
        $label = trim((string) ($labels[$i] ?? ''));
        if ($label === '') {
            continue;
        }
        $type = (($types[$i] ?? '') === 'url') ? 'url' : 'scroll';
        if ($type === 'scroll') {
            $tid = trim((string) ($scroll[$i] ?? ''));
            if (!in_array($tid, $whitelist, true)) {
                $tid = 'intro';
            }
            $target = $tid;
        } else {
            $target = cms_sanitize_nav_url((string) ($url[$i] ?? ''));
        }
        $out[] = ['label' => $label, 'type' => $type, 'target' => $target];
    }
    if (count($out) > cms_site_nav_max_rows()) {
        $out = array_slice($out, 0, cms_site_nav_max_rows());
    }
    try {
        return json_encode($out, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        return cms_site_nav_default_json();
    }
}

function cms_site_nav_max_rows(): int
{
    return 15;
}

/**
 * @return list<string> paths like ./media/images/foo.png
 */
function cms_list_media_image_paths(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $base = realpath(__DIR__ . '/../media');
    if ($base === false || !is_dir($base)) {
        $cache = [];

        return $cache;
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    $out = [];
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $file) {
        if (!$file->isFile()) {
            continue;
        }
        $ext = strtolower($file->getExtension());
        if (!in_array($ext, $allowed, true)) {
            continue;
        }
        $full = $file->getRealPath();
        if ($full === false || !str_starts_with($full, $base)) {
            continue;
        }
        $rel = substr($full, strlen($base));
        $rel = str_replace('\\', '/', $rel);
        $out[] = './media' . $rel;
    }
    $out = array_values(array_unique($out));
    sort($out);
    $cache = $out;

    return $cache;
}

/**
 * @return list<string> paths like ./media/pdf/foo.pdf
 */
function cms_list_media_pdf_paths(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $base = realpath(__DIR__ . '/../media');
    if ($base === false || !is_dir($base)) {
        $cache = [];

        return $cache;
    }

    $out = [];
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $file) {
        if (!$file->isFile()) {
            continue;
        }
        if (strtolower($file->getExtension()) !== 'pdf') {
            continue;
        }
        $full = $file->getRealPath();
        if ($full === false || !str_starts_with($full, $base)) {
            continue;
        }
        $rel = substr($full, strlen($base));
        $rel = str_replace('\\', '/', $rel);
        $out[] = './media' . $rel;
    }
    $out = array_values(array_unique($out));
    sort($out);
    $cache = $out;

    return $cache;
}

function cms_sanitize_pdf_path(string $path): string
{
    $path = trim($path);
    if ($path === '' || str_contains($path, '..') || str_contains($path, "\0")) {
        return '';
    }
    if (!preg_match('#^\./media/[\w\-./%]+$#', $path)) {
        return '';
    }
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if ($ext !== 'pdf') {
        return '';
    }

    return $path;
}

/** Course link target: PDF under ./media (preferred), or legacy image path. */
function cms_sanitize_skills_course_url(string $path): string
{
    $pdf = cms_sanitize_pdf_path($path);
    if ($pdf !== '') {
        return $pdf;
    }

    return cms_sanitize_image_path($path);
}

function cms_sanitize_image_path(string $path): string
{
    $path = trim($path);
    if ($path === '' || str_contains($path, '..') || str_contains($path, "\0")) {
        return '';
    }
    if (!preg_match('#^\./media/[\w\-./%]+$#', $path)) {
        return '';
    }
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], true)) {
        return '';
    }

    return $path;
}

function cms_img_src(array $content, string $key): string
{
    $defaults = cms_image_paths_defaults();
    $v = trim((string) ($content[$key] ?? ''));
    if ($v === '') {
        return $defaults[$key] ?? '';
    }
    $clean = cms_sanitize_image_path($v);

    return $clean !== '' ? $clean : ($defaults[$key] ?? '');
}

/** Accessible alt text derived from CMS image field labels. */
function cms_img_alt_for_key(string $key): string
{
    static $overrides = [
        'img_intro_logo' => 'Michael Reeves',
        'img_footer_logo' => 'Michael Reeves logo',
    ];
    if (isset($overrides[$key])) {
        return $overrides[$key];
    }

    $label = cms_image_labels()[$key] ?? '';
    if ($label === '') {
        return '';
    }
    if (str_contains($label, ' — ')) {
        $parts = explode(' — ', $label, 2);
        $tail = trim($parts[1] ?? $label);
        if (str_starts_with($tail, 'About — ')) {
            return trim(substr($tail, strlen('About — ')));
        }
        if (preg_match('/^Portfolio — thumbnail \d+ \((.+)\)$/', $tail, $m)) {
            return trim($m[1]);
        }
        if (preg_match('/^Skills — (.+) tile image$/', $tail, $m)) {
            return trim($m[1]);
        }
        if (preg_match('/^Timeline carousel — slide \d+ icon$/', $tail, $m)) {
            return 'Timeline employer logo';
        }

        return $tail;
    }

    return $label;
}
function cms_load_portfolio_projects(): array
{
    $dir = __DIR__ . '/../projects';
    if (!is_dir($dir)) {
        return [];
    }
    $projectFiles = glob($dir . '/*.json') ?: [];
    if ($projectFiles === []) {
        return [];
    }

    $projects = [];
    foreach ($projectFiles as $file) {
        $raw = @file_get_contents($file);
        if ($raw === false) continue;

        $data = json_decode($raw, true);
        if (!is_array($data)) continue;

        if (array_key_exists('active', $data)) {
            $isActive = filter_var($data['active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($isActive === false) continue;
        }

        $title = trim((string)($data['title'] ?? ''));
        $thumb = trim((string)($data['thumb'] ?? ''));
        if ($title === '' || $thumb === '') continue;

        $projects[] = [
            'title' => $title,
            'stack' => trim((string)($data['stack'] ?? '')),
            'summary' => trim((string)($data['summary'] ?? '')),
            'thumb' => $thumb,
            'view_url' => trim((string)($data['view_url'] ?? '')),
            'code_url' => trim((string)($data['code_url'] ?? '')),
            'order' => (int)($data['order'] ?? 9999),
        ];
    }

    usort($projects, static function (array $a, array $b): int {
        return [$a['order'], $a['title']] <=> [$b['order'], $b['title']];
    });

    return $projects;
}

/** MSR programme case studies for the featured grid (code-side; URLs are release targets). */
function cms_msr_case_study_cards(): array
{
    return [
        [
            'title' => 'MSR Events hub',
            'stack' => 'WordPress multisite · programme lifecycle',
            'summary' => 'Events hub with lifecycle bands, editorial refresh, and acceptance gates.',
            'view_url' => 'https://www.msreeves.co.uk/events/',
            'code_url' => 'https://github.com/msreeves/msrevents',
        ],
        [
            'title' => 'MSR Awards',
            'stack' => 'Dark prestige theme · nominees & judging',
            'summary' => 'Awards programme UX, featured nominees, and portfolio-ready demo content.',
            'view_url' => 'https://www.msreeves.co.uk/events/msrawards/',
            'code_url' => 'https://github.com/msreeves/msrawards',
        ],
        [
            'title' => 'MSR Seminars',
            'stack' => 'Agenda · panelists · delegate programme',
            'summary' => 'Seminars archive, session cards, and programme editorial polish.',
            'view_url' => 'https://www.msreeves.co.uk/events/msrseminars/',
            'code_url' => 'https://github.com/msreeves/msrseminars',
        ],
        [
            'title' => 'MSR Products',
            'stack' => 'WooCommerce showcase',
            'summary' => 'Products demo with theme build pipeline and smoke-tested routes.',
            'view_url' => 'https://www.msreeves.co.uk/msrproducts/',
            'code_url' => 'https://github.com/msreeves/msrproducts',
        ],
        [
            'title' => 'Atlas Briefing',
            'stack' => 'B2B digital publisher · gated resources',
            'summary' => 'Publishing demo with resource library, topics, subscribe, and lead-gen flows.',
            'view_url' => 'https://www.msreeves.co.uk/msrsandbox/',
            'code_url' => 'https://github.com/msreeves/msrsandbox',
        ],
    ];
}

function cms_intro_tagline_for_hero(array $content): string
{
    $short = trim((string) ($content['intro_tagline_short'] ?? ''));
    if ($short !== '') {
        return $short;
    }

    return trim((string) ($content['intro_tagline'] ?? ''));
}



function cms_portfolio_project_json_files(): array
{
    $abs = __DIR__ . '/../projects';
    if (!is_dir($abs)) {
        return [];
    }
    $files = glob($abs . '/*.json') ?: [];
    if ($files === []) {
        return [];
    }
    sort($files, SORT_NATURAL | SORT_FLAG_CASE);

    $out = [];
    foreach ($files as $f) {
        $out[] = './projects/' . basename($f);
    }

    return $out;
}

function cms_build_defaults(): array
{
    $out = array_merge(
        [
            'intro_name' => 'My name is Michael Reeves',
            'intro_tagline' => 'Marketing & Digital Content Executive | Front-end Web/Wordpress Developer | Designer | Games Tester',
            'intro_tagline_short' => 'Front-end WordPress developer · CMS editor · digital content & marketing',
            'about_heading' => 'ABOUT ME',
            'site_nav_json' => cms_site_nav_default_json(),
            'timeline_count' => 0,
        ],
        cms_heading_defaults(),
        cms_image_paths_defaults()
    );

    $dir = __DIR__ . '/../data/fragments/';
    foreach (cms_fragment_map() as $key => $file) {
        $path = $dir . $file;
        $out[$key] = is_readable($path) ? trim((string) file_get_contents($path)) : '';
    }

    for ($i = 8; $i <= cms_timeline_max_slides(); ++$i) {
        $hk = 'html_timeline_' . $i;
        if (!array_key_exists($hk, $out)) {
            $out[$hk] = '';
        }
    }

    return $out;
}

/**
 * Merge saved JSON over defaults (only known keys).
 */
function load_site_content(): array
{
    $defaults = cms_build_defaults();
    $path = __DIR__ . '/../data/site.json';
    if (!is_readable($path)) {
        return $defaults;
    }
    $data = json_decode((string) file_get_contents($path), true);
    if (!is_array($data)) {
        return $defaults;
    }
    $keys = array_keys($defaults);
    $allowed = array_fill_keys($keys, true);
    $filtered = array_intersect_key($data, $allowed);

    $merged = array_merge($defaults, $filtered);
    foreach ($data as $k => $v) {
        if (!is_string($k) || !is_string($v)) {
            continue;
        }
        if (!cms_is_extra_html_fragment_key($k)) {
            continue;
        }
        if (array_key_exists($k, $defaults)) {
            continue;
        }
        $merged[$k] = $v;
    }
    if (cms_timeline_data_looks_fragmented($merged)) {
        $merged = cms_timeline_coalesce_fragmented_slides($merged);
    }
    foreach ($merged as $k => $v) {
        if (!is_string($k) || !is_string($v)) {
            continue;
        }
        if (!str_starts_with($k, 'html_')) {
            continue;
        }
        $merged[$k] = cms_normalize_legacy_h7($v);
    }

    return $merged;
}

function esc(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Convert legacy &lt;h7&gt; emphasis markup to semantic highlight spans. */
function cms_normalize_legacy_h7(string $html): string
{
    if ($html === '' || stripos($html, '<h7') === false) {
        return $html;
    }

    return preg_replace('#</h7>#i', '</strong>', preg_replace('#<h7\b[^>]*>#i', '<strong class="portfolio-highlight">', $html));
}

/**
 * Cache-busting query value for static assets under public_html (updates when the file changes).
 */
function cms_asset_v(string $relative): string
{
    $path = __DIR__ . '/../' . ltrim(str_replace('\\', '/', $relative), './');
    $m = @filemtime($path);

    return $m !== false ? (string) $m : '1';
}

/** Echo CMS HTML (already sanitized on save). */
function content_html(array $content, string $key): void
{
    $html = cms_html_raw($content, $key);
    echo $html;
}

/** Raw CMS HTML for a key (portfolio overlay fragments expanded). */
function cms_html_raw(array $content, string $key): string
{
    $html = (string) ($content[$key] ?? '');
    if (preg_match('#^html_portfolio_\d+$#', $key) === 1) {
        $html = cms_portfolio_fragment_render_inner($html);
    }

    return $html;
}

/** True when a CMS HTML block has visible text after tags are stripped. */
function cms_html_has_content(array $content, string $key): bool
{
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags(cms_html_raw($content, $key))));

    return $text !== '';
}

/**
 * Echo adaptive grid cells for CMS panel blocks (skips empty keys).
 *
 * @param list<string> $keys
 */
function cms_render_panel_grid(array $content, array $keys, string $gridClass = 'portfolio-content-grid--panels', string $panelClass = 'portfolio-panel main_home'): void
{
    $keys = array_values(array_filter($keys, static fn (string $key): bool => cms_html_has_content($content, $key)));
    if ($keys === []) {
        return;
    }

    echo '<div class="portfolio-content-grid portfolio-content-grid--stacked ' . esc($gridClass) . '">';
    foreach ($keys as $key) {
        echo '<div class="portfolio-grid-cell"><div class="' . esc($panelClass) . '">';
        content_html($content, $key);
        echo '</div></div>';
    }
    echo '</div>';
}

/** Optional count-based grid modifiers (e.g. single full-width panel). */
function cms_portfolio_grid_modifiers(int $itemCount): string
{
    if ($itemCount <= 1) {
        return ' portfolio-content-grid--solo';
    }
    if ($itemCount === 2) {
        return ' portfolio-content-grid--duo';
    }

    return '';
}

/** Employer logo tiles for the About section (href, image key, accessible name). */
function cms_employer_logo_items(): array
{
    return [
        ['href' => 'https://www.educationinvestor.co.uk', 'img' => 'img_gallery_1', 'label' => 'Education Investor'],
        ['href' => 'https://www.healthinvestor.co.uk', 'img' => 'img_gallery_2', 'label' => 'Health Investor UK'],
        ['href' => 'https://www.caring-times.co.uk', 'img' => 'img_gallery_3', 'label' => 'Caring Times'],
        ['href' => 'https://www.ctownersclub.com', 'img' => 'img_gallery_4', 'label' => 'Caring Times Owners Club'],
        ['href' => 'https://www.nmt-magazine.co.uk', 'img' => 'img_gallery_5', 'label' => 'NMT Magazine'],
        ['href' => 'https://www.nmtownersclub.com', 'img' => 'img_gallery_6', 'label' => 'NMT Owners Club'],
        ['href' => './media/pdf/bwie.pdf', 'img' => 'img_gallery_7', 'label' => 'BWIE PDF'],
        ['href' => 'https://independentschoolmanagement.co.uk/', 'img' => 'img_gallery_8', 'label' => 'Independent School Management'],
    ];
}

/** Work-experience panel keys in display order. */
function cms_work_experience_panel_keys(): array
{
    return [
        'html_work_nexus',
        'html_work_markallen',
        'html_work_gaming_intro',
        'html_work_indigo',
    ];
}

/** Skill icon tiles for the skills gallery (static set; grid adapts to count). */
function cms_skill_icon_items(): array
{
    return [
        ['class' => 'skill-php', 'title' => 'PHP', 'kind' => 'icon', 'icon' => 'fab fa-php', 'label' => 'PHP'],
        ['class' => 'skill-canva', 'title' => 'Canva', 'kind' => 'image', 'img' => 'img_skill_canva', 'label' => 'Canva'],
        ['class' => 'skill-hubspot', 'title' => 'HubSpot', 'kind' => 'icon', 'icon' => 'fab fa-hubspot', 'label' => 'HubSpot'],
        ['class' => 'skill-grip', 'title' => 'Grip', 'kind' => 'image', 'img' => 'img_skill_grip', 'label' => 'Grip'],
        ['class' => 'skill-photoshop', 'title' => 'Adobe Photoshop', 'kind' => 'icon', 'icon' => 'fas fa-wand-magic-sparkles', 'label' => 'Adobe Photoshop'],
        ['class' => 'skill-indesign', 'title' => 'Adobe InDesign', 'kind' => 'icon', 'icon' => 'fas fa-file-lines', 'label' => 'Adobe InDesign'],
        ['class' => 'skill-illustrator', 'title' => 'Adobe Illustrator', 'kind' => 'icon', 'icon' => 'fas fa-pen-nib', 'label' => 'Adobe Illustrator'],
        ['class' => 'skill-wordpress', 'title' => 'WordPress', 'kind' => 'icon', 'icon' => 'fab fa-wordpress', 'label' => 'WordPress'],
        ['class' => 'skill-bootstrap', 'title' => 'Bootstrap', 'kind' => 'icon', 'icon' => 'fab fa-bootstrap', 'label' => 'Bootstrap'],
        ['class' => 'skill-css', 'title' => 'CSS3', 'kind' => 'icon', 'icon' => 'fab fa-css3-alt', 'label' => 'CSS3'],
        ['class' => 'skill-html', 'title' => 'HTML5', 'kind' => 'icon', 'icon' => 'fab fa-html5', 'label' => 'HTML5'],
        ['class' => 'skill-js', 'title' => 'JavaScript', 'kind' => 'icon', 'icon' => 'fab fa-js', 'label' => 'JavaScript'],
    ];
}

/**
 * Light cleanup for trusted admin HTML (preserves link href/target — strip_tags does not).
 */
function cms_sanitize_html(string $html): string
{
    $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html);
    $html = preg_replace('#<iframe\b[^>]*>.*?</iframe>#is', '', $html);

    return trim($html);
}

/** Full HTML fragments edited with one rich-text area (not split-field or timeline slides). */
function cms_html_fragment_uses_wysiwyg(string $key): bool
{
    if (!str_starts_with($key, 'html_')) {
        return false;
    }
    if (cms_html_is_split_fragment($key)) {
        return false;
    }
    if (preg_match('#^html_timeline_\d+$#', $key) === 1) {
        return false;
    }

    return preg_match('#^html_[a-z][a-z0-9_]*$#', $key) === 1;
}
function cms_rich_anchor_href_is_allowed(string $href): bool
{
    $href = trim($href);
    if ($href === '' || preg_match('#^(javascript:|data:|vbscript:)#i', $href)) {
        return false;
    }
    if (str_contains($href, '..') || !preg_match('#^(https?:|mailto:|\.{0,2}/)#i', $href)) {
        return false;
    }
    return true;
}
/**
 * Rebuild allowed &lt;img&gt; tags with a safe src (https/http or same-site-relative; no mailto).
 */
function cms_rich_sanitize_img_tags(string $html): string
{
    return preg_replace_callback('#<img\b[^>]*>#is', static function (array $m): string {
        $tag = $m[0];
        $src = '';
        if (preg_match('#\bsrc\s*=\s*"([^"]*)"#i', $tag, $sm)) {
            $src = trim($sm[1]);
        } elseif (preg_match("#\bsrc\s*=\s*'([^']*)'#i", $tag, $sm)) {
            $src = trim($sm[1]);
        }
        if ($src === '' || preg_match('#^(javascript:|data:|vbscript:)#i', $src)) {
            return '';
        }
        if (str_contains($src, '..') || !preg_match('#^(https?:|\.{0,2}/)#i', $src)) {
            return '';
        }
        $alt = '';
        if (preg_match('#\balt\s*=\s*"([^"]*)"#i', $tag, $am)) {
            $alt = $am[1];
        } elseif (preg_match("#\balt\s*=\s*'([^']*)'#i", $tag, $am)) {
            $alt = $am[1];
        }
        $alt = html_entity_decode($alt, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $w = '';
        if (preg_match('#\bwidth\s*=\s*"?(\d+)"?#i', $tag, $wm)) {
            $w = ' width="' . (int) $wm[1] . '"';
        }
        $h = '';
        if (preg_match('#\bheight\s*=\s*"?(\d+)"?#i', $tag, $hm)) {
            $h = ' height="' . (int) $hm[1] . '"';
        }
        return '<img src="' . esc($src) . '" alt="' . esc($alt) . '"' . $w . $h . ' loading="lazy">';
    }, $html);
}
/**
 * Strip unsafe markup from rich text; allow blocks/inline used on the homepage.
 * Includes &lt;button&gt; so portfolio-style &lt;button&gt;&lt;a&gt;…&lt;/a&gt;&lt;/button&gt; survives saves (Recent Portfolio WYSIWYG).
 */
function cms_sanitize_rich_html(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }
    $allowedTags = '<p><br><strong><b><em><i><u><sub><sup><a><h2><h3><h4><h5><h6><ul><ol><li><button>'
        . '<blockquote><code><pre><hr><table><thead><tbody><tfoot><tr><th><td><caption><img><span>';
    $html = cms_normalize_legacy_h7($html);
    $html = preg_replace('#<(script|style|iframe|object|embed)\b[^>]*>.*?</\1>#is', '', $html);
    $html = preg_replace('#\s(on\w+|style)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)#i', '', $html);
    $html = strip_tags($html, $allowedTags);
    $linkInner = '<strong><b><em><i><u><br><sub><sup>';
    $linkCb = static function (array $m) use ($linkInner): string {
        $href = trim($m[1]);
        if (!cms_rich_anchor_href_is_allowed($href)) {
            return strip_tags($m[2]);
        }
        return '<a href="' . esc($href) . '" target="_blank" rel="noopener noreferrer">' . strip_tags($m[2], $linkInner) . '</a>';
    };
    $html = preg_replace_callback('#<a\b[^>]*\bhref\s*=\s*"([^"]*)"[^>]*>(.*?)</a>#is', $linkCb, $html);
    $html = preg_replace_callback("#<a\b[^>]*\bhref\s*=\s*'([^']*)'[^>]*>(.*?)</a>#is", $linkCb, $html);
    /* Remaining <a> tags have no href — drop to text only (do not match real links; that would strip every saved link). */
    $html = preg_replace_callback('#<a\b(?![^>]*\bhref\s*=)[^>]*>(.*?)</a>#is', static function (array $m): string {
        return strip_tags($m[1]);
    }, $html);
    $html = cms_rich_sanitize_img_tags($html);
    $html = preg_replace_callback(
        '#\sclass\s*=\s*("|\')(.*?)\1#i',
        static function (array $m): string {
            $classes = preg_split('/\s+/', trim($m[2]), -1, PREG_SPLIT_NO_EMPTY);
            $keep = array_values(array_intersect($classes, ['portfolio-chip', 'portfolio-highlight']));
            if ($keep === []) {
                return '';
            }

            return ' class="' . esc(implode(' ', $keep)) . '"';
        },
        $html
    );
    $html = trim(cms_rich_unwrap_buttons_without_allowed_link(trim($html)));
    return trim(cms_rich_wrap_anchor_links_in_button($html));
}/**
 * Remove &lt;button&gt; wrappers that no longer contain an allowed &lt;a href&gt; (e.g. after unlink in the editor).
 */
function cms_rich_unwrap_buttons_without_allowed_link(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $ok = @$dom->loadHTML('<?xml encoding="UTF-8"><div id="__cmsunwrap">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    if ($ok === false) {
        return $html;
    }
    $root = $dom->getElementById('__cmsunwrap');
    if (!$root instanceof DOMElement) {
        return $html;
    }
    $buttons = iterator_to_array($root->getElementsByTagName('button'));
    foreach ($buttons as $btn) {
        if (!$btn instanceof DOMElement) {
            continue;
        }
        $keep = false;
        foreach ($btn->getElementsByTagName('a') as $a) {
            if (!$a instanceof DOMElement || !$a->hasAttribute('href')) {
                continue;
            }
            if (cms_rich_anchor_href_is_allowed($a->getAttribute('href'))) {
                $keep = true;
                break;
            }
        }
        if ($keep) {
            continue;
        }
        $parent = $btn->parentNode;
        if ($parent === null) {
            continue;
        }
        while ($btn->firstChild !== null) {
            $parent->insertBefore($btn->firstChild, $btn);
        }
        $parent->removeChild($btn);
    }
    $out = '';
    foreach (iterator_to_array($root->childNodes) as $c) {
        $out .= $dom->saveHTML($c);
    }
    return trim($out);
}
/**
 * Wrap each real <a href> in <button><a>…</a></button> so site CSS (button a { background #b22222 }) applies.
 * Skips anchors already inside <button> (e.g. Recent Portfolio markup).
 */
function cms_rich_wrap_anchor_links_in_button(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $ok = @$dom->loadHTML('<?xml encoding="UTF-8"><div id="__cmsbtn">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    if ($ok === false) {
        return $html;
    }
    $root = $dom->getElementById('__cmsbtn');
    if (!$root instanceof DOMElement) {
        return $html;
    }
    $anchors = $root->getElementsByTagName('a');
    $toWrap = [];
    for ($i = 0; $i < $anchors->length; ++$i) {
        $a = $anchors->item($i);
        if (!$a instanceof DOMElement) {
            continue;
        }
        if (!$a->hasAttribute('href') || trim($a->getAttribute('href')) === '') {
            continue;
        }
        $p = $a->parentNode;
        if (!$p instanceof DOMElement) {
            continue;
        }
        if (strtolower($p->nodeName) === 'button') {
            continue;
        }
        if ($a->hasAttribute('class') && str_contains(' ' . $a->getAttribute('class') . ' ', ' portfolio-chip ')) {
            continue;
        }
        $toWrap[] = $a;
    }
    foreach ($toWrap as $a) {
        $parent = $a->parentNode;
        if ($parent === null) {
            continue;
        }
        $button = $dom->createElement('button');
        $parent->replaceChild($button, $a);
        $button->appendChild($a);
    }
    $out = '';
    foreach (iterator_to_array($root->childNodes) as $c) {
        $out .= $dom->saveHTML($c);
    }
    return trim($out);
}
function cms_wysiwyg_apply_paragraph_mode(string $html, string $mode): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $ok = @$dom->loadHTML('<?xml encoding="UTF-8"><div id="__cmsp">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    if ($ok === false) {
        return $html;
    }
    $root = $dom->getElementById('__cmsp');
    if (!$root instanceof DOMElement) {
        return $html;
    }
    $ps = $root->getElementsByTagName('p');
    $list = iterator_to_array($ps);
    $idx = 0;
    foreach ($list as $p) {
        $class = match ($mode) {
            'intro' => ($idx++ === 0) ? 'block animatable bounceIn intro-position' : 'block animatable bounceIn m-b-2',
            'work', 'recent' => 'block animatable bounceIn m-b-2',
            'testimonial', 'timeline' => 'description',
            'portfolio_tagline', 'portfolio_body' => '',
            default => 'block animatable bounceIn m-b-2',
        };
        if ($class !== '') {
            $p->setAttribute('class', $class);
        } else {
            $p->removeAttribute('class');
        }
    }
    $out = '';
    foreach (iterator_to_array($root->childNodes) as $c) {
        $out .= $dom->saveHTML($c);
    }

    return trim($out);
}

/** Serialise only the child nodes of an element (inner HTML). */
function cms_dom_inner_serialise_children(DOMDocument $dom, DOMElement $el): string
{
    $out = '';
    foreach (iterator_to_array($el->childNodes) as $c) {
        $out .= $dom->saveHTML($c);
    }

    return $out;
}

/**
 * Portfolio overlay markup is provided by index.php; unwrap legacy stored &lt;div class="overlay"&gt;…&lt;/div&gt;.
 */
function cms_portfolio_fragment_render_inner(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $ok = @$dom->loadHTML('<?xml encoding="UTF-8"><div id="__cmspf">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    if ($ok === false) {
        return $html;
    }
    $root = $dom->getElementById('__cmspf');
    if (!$root instanceof DOMElement || $root->childNodes->length !== 1) {
        return $html;
    }
    $only = $root->firstChild;
    if (!$only instanceof DOMElement) {
        return $html;
    }
    $class = $only->getAttribute('class');
    if (!preg_match('#(?:^|\s)overlay(?:\s|$)#', $class)) {
        return $html;
    }

    return trim(cms_dom_inner_serialise_children($dom, $only));
}

function cms_wysiwyg_save_fragment(string $key, string $rawHtml): string
{
    $html = cms_sanitize_rich_html($rawHtml);

    return match (true) {
        preg_match('#^html_introduction_\d+$#', $key) === 1 => cms_wysiwyg_apply_paragraph_mode($html, 'intro'),
        preg_match('#^html_recent_portfolio_\d+$#', $key) === 1 => cms_plain_wrap_recent_portfolio(cms_wysiwyg_apply_paragraph_mode($html, 'work')),
        $key === 'html_work_gaming_intro' => cms_wysiwyg_apply_paragraph_mode($html, 'intro'),
        default => $html,
    };
}

/** HTML inner for WYSIWYG load (not plain-text conversion). */
function cms_editor_html_for_wysiwyg(string $key, string $storedHtml): string
{
    if (preg_match('#^html_recent_portfolio_\d+$#', $key) === 1) {
        return cms_recent_fragment_extract_inner_html($storedHtml);
    }

    return trim($storedHtml);
}

/**
 * Non-button &lt;p&gt; blocks from portfolio overlay inner (after &lt;h1&gt;), for editors.
 *
 * @return list<string>
 */
function cms_portfolio_text_ps_html_chunks(string $html): array
{
    $html = trim($html);
    $html = preg_replace('#^<div class="overlay">\s*#is', '', $html);
    $html = preg_replace('#\s*</div>\s*$#is', '', $html);
    if (!preg_match_all('#<p\b([^>]*)>(.*?)</p>#is', $html, $mm, PREG_SET_ORDER)) {
        return [];
    }
    $out = [];
    foreach ($mm as $m) {
        if (stripos($m[2], '<button') !== false) {
            continue;
        }
        $out[] = '<p' . $m[1] . '>' . $m[2] . '</p>';
    }

    return $out;
}

/* ========== Plain-text editor ↔ stored HTML (admin: no angle brackets) ========== */

function cms_plain_esc_with_autolink(string $s): string
{
    $parts = preg_split('#(https?://[^\s*]+)#i', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
    $html = '';
    foreach ($parts as $p) {
        if ($p === '') {
            continue;
        }
        if (preg_match('#^https?://#i', $p)) {
            $html .= '<a href="' . esc($p) . '" target="_blank">' . esc($p) . '</a>';
        } else {
            $html .= htmlspecialchars($p, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }
    }

    return $html;
}

/** Maps *phrase* to a highlight wrapper; autolinks URLs in other segments. */
function cms_plain_star_h7_and_autolink(string $s): string
{
    $chunks = preg_split('#(\*[^*]+\*)#', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
    $out = '';
    foreach ($chunks as $chunk) {
        if ($chunk === '') {
            continue;
        }
        if (preg_match('#^\*([^*]+)\*$#', $chunk, $m)) {
            $out .= '<strong class="portfolio-highlight">' . esc($m[1]) . '</strong>';
        } else {
            $out .= cms_plain_esc_with_autolink($chunk);
        }
    }

    return $out;
}

/**
 * Inline rich text: *Phrase* or {h7}Phrase{/h7} → highlight span; raw URLs autolink.
 * Inside {h7}…{/h7}, asterisks are not treated as markers (avoids nested highlights).
 */
function cms_plain_text_emphasis_and_urls(string $s): string
{
    $chunks = preg_split('#(\{h7\}.*?\{/h7\})#su', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
    $out = '';
    foreach ($chunks as $chunk) {
        if ($chunk === '') {
            continue;
        }
        if (preg_match('#^\{h7\}(.*?)\{/h7\}$#su', $chunk, $m)) {
            $inner = trim($m[1]);
            if ($inner !== '') {
                $out .= '<strong class="portfolio-highlight">' . cms_plain_esc_with_autolink($inner) . '</strong>';
            }

            continue;
        }
        $out .= cms_plain_star_h7_and_autolink($chunk);
    }

    return $out;
}

function cms_plain_line_rich_to_html(string $line): string
{
    $line = trim($line);
    if ($line === '') {
        return '';
    }
    $parts = preg_split('#(\[[^\]]*\]\([^)]+\))#', $line, -1, PREG_SPLIT_DELIM_CAPTURE);
    $out = '';
    foreach ($parts as $part) {
        if ($part === '') {
            continue;
        }
        if (preg_match('#^\[([^\]]*)\]\(([^)]+)\)$#', $part, $m)) {
            $out .= '<a href="' . esc(trim($m[2])) . '" target="_blank">' . esc(trim($m[1])) . '</a>';
        } else {
            $out .= cms_plain_text_emphasis_and_urls($part);
        }
    }

    return $out;
}

function cms_plain_paragraphs_class(string $plain, string $pClass, bool $firstClassAlternate = false, ?string $firstClass = null): string
{
    $plain = str_replace("\r\n", "\n", trim($plain));
    if ($plain === '') {
        return '';
    }
    $blocks = preg_split('/\n\s*\n/', $plain);
    $out = [];
    $i = 0;
    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') {
            continue;
        }
        $cls = $pClass;
        if ($firstClassAlternate && $firstClass !== null && $i === 0) {
            $cls = $firstClass;
        }
        ++$i;
        $lines = explode("\n", $block);
        $inner = [];
        foreach ($lines as $ln) {
            $inner[] = cms_plain_line_rich_to_html(trim($ln));
        }
        $out[] = '<p class="' . esc($cls) . '">' . implode("<br>\n", $inner) . '</p>';
    }

    return implode("\n", $out);
}

function cms_plain_intro_or_gaming_to_html(string $plain): string
{
    $plain = str_replace("\r\n", "\n", trim($plain));
    if ($plain === '') {
        return '';
    }
    $blocks = preg_split('/\n\s*\n/', $plain);
    $out = [];
    $first = true;
    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') {
            continue;
        }
        $cls = $first ? 'block animatable bounceIn intro-position' : 'block animatable bounceIn m-b-2';
        $first = false;
        $lines = explode("\n", $block);
        $inner = [];
        foreach ($lines as $ln) {
            $inner[] = cms_plain_line_rich_to_html(trim($ln));
        }
        $out[] = '<p class="' . $cls . '">' . implode("<br>\n", $inner) . '</p>';
    }

    return implode("\n", $out);
}

function cms_plain_work_body_to_html(string $plain): string
{
    return cms_plain_paragraphs_class($plain, 'block animatable bounceIn m-b-2', false, null);
}

function cms_plain_testimonial_body_to_html(string $plain): string
{
    $plain = str_replace("\r\n", "\n", trim($plain));
    if ($plain === '') {
        return '';
    }
    $icon = '<i class="fas fa-quote-left" aria-hidden="true"></i>';
    $blocks = preg_split('/\n\s*\n/', $plain);
    $ps = [];
    foreach ($blocks as $b) {
        $b = trim($b);
        if ($b === '') {
            continue;
        }
        $lines = explode("\n", $b);
        $inner = [];
        foreach ($lines as $ln) {
            $inner[] = cms_plain_line_rich_to_html(trim($ln));
        }
        $ps[] = '<p class="description">' . implode("<br>\n", $inner) . '</p>';
    }

    return $icon . "\n" . implode("\n", $ps);
}

function cms_plain_timeline_body_to_html(string $plain): string
{
    return cms_plain_paragraphs_class($plain, 'description', false, null);
}

function cms_plain_portfolio_p_block_to_html(string $block): string
{
    $lines = explode("\n", $block);
    $inner = [];
    foreach ($lines as $ln) {
        $inner[] = cms_plain_line_rich_to_html(trim($ln));
    }

    return '<p>' . implode("<br>\n", $inner) . '</p>';
}

/** Portfolio description paragraphs only (buttons are edited separately). */
function cms_plain_portfolio_body_only_to_html(string $plain): string
{
    $plain = str_replace("\r\n", "\n", trim($plain));
    if ($plain === '') {
        return '';
    }
    $ps = [];
    $buf = [];
    $flush = static function () use (&$ps, &$buf): void {
        if ($buf === []) {
            return;
        }
        $block = trim(implode("\n", $buf));
        if ($block !== '') {
            $ps[] = cms_plain_portfolio_p_block_to_html($block);
        }
        $buf = [];
    };
    foreach (explode("\n", $plain) as $rawLine) {
        $line = trim($rawLine);
        if ($line === '') {
            $flush();
            continue;
        }
        $buf[] = $line;
    }
    $flush();

    return implode("\n", $ps);
}

/**
 * @return array{tagline: string, text: string, buttons: list<array{label: string, url: string}>}
 */
function cms_portfolio_extract_text_and_buttons(string $html): array
{
    $html = trim($html);
    if (preg_match('#^<div class="overlay">\s*(.*?)\s*</div>\s*$#is', $html, $m)) {
        $html = trim($m[1]);
    }
    $html = trim(preg_replace('#</div>\s*$#i', '', $html));
    $textParts = [];
    $buttons = [];
    if (!preg_match_all('#<p\b[^>]*>(.*?)</p>#is', $html, $matches)) {
        return ['tagline' => '', 'text' => cms_rich_html_to_plain($html), 'buttons' => []];
    }
    foreach ($matches[1] as $inner) {
        if (stripos($inner, '<button') !== false) {
            if (preg_match_all('#<a\b[^>]*\bhref\s*=\s*"([^"]*)"[^>]*>(.*?)</a>#is', $inner, $am, PREG_SET_ORDER)) {
                foreach ($am as $a) {
                    $buttons[] = [
                        'label' => trim(html_entity_decode(strip_tags($a[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
                        'url' => trim($a[1]),
                    ];
                }
            }
            continue;
        }
        $inner = preg_replace('#<h7\b[^>]*>#i', '*', $inner);
        $inner = preg_replace('#</h7>#i', '*', $inner);
        $inner = preg_replace_callback('#<a\b[^>]*\bhref\s*=\s*"([^"]*)"[^>]*>(.*?)</a>#is', static function (array $m): string {
            $t = trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

            return '[' . $t . '](' . trim($m[1]) . ')';
        }, $inner);
        $inner = preg_replace('#<br\s*/?>#i', "\n", $inner);
        $inner = strip_tags($inner);
        $textParts[] = trim(html_entity_decode($inner, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    $n = count($textParts);
    if ($n === 0) {
        return ['tagline' => '', 'text' => '', 'buttons' => $buttons];
    }
    if ($n === 1) {
        return ['tagline' => '', 'text' => $textParts[0], 'buttons' => $buttons];
    }

    return [
        'tagline' => $textParts[0],
        'text' => implode("\n\n", array_slice($textParts, 1)),
        'buttons' => $buttons,
    ];
}

/**
 * @param list<array{label: string, url: string}> $buttons
 */
function cms_portfolio_buttons_html(array $buttons): string
{
    $buttons = array_values(array_filter($buttons, static fn (array $b): bool => trim($b['url'] ?? '') !== ''));
    if ($buttons === []) {
        return '';
    }
    $bhtml = [];
    foreach ($buttons as $b) {
        $href = cms_sanitize_nav_url((string) ($b['url'] ?? ''));
        if ($href === './') {
            continue;
        }
        $lab = trim($b['label'] ?? '');
        if ($lab === '') {
            $lab = 'LINK';
        }
        $bhtml[] = '<button> <a href="' . esc($href) . '" target="_blank">' . esc($lab) . '</a> </button>';
    }
    if ($bhtml === []) {
        return '';
    }

    return "\n<p>\n                                           " . implode(' | ', $bhtml) . "\n                                        </p>";
}

function cms_plain_games_to_html(string $plain): string
{
    $t = str_replace(["\r\n", "\r"], "\n", trim($plain));
    $t = str_replace("\n", '|', $t);
    $parts = array_map('trim', explode('|', $t));
    $parts = array_values(array_filter($parts, static fn ($x) => $x !== ''));
    if ($parts === []) {
        return '';
    }
    $highlights = [];
    foreach ($parts as $p) {
        $highlights[] = '<span class="portfolio-highlight">' . esc($p) . '</span>';
    }

    return implode(' | ', $highlights);
}

function cms_rich_html_to_plain(string $html): string
{
    if (trim($html) === '') {
        return '';
    }
    $html = cms_normalize_legacy_h7($html);
    $html = preg_replace('#<strong\b[^>]*\bclass\s*=\s*["\']portfolio-highlight["\'][^>]*>(.*?)</strong>#is', '*$1*', $html);
    $html = preg_replace('#<span\b[^>]*\bclass\s*=\s*["\']portfolio-highlight["\'][^>]*>(.*?)</span>#is', '*$1*', $html);
    $html = preg_replace_callback('#<a\b[^>]*\bhref\s*=\s*"([^"]*)"[^>]*>(.*?)</a>#is', static function (array $m): string {
        $t = trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        return '[' . $t . '](' . trim($m[1]) . ')';
    }, $html);
    $html = preg_replace_callback('#<button[^>]*>\s*<a\b[^>]*\bhref\s*=\s*"([^"]*)"[^>]*>(.*?)</a>\s*</button>#is', static function (array $m): string {
        $t = trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        return '[' . $t . '](' . trim($m[1]) . ')';
    }, $html);
    $html = preg_replace('#<i\b[^>]*>\s*</i>#i', '', $html);
    $html = preg_replace('#<br\s*/?>#i', "\n", $html);
    $html = preg_replace('#</p>\s*#i', "\n\n", $html);
    $html = preg_replace('#</div>\s*#i', "\n", $html);
    $html = strip_tags($html);
    $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $html = preg_replace("/[ \t\f\v]+/u", ' ', $html);
    $html = preg_replace("/\n{3,}/u", "\n\n", $html);

    return trim($html);
}

/**
 * @return list<string>
 */
function cms_games_names_from_html(string $html): array
{
    $html = cms_normalize_legacy_h7($html);
    $m = [];
    if (!preg_match_all('#<(?:strong|span)\b[^>]*\bclass\s*=\s*["\']portfolio-highlight["\'][^>]*>(.*?)</(?:strong|span)>#is', $html, $m)) {
        preg_match_all('#<h7\b[^>]*>(.*?)</h7>#is', $html, $m);
    }
    if (($m[1] ?? []) === []) {
        return [];
    }
    $names = [];
    foreach ($m[1] as $inner) {
        $t = trim(html_entity_decode(strip_tags($inner), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($t !== '') {
            $names[] = $t;
        }
    }

    return $names;
}

function cms_games_html_to_plain(string $html): string
{
    $names = cms_games_names_from_html($html);
    if ($names !== []) {
        return implode("\n", $names);
    }

    return cms_rich_html_to_plain($html);
}

/**
 * @return list<array{name: string, url: string}>
 */
function cms_skills_extract_link_rows(string $linksHtml): array
{
    $linksHtml = trim($linksHtml);
    if ($linksHtml === '' || !preg_match_all('#<a\b[^>]*\bhref\s*=\s*"([^"]*)"[^>]*>(.*?)</a>#is', $linksHtml, $mm, PREG_SET_ORDER)) {
        return [];
    }
    $rows = [];
    foreach ($mm as $m) {
        $rows[] = [
            'name' => trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
            'url' => trim($m[1]),
        ];
    }

    return $rows;
}

function cms_recent_fragment_extract_inner_html(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $ok = @$dom->loadHTML('<?xml encoding="UTF-8"><div id="__cmsr">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    if ($ok === false) {
        return $html;
    }
    $root = $dom->getElementById('__cmsr');
    if (!$root instanceof DOMElement) {
        return $html;
    }
    $xp = new DOMXPath($dom);
    $nodes = $xp->query('//*[contains(concat(" ", normalize-space(@class), " "), " main_home ")]');
    if ($nodes === false || $nodes->length === 0) {
        if (preg_match('#<div class="main_home">\s*(.*?)\s*</div>\s*</div>\s*</div>\s*</div>#is', $html, $m)) {
            return trim($m[1]);
        }

        return $html;
    }
    $main = $nodes->item(0);
    if (!$main instanceof DOMElement) {
        return $html;
    }

    return trim(cms_dom_inner_serialise_children($dom, $main));
}

function cms_editor_plain_for_fragment(string $key, string $storedHtml): string
{
    if (preg_match('#^html_recent_portfolio_\d+$#', $key) === 1) {
        $inner = cms_recent_fragment_extract_inner_html($storedHtml);

        return cms_rich_html_to_plain($inner);
    }
    if ($key === 'html_games_tested') {
        return cms_games_html_to_plain($storedHtml);
    }

    return cms_rich_html_to_plain($storedHtml);
}

function cms_plain_full_fragment_to_html(string $key, string $plain): string
{
    return match (true) {
        preg_match('#^html_introduction_\d+$#', $key) === 1 => cms_plain_intro_or_gaming_to_html($plain),
        preg_match('#^html_recent_portfolio_\d+$#', $key) === 1 => cms_plain_wrap_recent_portfolio(cms_plain_work_body_to_html($plain)),
        $key === 'html_work_gaming_intro' => cms_plain_intro_or_gaming_to_html($plain),
        $key === 'html_games_tested' => cms_plain_games_to_html($plain),
        default => '',
    };
}

function cms_plain_wrap_recent_portfolio(string $innerHtml): string
{
    $innerHtml = trim($innerHtml);
    if ($innerHtml === '') {
        return '';
    }

    return '<div class="main_about_area p-t-3">' . "\n"
        . '<div class="head_title m-y-3 msr-reveal wow fadeInUp"><div class="m-b-2"><div class="main_home">' . "\n"
        . $innerHtml . "\n"
        . '</div></div></div></div>';
}

function cms_html_fragment_plain_inner(string $html): string
{
    return trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
}

/**
 * @return array{0: string, 1: string} title text, remainder HTML
 */
function cms_html_extract_first_h3(string $html): array
{
    $html = trim($html);
    $title = '';
    $rest = $html;
    if (preg_match('#<h3\b[^>]*>(.*?)</h3>#is', $rest, $m)) {
        $title = cms_html_fragment_plain_inner($m[1]);
        $rest = trim(preg_replace('#<h3\b[^>]*>.*?</h3>#is', '', $rest, 1));
    }

    return [$title, $rest];
}

/**
 * @return array{0: string, 1: string}
 */
function cms_html_extract_first_h1(string $html): array
{
    $html = trim($html);
    $title = '';
    $rest = $html;
    if (preg_match('#<h1\b[^>]*>(.*?)</h1>#is', $rest, $m)) {
        $title = cms_html_fragment_plain_inner($m[1]);
        $rest = trim(preg_replace('#<h1\b[^>]*>.*?</h1>#is', '', $rest, 1));
    }

    return [$title, $rest];
}

/**
 * Keys edited as plain title/heading fields + one HTML body (admin steps 3–7, same pattern as intro/headings).
 */
function cms_html_split_fragment_keys(): array
{
    return array_merge(
        ['html_work_nexus', 'html_work_markallen', 'html_work_indigo'],
        ['html_testimonial_1', 'html_testimonial_2', 'html_testimonial_3'],
        ['html_skills_courses'],
        ['html_games_tested'],
        ['html_portfolio_1', 'html_portfolio_2', 'html_portfolio_3', 'html_portfolio_4', 'html_portfolio_5', 'html_portfolio_6']
    );
}

function cms_html_is_split_fragment(string $key): bool
{
    return in_array($key, cms_html_split_fragment_keys(), true);
}

/**
 * @return array<string, string>|null
 */
function cms_html_parse_split_parts(string $key, string $html): ?array
{
    if (in_array($key, ['html_work_nexus', 'html_work_markallen', 'html_work_indigo'], true)) {
        [$t, $b] = cms_html_extract_first_h3($html);

        return ['__title' => $t, '__body' => trim($b)];
    }

    if (preg_match('#^html_testimonial_\d+$#', $key) === 1) {
        [$t, $b] = cms_html_extract_first_h3($html);
        $b = preg_replace('#<i\b[^>]*fa-quote-left[^>]*>\s*</i>#i', '', $b);

        return ['__title' => $t, '__body' => trim($b)];
    }

    if ($key === 'html_skills_courses') {
        [$h, $links] = cms_html_extract_first_h3($html);
        $rows = cms_skills_extract_link_rows($links);
        $n = cms_skills_course_row_count();
        $out = ['__heading' => $h];
        for ($i = 1; $i <= $n; ++$i) {
            $out['__course_' . $i . '_name'] = $rows[$i - 1]['name'] ?? '';
            $out['__course_' . $i . '_url'] = $rows[$i - 1]['url'] ?? '';
        }

        return $out;
    }

    if ($key === 'html_games_tested') {
        $names = cms_games_names_from_html($html);
        $n = cms_games_slot_count();
        $out = [];
        for ($i = 1; $i <= $n; ++$i) {
            $out['__game_' . $i] = $names[$i - 1] ?? '';
        }

        return $out;
    }

    if (preg_match('#^html_portfolio_\d+$#', $key) === 1) {
        [$t, $b] = cms_html_extract_first_h1($html);
        $ex = cms_portfolio_extract_text_and_buttons($b);
        $chunks = cms_portfolio_text_ps_html_chunks($b);
        $tagHtml = $chunks[0] ?? '';
        $bodyHtml = count($chunks) > 1 ? implode("\n", array_slice($chunks, 1)) : '';
        $slots = cms_portfolio_button_slot_count();
        $out = ['__title' => $t, '__tagline' => $tagHtml, '__body' => $bodyHtml];
        for ($i = 1; $i <= $slots; ++$i) {
            $out['__btn' . $i . '_label'] = $ex['buttons'][$i - 1]['label'] ?? '';
            $out['__btn' . $i . '_url'] = $ex['buttons'][$i - 1]['url'] ?? '';
        }

        return $out;
    }

    return null;
}

function cms_html_join_work_employer(string $title, string $bodyHtml): string
{
    $title = trim($title);
    $bodyHtml = trim($bodyHtml);
    if ($title === '' && $bodyHtml === '') {
        return '';
    }
    if ($title === '') {
        return $bodyHtml;
    }
    $h3 = '<h3 class="block animatable bounceIn title">' . esc($title) . '</h3>';
    if ($bodyHtml === '') {
        return $h3;
    }

    return $h3 . "\n" . $bodyHtml;
}

function cms_html_join_testimonial_block(string $title, string $bodyHtml): string
{
    $title = trim($title);
    $bodyHtml = trim($bodyHtml);
    if ($title === '' && $bodyHtml === '') {
        return '';
    }
    if ($title === '') {
        return $bodyHtml;
    }
    $h3 = '<h3 class="title">' . esc($title) . '</h3>';
    if ($bodyHtml === '') {
        return $h3;
    }

    return $h3 . "\n" . $bodyHtml;
}

function cms_html_join_timeline_block(string $role, string $dates, string $location, string $bodyHtml): string
{
    $parts = [];
    $role = trim($role);
    $dates = trim($dates);
    $location = trim($location);
    $bodyHtml = trim($bodyHtml);
    if ($role !== '') {
        $parts[] = '<h3 class="title">' . esc($role) . '</h3>';
    }
    if ($dates !== '') {
        $parts[] = '<h4 class="title">' . esc($dates) . '</h4>';
    }
    if ($location !== '') {
        $parts[] = '<p class="text-center">' . esc($location) . '</p>';
    }
    if ($bodyHtml !== '') {
        $parts[] = $bodyHtml;
    }
    if ($parts === []) {
        return '';
    }

    return implode("\n", $parts);
}

/**
 * @return array{__role: string, __dates: string, __location: string, __body: string}
 */
function cms_timeline_parse_fragment_html(string $html): array
{
    $html = trim($html);
    $role = $dates = $location = '';
    $body = $html;
    if (preg_match('#<h3\b[^>]*>(.*?)</h3>#is', $body, $m)) {
        $role = cms_html_fragment_plain_inner($m[1]);
        $body = trim(preg_replace('#<h3\b[^>]*>.*?</h3>#is', '', $body, 1));
    }
    if (preg_match('#<h4\b[^>]*>(.*?)</h4>#is', $body, $m)) {
        $dates = cms_html_fragment_plain_inner($m[1]);
        $body = trim(preg_replace('#<h4\b[^>]*>.*?</h4>#is', '', $body, 1));
    }
    if (preg_match('#<p\b[^>]*\btext-center\b[^>]*>(.*?)</p>#is', $body, $m)) {
        $location = cms_html_fragment_plain_inner($m[1]);
        $body = trim(preg_replace('#<p\b[^>]*\btext-center\b[^>]*>.*?</p>#is', '', $body, 1));
    }

    return [
        '__role' => $role,
        '__dates' => $dates,
        '__location' => $location,
        '__body' => trim($body),
    ];
}

/**
 * Detect corrupted timeline storage: each slide was saved as four separate html_timeline_N fragments
 * (h3, h4, location paragraph, body) instead of one assembled block per slide.
 */
function cms_timeline_data_looks_fragmented(array $content): bool
{
    $a = trim((string) ($content['html_timeline_1'] ?? ''));
    $b = trim((string) ($content['html_timeline_2'] ?? ''));
    if ($a === '' || $b === '') {
        return false;
    }
    $onlyH3 = (bool) preg_match('#^<h3\b[^>]*>.*?</h3>\s*$#is', $a);
    $onlyH4 = (bool) preg_match('#^<h4\b[^>]*>.*?</h4>\s*$#is', $b);

    return $onlyH3 && $onlyH4;
}

/**
 * Merge adjacent fragment keys into one html_timeline_N per slide (empty slot ends a group).
 * Preserves first slide index in each group for img_timeline_N.
 *
 * @return array<string, mixed>
 */
function cms_timeline_coalesce_fragmented_slides(array $content): array
{
    $max = cms_timeline_max_slides();
    $defs = cms_image_paths_defaults();
    $groups = [];
    $buf = [];
    for ($i = 1; $i <= $max; ++$i) {
        $h = trim((string) ($content['html_timeline_' . $i] ?? ''));
        if ($h === '') {
            if ($buf !== []) {
                $groups[] = $buf;
                $buf = [];
            }

            continue;
        }
        $buf[] = ['i' => $i, 'html' => $h];
    }
    if ($buf !== []) {
        $groups[] = $buf;
    }

    $n = min(count($groups), $max);
    $out = $content;
    for ($si = 1; $si <= $max; ++$si) {
        if ($si <= $n) {
            $g = $groups[$si - 1];
            $merged = implode("\n", array_column($g, 'html'));
            $out['html_timeline_' . $si] = $merged;
            $firstIdx = $g[0]['i'];
            $ik = 'img_timeline_' . $si;
            $srcKey = 'img_timeline_' . $firstIdx;
            $img = trim((string) ($content[$srcKey] ?? ''));
            $out[$ik] = $img !== '' ? $img : ($defs[$ik] ?? '');
        } else {
            $out['html_timeline_' . $si] = '';
            $out['img_timeline_' . $si] = $defs['img_timeline_' . $si] ?? '';
        }
    }
    $out['timeline_count'] = $n;

    return $out;
}

/** Number of timeline slides to show on the homepage (from saved count or last non-empty slot). */
function cms_timeline_effective_count(array $content): int
{
    $t = (int) ($content['timeline_count'] ?? 0);
    $max = cms_timeline_max_slides();
    if ($t > 0) {
        return min($t, $max);
    }
    for ($i = $max; $i >= 1; --$i) {
        if (trim((string) ($content['html_timeline_' . $i] ?? '')) !== '') {
            return $i;
        }
    }

    return 0;
}

/**
 * Build html_timeline_*, img_timeline_*, timeline_count from admin POST tl_slide rows (document order).
 *
 * @return array<string, string|int>
 */
function cms_timeline_compact_slides_from_post(array $post): array
{
    $rows = $post['tl_slide'] ?? null;
    if (!is_array($rows)) {
        $rows = [];
    }
    $compiled = [];
    foreach ($rows as $row) {
        if (!is_array($row)) {
            continue;
        }
        $role = trim((string) ($row['__role'] ?? ''));
        $dates = trim((string) ($row['__dates'] ?? ''));
        $location = trim((string) ($row['__location'] ?? ''));
        $body = trim((string) ($row['__body'] ?? ''));
        $img = cms_sanitize_image_path(trim((string) ($row['img'] ?? '')));
        $any = $role !== '' || $dates !== '' || $location !== '' || $body !== '' || $img !== '';
        if (!$any) {
            continue;
        }
        $compiled[] = [
            'role' => $role,
            'dates' => $dates,
            'location' => $location,
            'body' => $body,
            'img' => $img,
        ];
    }

    $max = cms_timeline_max_slides();
    $defs = cms_image_paths_defaults();
    $out = [];
    $n = min(count($compiled), $max);
    for ($i = 1; $i <= $max; ++$i) {
        if ($i <= $n) {
            $c = $compiled[$i - 1];
            $bodyHtml = cms_wysiwyg_apply_paragraph_mode(cms_sanitize_rich_html($c['body']), 'timeline');
            $out['html_timeline_' . $i] = cms_sanitize_html(cms_html_join_timeline_block(
                $c['role'],
                $c['dates'],
                $c['location'],
                $bodyHtml
            ));
            $ik = 'img_timeline_' . $i;
            $out[$ik] = $c['img'] !== '' ? $c['img'] : ($defs[$ik] ?? '');
        } else {
            $out['html_timeline_' . $i] = '';
            $ik = 'img_timeline_' . $i;
            $out[$ik] = $defs[$ik] ?? '';
        }
    }
    $out['timeline_count'] = $n;

    return $out;
}

function cms_html_join_skills_block(string $heading, string $linksHtml): string
{
    $heading = trim($heading);
    $linksHtml = trim($linksHtml);
    if ($heading === '' && $linksHtml === '') {
        return '';
    }
    if ($heading === '') {
        return $linksHtml;
    }
    $h = '<h3>' . esc($heading) . '</h3>';
    if ($linksHtml === '') {
        return $h;
    }

    return $h . "\n" . $linksHtml;
}

function cms_html_join_portfolio_block(string $title, string $bodyHtml): string
{
    $title = trim($title);
    $bodyHtml = trim($bodyHtml);
    if ($title === '' && $bodyHtml === '') {
        return '';
    }
    if ($title === '') {
        return $bodyHtml;
    }
    $h = '<h1>' . esc($title) . '</h1>';

    return $bodyHtml === '' ? $h : $h . "\n" . $bodyHtml;
}

function cms_html_assemble_split_fragment(string $key, array $post): string
{
    $g = static function (string $suffix) use ($key, $post): string {
        return (string) ($post[$key . $suffix] ?? '');
    };

    if (in_array($key, ['html_work_nexus', 'html_work_markallen', 'html_work_indigo'], true)) {
        $body = cms_wysiwyg_apply_paragraph_mode(cms_sanitize_rich_html($g('__body')), 'work');

        return cms_sanitize_html(cms_html_join_work_employer(trim($g('__title')), $body));
    }

    if (preg_match('#^html_testimonial_\d+$#', $key) === 1) {
        $bodyInner = cms_wysiwyg_apply_paragraph_mode(cms_sanitize_rich_html($g('__body')), 'testimonial');
        $bodyHtml = $bodyInner === '' ? '' : '<i class="fas fa-quote-left" aria-hidden="true"></i>' . "\n" . $bodyInner;

        return cms_sanitize_html(cms_html_join_testimonial_block(trim($g('__title')), $bodyHtml));
    }

    if ($key === 'html_skills_courses') {
        $heading = trim((string) ($post[$key . '__heading'] ?? $g('__heading')));
        $parts = [];
        if (isset($post['skills_course_url']) && is_array($post['skills_course_url'])) {
            /** @var list<mixed> $urls */
            $urls = $post['skills_course_url'];
            /** @var list<mixed> $names */
            $names = isset($post['skills_course_name']) && is_array($post['skills_course_name']) ? $post['skills_course_name'] : [];
            $cap = cms_skills_course_row_count();
            $n = min($cap, max(count($urls), count($names)));
            for ($i = 0; $i < $n; ++$i) {
                $raw = trim((string) ($urls[$i] ?? ''));
                $u = cms_sanitize_skills_course_url($raw);
                if ($u === '') {
                    continue;
                }
                $name = trim(preg_replace('/\s+/u', ' ', (string) ($names[$i] ?? '')));
                if ($name === '') {
                    $name = $u;
                }
                $parts[] = '<a href="' . esc($u) . '" target="_blank">' . esc($name) . '</a>';
            }
        } else {
            for ($i = 1, $n = cms_skills_course_row_count(); $i <= $n; ++$i) {
                $raw = trim($g('__course_' . $i . '_url'));
                $u = cms_sanitize_skills_course_url($raw);
                if ($u === '') {
                    continue;
                }
                $name = trim($g('__course_' . $i . '_name'));
                if ($name === '') {
                    $name = $u;
                }
                $parts[] = '<a href="' . esc($u) . '" target="_blank">' . esc($name) . '</a>';
            }
        }

        return cms_sanitize_html(cms_html_join_skills_block($heading, implode(' | ', $parts)));
    }

    if ($key === 'html_games_tested') {
        $lines = [];
        if (isset($post['games_title']) && is_array($post['games_title'])) {
            $cap = cms_games_slot_count();
            foreach ($post['games_title'] as $t) {
                if (count($lines) >= $cap) {
                    break;
                }
                $line = trim((string) $t);
                if ($line !== '') {
                    $lines[] = $line;
                }
            }
        } else {
            for ($i = 1, $n = cms_games_slot_count(); $i <= $n; ++$i) {
                $line = trim($g('__game_' . $i));
                if ($line !== '') {
                    $lines[] = $line;
                }
            }
        }

        return cms_sanitize_html(cms_plain_games_to_html(implode("\n", $lines)));
    }

    if (preg_match('#^html_portfolio_\d+$#', $key) === 1) {
        $btnList = [];
        for ($i = 1, $s = cms_portfolio_button_slot_count(); $i <= $s; ++$i) {
            $rawUrl = trim($g('__btn' . $i . '_url'));
            if ($rawUrl === '') {
                continue;
            }
            $u = cms_sanitize_nav_url($rawUrl);
            if ($u === './') {
                continue;
            }
            $lab = trim($g('__btn' . $i . '_label'));
            $btnList[] = ['label' => $lab, 'url' => $u];
        }
        $chunks = [];
        $tagline = cms_wysiwyg_apply_paragraph_mode(cms_sanitize_rich_html(trim($g('__tagline'))), 'portfolio_tagline');
        if ($tagline !== '') {
            $chunks[] = $tagline;
        }
        $bodyHtmlPart = cms_wysiwyg_apply_paragraph_mode(cms_sanitize_rich_html(trim($g('__body'))), 'portfolio_body');
        if ($bodyHtmlPart !== '') {
            $chunks[] = $bodyHtmlPart;
        }
        $btnHtml = cms_portfolio_buttons_html($btnList);
        if ($btnHtml !== '') {
            $chunks[] = $btnHtml;
        }
        $bodyHtml = implode("\n", array_filter($chunks));

        return cms_sanitize_html(cms_html_join_portfolio_block(trim($g('__title')), $bodyHtml));
    }

    return '';
}

/** One-line hint for legacy/plain fields (games grid, etc.). */
function cms_plain_format_help_short(): string
{
    return 'Games: add/remove game title rows on the Games step. Skills: add/remove course name + PDF path from ./media. Portfolio: subtitle and description plus two link rows.';
}

/** Short hint shown under WYSIWYG rich text fields in admin. */
function cms_wysiwyg_format_help_short(): string
{
    return 'Use the toolbar for bold, italic, lists, and links. Use “Insert/edit link” for URLs (including View site links). Highlight text with the custom “Highlight” style where available. Portfolio: subtitle, description, and two link rows. Games and skills: use Add / Remove on that step to manage list rows.';
}

function cms_portfolio_button_slot_count(): int
{
    return 2;
}

/** Homepage portfolio grid overlay count (fixed slots in admin carousel). */
function cms_portfolio_overlay_slot_count(): int
{
    return max(1, count(cms_portfolio_project_json_files()));
}

function cms_skills_course_row_count(): int
{
    return 15;
}

/**
 * Course rows in admin: only filled rows plus one blank line to add the next link (no block of empty rows).
 *
 * @param array<string, string> $parts Parsed split fields (__course_N_name, __course_N_url)
 */
function cms_skills_admin_visible_rows(array $parts): int
{
    $cap = cms_skills_course_row_count();
    $lastUsed = 0;
    for ($i = 1; $i <= $cap; ++$i) {
        $name = trim((string) ($parts['__course_' . $i . '_name'] ?? ''));
        $url = trim((string) ($parts['__course_' . $i . '_url'] ?? ''));
        if ($name !== '' || $url !== '') {
            $lastUsed = $i;
        }
    }

    return min($cap, $lastUsed === 0 ? 1 : $lastUsed + 1);
}

function cms_games_slot_count(): int
{
    return 64;
}

/**
 * How many game title inputs to show in admin (avoids dozens of empty boxes).
 * Always at least {@see cms_games_admin_visible_floor()}, and last used index + buffer, capped at {@see cms_games_slot_count()}.
 *
 * @param array<string, string> $parts Parsed split fields (__game_1, …)
 */
function cms_games_admin_visible_slots(array $parts): int
{
    $cap = cms_games_slot_count();
    $lastUsed = 0;
    for ($i = 1; $i <= $cap; ++$i) {
        if (trim((string) ($parts['__game_' . $i] ?? '')) !== '') {
            $lastUsed = $i;
        }
    }
    $buffer = 4;
    $floor = cms_games_admin_visible_floor();

    return min($cap, max($lastUsed + $buffer, $floor));
}

function cms_games_admin_visible_floor(): int
{
    return 6;
}

/**
 * Friendly admin copy + optional insert snippet for HTML fragment fields.
 *
 * @return array{help: string, insert?: array{label: string, text: string}}
 */
function cms_html_field_extras(string $key): array
{
    if (cms_html_is_split_fragment($key)) {
        return ['help' => ''];
    }

    if ($key === 'html_work_gaming_intro') {
        return [
            'help' => cms_wysiwyg_format_help_short(),
        ];
    }

    if (preg_match('#^html_introduction_\d+$#', $key)) {
        return [
            'help' => cms_wysiwyg_format_help_short(),
        ];
    }

    if (preg_match('#^html_recent_portfolio_\d+$#', $key)) {
        return [
            'help' => cms_wysiwyg_format_help_short() . ' Portfolio overlay buttons are edited on the Portfolio step.',
        ];
    }

    if ($key === 'html_games_tested') {
        return [
            'help' => '',
        ];
    }

    return ['help' => ''];
}

/**
 * Flatten edit keys for one wizard step (excludes block placeholders; expands portfolio block).
 *
 * @param array{groups?: list<array{keys?: list<string>}>} $step
 *
 * @return list<string>
 */
function cms_wizard_step_flat_keys(array $step): array
{
    $keys = [];
    foreach ($step['groups'] ?? [] as $g) {
        foreach ($g['keys'] ?? [] as $k) {
            if ($k === '__timeline_block__' || $k === '__nav_block__') {
                continue;
            }
            if ($k === '__portfolio_block__') {
                for ($i = 1, $n = cms_portfolio_overlay_slot_count(); $i <= $n; ++$i) {
                    $keys[] = 'html_portfolio_' . $i;
                }

                continue;
            }
            $keys[] = (string) $k;
        }
    }

    return array_values(array_unique($keys));
}

/**
 * All field keys referenced by the edit wizard (all steps).
 *
 * @param list<array{groups?: mixed}> $wizardSteps
 *
 * @return list<string>
 */
function cms_wizard_all_flat_keys(array $wizardSteps): array
{
    $keys = [];
    foreach ($wizardSteps as $step) {
        foreach (cms_wizard_step_flat_keys($step) as $k) {
            $keys[] = $k;
        }
    }

    return array_values(array_unique($keys));
}

/**
 * html_* keys allowed in site.json beyond the core fragment map (not timeline slide bodies).
 */
function cms_is_extra_html_fragment_key(string $key): bool
{
    if (strlen($key) > 80) {
        return false;
    }
    if (preg_match('#^html_[a-z][a-z0-9_]*$#', $key) !== 1) {
        return false;
    }
    if (preg_match('#^html_timeline_\d+$#', $key) === 1) {
        return false;
    }

    return true;
}

/**
 * html_* keys present in content but not driven by a wizard field (e.g. added in site.json + index.php).
 *
 * @param array<string, mixed> $content
 * @param list<string> $wizardFlatKeys
 *
 * @return list<string>
 */
function cms_dynamic_html_fragment_keys(array $content, array $wizardFlatKeys): array
{
    $wizardSet = array_fill_keys($wizardFlatKeys, true);
    $out = [];
    foreach (array_keys($content) as $k) {
        if (!is_string($k) || !cms_is_extra_html_fragment_key($k)) {
            continue;
        }
        if (isset($wizardSet[$k])) {
            continue;
        }
        $out[] = $k;
    }
    sort($out);

    return $out;
}

/**
 * Sidebar / panel count: wizard steps plus one panel when extra HTML fragments exist.
 *
 * @param list<array{groups?: mixed}> $wizardSteps
 * @param array<string, mixed> $content
 */
function cms_wizard_nav_step_count(array $wizardSteps, array $content): int
{
    $extra = cms_dynamic_html_fragment_keys($content, cms_wizard_all_flat_keys($wizardSteps));

    return count($wizardSteps) + ($extra !== [] ? 1 : 0);
}

function cms_dynamic_fragment_label(string $key): string
{
    $base = preg_replace('#^html_#', '', $key);
    $base = str_replace('_', ' ', $base);

    return $base === '' ? 'HTML fragment' : 'HTML — ' . ucwords($base);
}

/**
 * Apply POST for html_* keys that are not part of the wizard (after wizard steps run).
 *
 * @param array<string, mixed> $out
 * @param array<string, mixed> $post
 * @param list<string> $wizardFlatKeys
 *
 * @return array<string, mixed>
 */
function cms_apply_dynamic_html_from_post(array $out, array $post, array $wizardFlatKeys): array
{
    $wizardSet = array_fill_keys($wizardFlatKeys, true);
    foreach (array_keys($out) as $k) {
        if (!is_string($k) || !cms_is_extra_html_fragment_key($k)) {
            continue;
        }
        if (isset($wizardSet[$k])) {
            continue;
        }
        $raw = (string) ($post[$k] ?? '');
        if (cms_html_fragment_uses_wysiwyg($k)) {
            $out[$k] = cms_sanitize_html(cms_wysiwyg_save_fragment($k, $raw));
        } else {
            $out[$k] = cms_sanitize_html(cms_plain_full_fragment_to_html($k, trim($raw)));
        }
    }

    return $out;
}

/** Whether this step includes the timeline slide editor (POST tl_slide + compact). */
function cms_wizard_step_has_timeline_editor(array $step): bool
{
    foreach ($step['groups'] ?? [] as $g) {
        if (in_array('__timeline_block__', $g['keys'] ?? [], true)) {
            return true;
        }
    }

    return false;
}

/** Whether this step includes the header nav editor. */
function cms_wizard_step_has_nav_editor(array $step): bool
{
    foreach ($step['groups'] ?? [] as $g) {
        if (in_array('__nav_block__', $g['keys'] ?? [], true)) {
            return true;
        }
    }

    return false;
}

/**
 * Merge $_POST for a single wizard step into full site content; other keys stay from $baseContent.
 *
 * @param array<string, mixed> $baseContent
 * @param array{groups?: list<array{keys?: list<string>}>} $step
 * @param array<string, mixed> $post
 *
 * @return array<string, mixed>
 */
function cms_apply_wizard_step_post(array $baseContent, array $step, array $post): array
{
    $out = $baseContent;
    foreach (cms_wizard_step_flat_keys($step) as $key) {
        if ($key === 'timeline_count') {
            continue;
        }
        if (preg_match('#^html_timeline_\d+$#', $key) === 1 || preg_match('#^img_timeline_\d+$#', $key) === 1) {
            continue;
        }
        if (cms_html_is_split_fragment($key)) {
            $out[$key] = cms_html_assemble_split_fragment($key, $post);

            continue;
        }
        $raw = (string) ($post[$key] ?? '');
        if (str_starts_with($key, 'img_')) {
            $clean = cms_sanitize_image_path(trim($raw));
            $defs = cms_image_paths_defaults();
            $out[$key] = $clean !== '' ? $clean : ($defs[$key] ?? '');

            continue;
        }
        if (str_starts_with($key, 'html_')) {
            if (cms_html_fragment_uses_wysiwyg($key)) {
                $out[$key] = cms_sanitize_html(cms_wysiwyg_save_fragment($key, $raw));
            } else {
                $out[$key] = cms_sanitize_html(cms_plain_full_fragment_to_html($key, trim($raw)));
            }

            continue;
        }
        $out[$key] = trim($raw);
    }
    if (cms_wizard_step_has_timeline_editor($step)) {
        $out = array_merge($out, cms_timeline_compact_slides_from_post($post));
    }
    if (cms_wizard_step_has_nav_editor($step)) {
        $out['site_nav_json'] = cms_site_nav_encode_from_post($post);
    }

    return $out;
}

/** All keys that can be saved (strings + html fragments). */
function cms_all_keys(): array
{
    $keys = array_merge(
        array_keys(cms_heading_defaults()),
        ['intro_name', 'intro_tagline', 'about_heading', 'site_nav_json', 'timeline_count'],
        array_keys(cms_fragment_map()),
        array_keys(cms_image_paths_defaults())
    );
    for ($i = 8; $i <= cms_timeline_max_slides(); ++$i) {
        $keys[] = 'html_timeline_' . $i;
    }

    return array_values(array_unique($keys));
}

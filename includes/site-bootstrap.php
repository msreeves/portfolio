<?php
declare(strict_types=1);

/**
 * Portfolio CMS bootstrap — maps, defaults, loaders, and key registry.
 * Sanitize / render / wizard helpers live in sibling includes.
 */
require_once __DIR__ . '/cms-sanitize.php';
require_once __DIR__ . '/cms-render.php';
require_once __DIR__ . '/cms-wizard.php';

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
        'html_work_bsi' => 'work_bsi.html',
        'html_work_nexus' => 'work_nexus.html',
        'html_work_markallen' => 'work_markallen.html',
        'html_work_rusi' => 'work_rusi.html',
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
        'html_work_bsi' => 'Work experience — BSI Group',
        'html_work_nexus' => 'Work experience — Nexus',
        'html_work_markallen' => 'Work experience — Mark Allen Group',
        'html_work_rusi' => 'Work experience — RUSI',
        'html_work_gaming_intro' => 'Work experience — gaming / intro',
        'html_work_indigo' => 'Work experience — Indigo Pearl',
        'html_skills_courses' => 'Skills — online courses & list',
        'html_testimonial_1' => 'Testimonials — featured (name + quote)',
        'html_testimonial_2' => 'Testimonials — more item 2 (name + quote)',
        'html_testimonial_3' => 'Testimonials — more item 3 (name + quote)',
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
        'intro_hero_headline' => 'Front-End WordPress Developer & CMS Specialist',
        'heading_recent_portfolio' => 'Selected work',
        'heading_career_highlights' => 'Career highlights',
        'heading_how_i_work' => 'How I work',
        'heading_portfolio_lanes' => 'How work is labelled here',
        'portfolio_lanes_lead' => 'Deliberately layered: archive pieces show where I started; programme demos show WordPress programme depth; the portfolio shell and local preview/audit tooling show how I build and verify work today — with me setting scope and sign-off, not unattended generation.',
        'portfolio_lanes_ai_note' => 'I use AI-assisted editing and audit tooling in my local workflow. Scope, copy, acceptance checks, and deploy stay with me — nothing ships on a green automated check alone.',
        'portfolio_archive_intro' => 'Earlier builds labelled Archive — left visible to show progression. Live demos and GitHub links where available.',
        'intro_hero_method' => 'Content-first build: copy and selected-work cards live in structured data; PHP handles layout and local vs live demo links. Updates go through the admin wizard—not scattered through theme templates.',
        'selected_work_lead_lede' => 'Lead case study — <strong>MSR Products</strong> WooCommerce showcase (catalogue UX, companion demo, Figma source). Programme demos below are measured against the same delivery bar.',
        'selected_work_current_lede' => 'Current focus — active studio and SPA builds with screenshots and case-study links in this band only.',
        'selected_work_programme_lede' => 'Programme demos — four labelled <span class="msr-lane-badge msr-lane-badge--programme">Programme demo</span> WordPress snapshots in a 2×2 grid; open demos and GitHub.',
        'career_highlights_json' => '',
        'role_focus_json' => '',
        'heading_demo_vs_live' => 'Demo vs live client',
        'demo_vs_live_lead' => 'Programme sites are portfolio demonstrations — not live companies. This strip compares what stays light on demos versus what I would enable on a real client site (protection, backups, SEO, consent) — plus how craft and QA differ by lane (see labels above).',
        'heading_work_for' => 'Experience',
        'heading_skills' => 'Skills',
        'heading_testimonials' => 'Testimonials',
        'heading_portfolio' => 'Archive projects',
        'heading_game_test' => 'GAMES TESTED',
        'heading_timeline' => 'TIMELINE',
        'footer_contact_heading' => 'Contact Me',
        'footer_copyright' => '© Copyright 2026 Michael Reeves | All rights reserved',
        'contact_band_heading' => 'Get in touch',
        'contact_band_intent' => 'Open to CMS/content, front-end WordPress, and marketing/campaign design roles — permanent, contract, or hybrid/remote. The CV and marketing portfolio are in the hero and footer.',
        'contact_band_email' => 'reevesy87@hotmail.co.uk',
        'cv_pdf' => './media/pdf/michael-reeves-cv.pdf',
        'cv_combined_pdf' => './media/pdf/michael-reeves-cv.pdf',
        'cv_marketing_pdf' => './media/pdf/marketing-portfolio.pdf',
        'cv_label' => 'CV',
        'cv_combined_label' => 'CV',
        'cv_marketing_label' => 'Marketing portfolio',
    ];
}

/** site.json keys for CV PDF paths (admin media picker, PDF-only). */

function cms_cv_pdf_field_keys(): array
{
    return ['cv_pdf', 'cv_combined_pdf', 'cv_marketing_pdf'];
}

/** Image paths (relative to site root, ./media/...). Editable in admin. */


function cms_image_paths_defaults(): array
{
    $base = [
        'img_intro_logo' => './media/images/icons/LOGO.jpg',
        'img_footer_logo' => './media/images/icons/LOGO.png',
        'img_gallery_bsi' => './media/images/icons/bsi-logo.png',
        'img_gallery_1' => './media/images/icons/ei-logo.svg',
        'img_gallery_2' => './media/images/icons/hi-logo.svg',
        'img_gallery_3' => './media/images/icons/ct-logo.svg',
        'img_gallery_4' => './media/images/icons/ct-oc.svg',
        'img_gallery_5' => './media/images/icons/nmt-magazine-logo.png',
        'img_gallery_6' => './media/images/icons/nmt-owners-club-logo.png',
        'img_gallery_7' => './media/images/icons/bwie-logo.png',
        'img_gallery_8' => './media/images/icons/ism-logo.png',
        'img_gallery_9' => './media/images/icons/nursery-world-logo.png',
        'img_gallery_10' => './media/images/icons/cyp-now-logo.png',
        'img_gallery_11' => './media/images/icons/rusi-logo.png',
        'img_gallery_12' => './media/images/icons/gramophone-logo.svg',
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
        'img_gallery_bsi' => 'About — BSI Group logo',
        'img_gallery_1' => 'About — Education Investor logo',
        'img_gallery_2' => 'About — Health Investor logo',
        'img_gallery_3' => 'About — Caring Times logo',
        'img_gallery_4' => 'About — CT Owners Club logo',
        'img_gallery_5' => 'About — NMT Magazine logo',
        'img_gallery_6' => 'About — NMT Owners Club logo',
        'img_gallery_7' => 'About — BWIE logo',
        'img_gallery_8' => 'About — ISM logo',
        'img_gallery_9' => 'About — Nursery World logo',
        'img_gallery_10' => 'About — CYP Now logo',
        'img_gallery_11' => 'About — RUSI logo',
        'img_gallery_12' => 'About — Gramophone logo',
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
        'career-highlights' => 'Career highlights',
        'role-focus' => 'Browse by role',
        'recent-portfolio' => 'Selected work',
        'portfolio-lanes' => 'How labelled',
        'demo-vs-live' => 'Demo vs live',
        'work-for' => 'Experience',
        'how-i-work' => 'How I work',
        'introduction' => 'About',
        'skills' => 'Skills',
        'testimonials' => 'Testimonials',
        'portfolio' => 'Archive projects',
        'game-test' => 'Games Tested',
        'timeline' => 'Timeline',
        'contact' => 'Contact footer',
        'contact-band' => 'Contact',
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
        ['label' => 'Selected work', 'type' => 'scroll', 'target' => 'recent-portfolio'],
        ['label' => 'Experience', 'type' => 'scroll', 'target' => 'work-for'],
        ['label' => 'About', 'type' => 'scroll', 'target' => 'introduction'],
        ['label' => 'CV', 'type' => 'url', 'target' => './media/pdf/michael-reeves-cv.pdf'],
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

        return '#' . $id;
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
        $base = basename($file);
        // Skip templates / private drafts (e.g. _project.card.example.json).
        if (str_starts_with($base, '_')) {
            continue;
        }

        $raw = @file_get_contents($file);
        if ($raw === false) continue;

        $data = json_decode($raw, true);
        if (!is_array($data)) continue;

        if (array_key_exists('active', $data)) {
            $isActive = filter_var($data['active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($isActive === false) continue;
        }

        // Featured case studies may keep a hub card but opt out of the archive accordion.
        if (array_key_exists('archive', $data)) {
            $inArchive = filter_var($data['archive'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($inArchive === false) continue;
        }

        $title = trim((string)($data['title'] ?? ''));
        $thumb = trim((string)($data['thumb'] ?? ''));
        if ($title === '' || $thumb === '') continue;

        $lane = cms_portfolio_lane_from_project_json($data);

        $projects[] = [
            'title' => $title,
            'stack' => trim((string)($data['stack'] ?? '')),
            'summary' => trim((string)($data['summary'] ?? '')),
            'thumb' => $thumb,
            'view_url' => trim((string)($data['view_url'] ?? '')),
            'code_url' => trim((string)($data['code_url'] ?? '')),
            'order' => (int)($data['order'] ?? 9999),
            'lane' => $lane,
        ];
    }

    usort($projects, static function (array $a, array $b): int {
        return [$a['order'], $a['title']] <=> [$b['order'], $b['title']];
    });

    return $projects;
}

/**
 * Portfolio lane keys for recruiter-facing labels (matches estate ongoing vs exhibit model).
 *
 * @return 'current'|'programme'|'archive'
 */
function cms_portfolio_lane_from_project_json(array $data): string
{
    $explicit = strtolower(trim((string) ($data['standardsTier'] ?? '')));
    if ($explicit === 'active' || $explicit === 'current') {
        return 'current';
    }
    if ($explicit === 'legacy' || $explicit === 'programme' || $explicit === 'frozen') {
        return $explicit === 'programme' ? 'programme' : 'archive';
    }

    $slug = strtolower(trim((string) ($data['slug'] ?? '')));
    if ($slug === 'event-companion' || $slug === 'perception' || $slug === 'atlas-ops') {
        return 'current';
    }

    return 'archive';
}


function cms_portfolio_lane_badge_label(string $lane): string
{
    return match ($lane) {
        'current' => 'Current standard',
        'programme' => 'Programme demo',
        'archive' => 'Archive',
        default => '',
    };
}


/**
 * Load a JSON document from sites/portfolio/data/ (cached per request).
 *
 * @return array<string, mixed>|null
 */
function cms_load_portfolio_data_json(string $filename): ?array
{
    static $cache = [];
    if (array_key_exists($filename, $cache)) {
        return $cache[$filename];
    }

    $filename = ltrim($filename, '/');
    if (preg_match('#^[a-z0-9][a-z0-9._-]*\\.json$#i', $filename) !== 1) {
        $cache[$filename] = null;

        return null;
    }

    $path = __DIR__ . '/../data/' . $filename;
    if (!is_readable($path)) {
        $cache[$filename] = null;

        return null;
    }

    $data = json_decode((string) file_get_contents($path), true);
    if (!is_array($data)) {
        $cache[$filename] = null;

        return null;
    }

    $cache[$filename] = $data;

    return $data;
}

/**
 * @return list<array{id: string, title: string, body: string}>
 */
function cms_portfolio_lanes_data(): array
{
    $data = cms_load_portfolio_data_json('portfolio-lanes.json');
    $lanes = $data['lanes'] ?? null;
    if (!is_array($lanes)) {
        return [];
    }

    $out = [];
    foreach ($lanes as $lane) {
        if (!is_array($lane)) {
            continue;
        }
        $id = trim((string) ($lane['id'] ?? ''));
        $title = trim((string) ($lane['title'] ?? ''));
        $body = trim((string) ($lane['body'] ?? ''));
        if ($id === '' || $title === '' || $body === '') {
            continue;
        }
        $out[] = ['id' => $id, 'title' => $title, 'body' => $body];
    }

    return $out;
}

/**
 * @return array{careerHighlights: list<array{stat: string, detail: string}>, roleFocus: list<array{title: string, body: string, href: string}>}
 */
function cms_recruiter_scan_from_data_file(): array
{
    $empty = ['careerHighlights' => [], 'roleFocus' => []];
    $data = cms_load_portfolio_data_json('recruiter-scan.json');
    if ($data === null) {
        return $empty;
    }

    $highlights = [];
    foreach ((array) ($data['careerHighlights'] ?? []) as $row) {
        if (!is_array($row)) {
            continue;
        }
        $stat = trim((string) ($row['stat'] ?? ''));
        if ($stat === '') {
            continue;
        }
        $highlights[] = [
            'stat' => $stat,
            'detail' => trim((string) ($row['detail'] ?? '')),
        ];
    }

    $focus = [];
    foreach ((array) ($data['roleFocus'] ?? []) as $row) {
        if (!is_array($row)) {
            continue;
        }
        $title = trim((string) ($row['title'] ?? ''));
        if ($title === '') {
            continue;
        }
        $href = trim((string) ($row['href'] ?? '#recent-portfolio'));
        if ($href === '') {
            $href = '#recent-portfolio';
        }
        $focus[] = [
            'title' => $title,
            'body' => trim((string) ($row['body'] ?? '')),
            'href' => $href,
        ];
    }

    return ['careerHighlights' => $highlights, 'roleFocus' => $focus];
}


/** MSR programme case studies for the featured grid (code-side; URLs are release targets). */

function cms_portfolio_request_is_local_dev(): bool
{
    $fullHost = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
    if ($fullHost === '') {
        return true;
    }
    $host = preg_replace('/:\d+$/', '', $fullHost) ?? $fullHost;
    if ($host === 'localhost' || $host === '127.0.0.1' || str_ends_with($host, '.local')) {
        return true;
    }
    if ($host === 'msreeves.co.uk' || $host === 'www.msreeves.co.uk') {
        return false;
    }

    return false;
}

function cms_portfolio_msr_publishing_demo_url(): string
{
    if (cms_portfolio_request_is_local_dev()) {
        return '/sites/wp/msrpublishing/';
    }

    return 'https://www.msreeves.co.uk/msrpublishing/';
}

function cms_portfolio_msr_products_demo_url(): string
{
    if (cms_portfolio_request_is_local_dev()) {
        return '/sites/wp/msrproducts/';
    }

    return 'https://www.msreeves.co.uk/msrproducts/';
}

/** Rewrite local estate paths in CMS HTML to release targets on live portfolio. */

function cms_portfolio_rewrite_estate_urls_in_html(string $html): string
{
    $target = cms_portfolio_msr_publishing_demo_url();
    if ($target === '/sites/wp/msrpublishing/') {
        return $html;
    }

    return str_replace('/sites/wp/msrpublishing/', $target, $html);
}


function cms_portfolio_link_is_external(string $url): bool
{
    $url = trim($url);
    if ($url === '' || str_starts_with($url, './') || str_starts_with($url, '/')) {
        return false;
    }
    if (!preg_match('#^https?://#i', $url)) {
        return false;
    }
    $host = strtolower((string) parse_url($url, PHP_URL_HOST));
    if ($host === '' || $host === '127.0.0.1' || $host === 'localhost' || str_ends_with($host, '.local')) {
        return false;
    }

    return true;
}


/**
 * Resolve special view_url tokens in selected-work.json (@msrpublishing = env-aware WP demo).
 */
function cms_resolve_case_study_view_url(string $url): string
{
    $url = trim($url);
    if ($url === '@msrpublishing') {
        return cms_portfolio_msr_publishing_demo_url();
    }
    if ($url === '@msrproducts') {
        return cms_portfolio_msr_products_demo_url();
    }

    return $url;
}

/**
 * @param array<string, mixed> $card
 * @return array<string, mixed>
 */
function cms_normalize_case_study_card(array $card): array
{
    if (isset($card['view_url']) && is_string($card['view_url'])) {
        $raw = trim($card['view_url']);
        if ($raw === '@msrpublishing' || $raw === '@msrproducts') {
            $card['view_url_token'] = $raw;
        }
        $card['view_url'] = cms_resolve_case_study_view_url($raw);
    }

    return $card;
}

/**
 * @return array{bands: array<string, list<string>>, cards: array<string, array<string, mixed>>}|null
 */
function cms_load_selected_work_config(): ?array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $path = __DIR__ . '/../data/selected-work.json';
    if (!is_readable($path)) {
        $cache = null;

        return null;
    }

    $data = json_decode((string) file_get_contents($path), true);
    if (!is_array($data) || !is_array($data['bands'] ?? null) || !is_array($data['cards'] ?? null)) {
        $cache = null;

        return null;
    }

    $cache = [
        'bands' => $data['bands'],
        'cards' => $data['cards'],
    ];
    if (isset($data['_comment']) && is_string($data['_comment'])) {
        $cache['_comment'] = $data['_comment'];
    }

    return $cache;
}

/**
 * Selected work case study cards — order from data/selected-work.json (CMS data).
 *
 * @return list<array<string, mixed>>
 */
function cms_msr_case_study_cards(): array
{
    $config = cms_load_selected_work_config();
    if ($config === null) {
        return [];
    }

    $order = [
        ...(array) ($config['bands']['lead'] ?? []),
        ...(array) ($config['bands']['currentFocus'] ?? []),
        ...(array) ($config['bands']['programme'] ?? []),
    ];

    $cards = [];
    foreach ($order as $id) {
        if (!is_string($id) || $id === '') {
            continue;
        }
        $raw = $config['cards'][$id] ?? null;
        if (!is_array($raw)) {
            continue;
        }
        $cards[] = cms_normalize_case_study_card($raw);
    }

    return $cards;
}

/**
 * Demo (now) vs live client (would enable) — rows from data/demo-vs-live.json.
 *
 * @return list<array{capability: string, demo: string, live: string, craft: string}>
 */
function cms_demo_vs_live_rows(): array
{
    $data = cms_load_portfolio_data_json('demo-vs-live.json');
    $rows = $data['rows'] ?? null;
    if (!is_array($rows)) {
        return [];
    }

    $out = [];
    foreach ($rows as $row) {
        if (!is_array($row)) {
            continue;
        }
        $capability = trim((string) ($row['capability'] ?? ''));
        if ($capability === '') {
            continue;
        }
        $out[] = [
            'capability' => $capability,
            'demo' => trim((string) ($row['demo'] ?? '')),
            'live' => trim((string) ($row['live'] ?? '')),
            'craft' => trim((string) ($row['craft'] ?? '')),
        ];
    }

    return $out;
}

/**
 * About employer logo strip — data/employer-logos.json.
 *
 * @return list<array{href: string, img: string, label: string}>
 */
function cms_employer_logo_items(): array
{
    $data = cms_load_portfolio_data_json('employer-logos.json');
    $items = $data['items'] ?? null;
    if (!is_array($items)) {
        return [];
    }

    $out = [];
    foreach ($items as $row) {
        if (!is_array($row)) {
            continue;
        }
        $img = trim((string) ($row['img'] ?? ''));
        $label = trim((string) ($row['label'] ?? ''));
        if ($img === '' || $label === '' || !str_starts_with($img, 'img_')) {
            continue;
        }
        $out[] = [
            'href' => trim((string) ($row['href'] ?? '')),
            'img' => $img,
            'label' => $label,
        ];
    }

    return $out;
}

/**
 * How I work role tracks — data/about-role-tracks.json.
 *
 * @return list<array<string, mixed>>
 */
function cms_about_role_tracks(): array
{
    $data = cms_load_portfolio_data_json('about-role-tracks.json');
    $tracks = $data['tracks'] ?? null;
    if (!is_array($tracks)) {
        return [];
    }

    $out = [];
    foreach ($tracks as $track) {
        if (!is_array($track)) {
            continue;
        }
        $title = trim((string) ($track['title'] ?? ''));
        if ($title === '') {
            continue;
        }
        $bullets = [];
        foreach ((array) ($track['bullets'] ?? []) as $bullet) {
            if (!is_array($bullet)) {
                continue;
            }
            $text = trim((string) ($bullet['text'] ?? ''));
            if ($text === '') {
                continue;
            }
            $bullets[] = [
                'icon' => trim((string) ($bullet['icon'] ?? 'fas fa-circle-check')),
                'text' => $text,
            ];
        }
        $slug = trim((string) ($track['slug'] ?? ''));
        if ($slug === '') {
            $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($title)) ?? '';
            $slug = trim($slug, '-');
        }

        $normalized = [
            'title' => $title,
            'slug' => $slug,
            'icon' => trim((string) ($track['icon'] ?? 'fas fa-circle-check')),
            'bullets' => $bullets,
        ];
        if (is_array($track['cta'] ?? null)) {
            $normalized['cta'] = $track['cta'];
        }
        $out[] = $normalized;
    }

    return $out;
}


function cms_intro_headline_for_hero(array $content): string
{
    $headline = trim((string) ($content['intro_hero_headline'] ?? ''));
    if ($headline !== '') {
        return $headline;
    }

    return 'Front-End WordPress Developer & CMS Specialist';
}


function cms_intro_tagline_for_hero(array $content): string
{
    $short = trim((string) ($content['intro_tagline_short'] ?? ''));
    if ($short !== '') {
        return $short;
    }

    return trim((string) ($content['intro_tagline'] ?? ''));
}


function cms_intro_method_for_hero(array $content): string
{
    $v = trim((string) ($content['intro_hero_method'] ?? ''));
    if ($v !== '') {
        return $v;
    }

    return trim((string) (cms_heading_defaults()['intro_hero_method'] ?? ''));
}


/**
 * Plain or rich CMS string with heading_defaults fallback.
 *
 * @param array<string, mixed> $content
 */
function cms_content_field(array $content, string $key): string
{
    $v = trim((string) ($content[$key] ?? ''));
    if ($v !== '') {
        return $v;
    }

    return trim((string) (cms_heading_defaults()[$key] ?? ''));
}


/**
 * Verified scale highlights for recruiter scan (sourced from Experience copy in site.json).
 *
 * @return list<array{stat: string, detail: string}>
 */
/**
 * @param array<string, mixed> $content
 * @return list<array{stat: string, detail: string}>
 */
function cms_career_highlight_items(array $content = []): array
{
    $fromFile = cms_recruiter_scan_from_data_file()['careerHighlights'];

    $raw = trim((string) ($content['career_highlights_json'] ?? ''));
    if ($raw === '') {
        return $fromFile;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return $fromFile;
    }

    $out = [];
    foreach ($decoded as $row) {
        if (!is_array($row)) {
            continue;
        }
        $stat = trim((string) ($row['stat'] ?? ''));
        if ($stat === '') {
            continue;
        }
        $out[] = [
            'stat' => $stat,
            'detail' => trim((string) ($row['detail'] ?? '')),
        ];
    }

    return $out !== [] ? $out : $fromFile;
}


/**
 * Lightweight role entry points (same page — scroll targets).
 *
 * @return list<array{title: string, body: string, href: string}>
 */
/**
 * @param array<string, mixed> $content
 * @return list<array{title: string, body: string, href: string}>
 */
function cms_role_focus_entries(array $content = []): array
{
    $fromFile = cms_recruiter_scan_from_data_file()['roleFocus'];

    $raw = trim((string) ($content['role_focus_json'] ?? ''));
    if ($raw === '') {
        return $fromFile;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return $fromFile;
    }

    $out = [];
    foreach ($decoded as $row) {
        if (!is_array($row)) {
            continue;
        }
        $title = trim((string) ($row['title'] ?? ''));
        if ($title === '') {
            continue;
        }
        $href = trim((string) ($row['href'] ?? '#recent-portfolio'));
        if ($href === '') {
            $href = '#recent-portfolio';
        }
        $out[] = [
            'title' => $title,
            'body' => trim((string) ($row['body'] ?? '')),
            'href' => $href,
        ];
    }

    return $out !== [] ? $out : $fromFile;
}


function cms_build_defaults(): array
{
    $out = array_merge(
        [
            'intro_name' => 'Michael Reeves',
            'intro_tagline' => 'Marketing & Digital Content Executive | Front-end Web/Wordpress Developer | Designer | Games Tester',
            'intro_tagline_short' => 'Building and maintaining digital publishing experiences, WordPress websites, and responsive front-end interfaces.',
            'about_heading' => 'About',
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


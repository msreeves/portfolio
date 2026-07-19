<?php
declare(strict_types=1);

/**
 * Portfolio CMS render helpers.
 */

/** Replace legacy Animate.css / WOW classes with msr-fade-in on stored HTML. */
function cms_normalize_fade_in_classes(string $html): string
{
    if ($html === '') {
        return '';
    }

    return str_replace(
        [
            'block animatable bounceIn intro-position',
            'block animatable bounceIn m-b-2',
            'block animatable bounceIn title',
            'block animatable bounceIn',
            'msr-reveal wow fadeInUp',
            ' wow fadeInUp',
            ' animatable',
        ],
        [
            'msr-fade-in',
            'msr-fade-in m-b-2',
            'msr-fade-in title',
            'msr-fade-in',
            'msr-fade-in',
            '',
            '',
        ],
        $html
    );
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

    return cms_normalize_fade_in_classes($html);
}

/** True when a CMS HTML block has visible text after tags are stripped. */


function cms_html_has_content(array $content, string $key): bool
{
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags(cms_html_raw($content, $key))));

    return $text !== '';
}


function cms_render_section_heading(string $title): void
{
    echo '<div class="portfolio-section-heading"><h2 class="portfolio-section-title">' . esc($title) . '</h2></div>';
}


function cms_msr_case_study_thumb_src(string $thumb): string
{
    $thumb = trim($thumb);
    if ($thumb === '') {
        return '';
    }
    if (str_starts_with($thumb, './')) {
        return $thumb;
    }

    return './' . ltrim($thumb, '/');
}


function cms_render_msr_case_study_grid(): void
{
    $cards = cms_msr_case_study_cards();
    if ($cards === []) {
        return;
    }

    $count = count($cards);
    echo '<div class="portfolio-content-grid portfolio-content-grid--cards msr-programme-grid msr-programme-grid--proof';
    echo esc(cms_portfolio_case_study_grid_modifiers($cards));
    echo '" data-card-count="' . (int) $count . '">';

    foreach ($cards as $card) {
        $featured = !empty($card['featured']);
        $thumb = cms_msr_case_study_thumb_src((string) ($card['thumb'] ?? ''));
        $thumbAlt = trim((string) ($card['thumb_alt'] ?? $card['title'] ?? 'Case study screenshot'));
        $bullets = $card['bullets'] ?? [];
        if (!is_array($bullets)) {
            $bullets = [];
        }

        echo '<div class="portfolio-grid-cell">';
        echo '<article class="msr-programme-card msr-fade-in';
        if ($featured) {
            echo ' msr-programme-card--lead';
        }
        echo '">';

        if ($thumb !== '') {
            echo '<div class="msr-programme-card-media">';
            echo '<img class="msr-programme-card-thumb" src="' . esc($thumb) . '" alt="' . esc($thumbAlt) . '" width="960" height="600" loading="lazy" decoding="async" />';
            echo '</div>';
        }

        echo '<div class="msr-programme-card-body">';
        if ($featured) {
            echo '<p class="msr-programme-card-eyebrow">Lead case study</p>';
        }
        echo '<h3 class="h5 msr-programme-card-title">' . esc((string) ($card['title'] ?? '')) . '</h3>';
        echo '<p class="msr-programme-card-stack">' . esc((string) ($card['stack'] ?? '')) . '</p>';

        if ($bullets !== []) {
            cms_render_icon_bullet_list($bullets, 'msr-case-study-bullets');
        } elseif (trim((string) ($card['summary'] ?? '')) !== '') {
            echo '<p class="msr-programme-card-summary">' . esc((string) $card['summary']) . '</p>';
        }

        echo '<p class="msr-programme-card-ctas">';
        echo '<a class="portfolio-chip portfolio-chip--primary" href="' . esc((string) ($card['view_url'] ?? '')) . '" target="_blank" rel="noopener noreferrer"><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i><span>View live</span></a>';
        echo '<a class="portfolio-chip portfolio-chip--secondary" href="' . esc((string) ($card['code_url'] ?? '')) . '" target="_blank" rel="noopener noreferrer"><i class="fab fa-github" aria-hidden="true"></i><span>GitHub</span></a>';
        echo '</p>';
        echo '</div></article></div>';
    }

    echo '</div>';
}


/**
 * Normalise a bullet to text + Font Awesome class (string bullets stay valid).
 *
 * @return array{text: string, icon: string}
 */
function cms_normalize_icon_bullet(mixed $item, string $fallbackIcon = 'fas fa-check'): array
{
    if (is_array($item)) {
        $text = trim((string) ($item['text'] ?? $item['label'] ?? ''));
        $icon = trim((string) ($item['icon'] ?? $fallbackIcon));

        return [
            'text' => $text,
            'icon' => $icon !== '' ? $icon : $fallbackIcon,
        ];
    }

    return [
        'text' => trim((string) $item),
        'icon' => $fallbackIcon,
    ];
}


/**
 * Echo an icon + text bullet list (case studies, role tracks, etc.).
 *
 * @param list<mixed> $items
 */
function cms_render_icon_bullet_list(array $items, string $ulClass, string $fallbackIcon = 'fas fa-check'): void
{
    $normalized = [];
    foreach ($items as $item) {
        $bullet = cms_normalize_icon_bullet($item, $fallbackIcon);
        if ($bullet['text'] === '') {
            continue;
        }
        $normalized[] = $bullet;
    }
    if ($normalized === []) {
        return;
    }

    echo '<ul class="' . esc(trim($ulClass . ' portfolio-icon-list')) . '">';
    foreach ($normalized as $bullet) {
        echo '<li>';
        echo '<i class="' . esc($bullet['icon']) . '" aria-hidden="true"></i>';
        echo '<span>' . esc($bullet['text']) . '</span>';
        echo '</li>';
    }
    echo '</ul>';
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


function cms_render_work_experience_section(array $content): void
{
    cms_render_panel_grid($content, cms_work_experience_primary_keys(), 'portfolio-content-grid--panels', 'portfolio-panel main_home work-experience-panel');

    $earlierKeys = array_values(array_filter(
        cms_work_experience_earlier_keys(),
        static fn (string $key): bool => cms_html_has_content($content, $key)
    ));
    if ($earlierKeys === []) {
        return;
    }

    echo '<details class="portfolio-disclosure work-experience-earlier msr-fade-in">';
    echo '<summary class="portfolio-disclosure-summary">Earlier roles</summary>';
    echo '<div class="portfolio-disclosure-body">';
    cms_render_panel_grid($content, $earlierKeys, 'portfolio-content-grid--panels', 'portfolio-panel main_home work-experience-panel');
    echo '</div></details>';
}


function cms_render_skill_tags(): void
{
    $tags = cms_skill_tag_items();
    if ($tags === []) {
        return;
    }

    echo '<ul class="portfolio-skill-tags" aria-label="Core skills">';
    foreach ($tags as $tag) {
        if (is_array($tag)) {
            $label = trim((string) ($tag['label'] ?? ''));
            $icon = trim((string) ($tag['icon'] ?? ''));
        } else {
            $label = trim((string) $tag);
            $icon = '';
        }
        if ($label === '') {
            continue;
        }
        echo '<li><span class="portfolio-skill-tag">';
        if ($icon !== '') {
            echo '<i class="' . esc($icon) . '" aria-hidden="true"></i>';
        }
        echo '<span>' . esc($label) . '</span></span></li>';
    }
    echo '</ul>';
}


function cms_render_skills_section(array $content): void
{
    cms_render_skill_tags();
}


/**
 * @param list<array{title: string, stack: string, summary: string, thumb: string, view_url: string, code_url: string}> $projects
 */
function cms_render_archive_projects_section(array $content, array $projects): void
{
    if ($projects === []) {
        return;
    }

    $heading = (string) ($content['heading_portfolio'] ?? 'Archive projects');
    $count = count($projects);
    $projectGridMods = cms_portfolio_grid_modifiers($count, 3);
    $countLabel = $count === 1 ? '1 project' : $count . ' projects';

    echo '<section id="portfolio" class="portfolio-archive-section" aria-labelledby="archive-projects-heading">';
    echo '<div class="container">';
    echo '<div class="portfolio-section-heading portfolio-archive-heading">';
    echo '<h2 id="archive-projects-heading" class="portfolio-section-title">' . esc($heading) . '</h2>';
    echo '<p class="portfolio-archive-count" aria-label="' . esc($countLabel) . '">' . esc($countLabel) . '</p>';
    echo '</div>';

    echo '<p class="portfolio-archive-intro">Student and side projects with live demos and GitHub links.</p>';

    echo '<div class="portfolio-content-grid portfolio-content-grid--projects portfolio-project-grid' . esc($projectGridMods) . '" data-project-count="' . (int) $count . '">';

    foreach ($projects as $project) {
        echo '<div class="portfolio-grid-cell">';
        echo '<article class="portfolio-project-card msr-fade-in">';
        echo '<div class="portfolio-project-card-media">';
        echo '<img class="portfolio-project-card-thumb" src="' . esc((string) ($project['thumb'] ?? '')) . '" alt="' . esc((string) ($project['title'] ?? '')) . '" loading="lazy" decoding="async" />';
        echo '</div><div class="portfolio-project-card-body">';
        echo '<h3 class="h5 portfolio-project-card-title">' . esc((string) ($project['title'] ?? '')) . '</h3>';
        if (trim((string) ($project['stack'] ?? '')) !== '') {
            echo '<p class="portfolio-project-card-stack">Languages: ' . esc((string) $project['stack']) . '</p>';
        }
        if (trim((string) ($project['summary'] ?? '')) !== '') {
            echo '<p class="portfolio-project-card-summary">' . esc((string) $project['summary']) . '</p>';
        }
        echo '<p class="portfolio-project-card-ctas">';
        if (trim((string) ($project['view_url'] ?? '')) !== '') {
            echo '<a class="portfolio-chip portfolio-chip--primary" href="' . esc((string) $project['view_url']) . '" target="_blank" rel="noopener noreferrer"><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i><span>View live</span></a>';
        }
        if (trim((string) ($project['code_url'] ?? '')) !== '') {
            echo '<a class="portfolio-chip portfolio-chip--secondary" href="' . esc((string) $project['code_url']) . '" target="_blank" rel="noopener noreferrer"><i class="fab fa-github" aria-hidden="true"></i><span>GitHub</span></a>';
        }
        echo '</p></div></article></div>';
    }

    echo '</div></div></section>';
}


/**
 * Prefer the largest column count ≤ $maxCols that divides $itemCount evenly.
 * Falls back to 2 (caller may add --fill-orphan for a leftover last row).
 */
function cms_portfolio_balanced_column_count(int $itemCount, int $maxCols = 3): int
{
    if ($itemCount <= 1) {
        return 1;
    }

    $max = min(max(1, $maxCols), $itemCount);
    for ($cols = $max; $cols >= 2; --$cols) {
        if ($itemCount % $cols === 0) {
            return $cols;
        }
    }

    return min(2, $itemCount);
}


/**
 * Count-based grid modifiers: even columns, solo/duo helpers, orphan fill when needed.
 */
function cms_portfolio_grid_modifiers(int $itemCount, int $maxCols = 3): string
{
    if ($itemCount <= 0) {
        return '';
    }

    $cols = cms_portfolio_balanced_column_count($itemCount, $maxCols);
    $mods = ' portfolio-content-grid--cols-' . $cols;

    if ($itemCount <= 1) {
        $mods .= ' portfolio-content-grid--solo';
    } elseif ($itemCount === 2) {
        $mods .= ' portfolio-content-grid--duo';
    }

    if ($cols > 1 && $itemCount % $cols !== 0) {
        $mods .= ' portfolio-content-grid--fill-orphan';
    }

    return $mods;
}


/**
 * Featured case studies: prefer 3 columns when the count divides evenly (6, 9…),
 * otherwise 2 with orphan fill. CSS steps 3 → 2 → 1 by breakpoint.
 *
 * @param list<array<string, mixed>> $cards
 */
function cms_portfolio_case_study_grid_modifiers(array $cards): string
{
    $count = count($cards);
    if ($count <= 0) {
        return '';
    }

    return cms_portfolio_grid_modifiers($count, 3) . ' portfolio-content-grid--fluid-proof';
}

/**
 * Employer logo tiles for the About section.
 *
 * @return list<array{href: string, img: string, label: string}>
 */
function cms_employer_logo_items(): array
{
    return [
        ['href' => 'https://www.bsigroup.com/', 'img' => 'img_gallery_bsi', 'label' => 'BSI Group'],
        ['href' => 'https://www.educationinvestor.co.uk/', 'img' => 'img_gallery_1', 'label' => 'Education Investor'],
        ['href' => 'https://www.healthinvestor.co.uk/', 'img' => 'img_gallery_2', 'label' => 'Health Investor'],
        ['href' => 'https://www.caring-times.co.uk/', 'img' => 'img_gallery_3', 'label' => 'Caring Times'],
        ['href' => 'https://www.ctownersclub.com/', 'img' => 'img_gallery_4', 'label' => 'CT Owners Club'],
        ['href' => 'https://www.nmt-magazine.co.uk/', 'img' => 'img_gallery_5', 'label' => 'NMT Magazine'],
        ['href' => 'https://www.nmtownersclub.com/', 'img' => 'img_gallery_6', 'label' => 'NMT Owners Club'],
        ['href' => 'https://www.nurseryworld.co.uk/', 'img' => 'img_gallery_9', 'label' => 'Nursery World'],
        ['href' => 'https://www.cypnow.co.uk/', 'img' => 'img_gallery_10', 'label' => 'CYP Now'],
        ['href' => 'https://www.rusi.org/', 'img' => 'img_gallery_11', 'label' => 'RUSI'],
        ['href' => 'https://www.gramophone.co.uk/', 'img' => 'img_gallery_12', 'label' => 'Gramophone'],
        ['href' => './media/pdf/bwie.pdf', 'img' => 'img_gallery_7', 'label' => 'BWIE'],
        ['href' => 'https://independentschoolmanagement.co.uk/', 'img' => 'img_gallery_8', 'label' => 'ISM'],
    ];
}

/** Work-experience panel keys in display order (primary résumé roles). */


function cms_work_experience_primary_keys(): array
{
    return [
        'html_work_bsi',
        'html_work_nexus',
    ];
}


/** Earlier roles shown in a collapsed band on the homepage. */


function cms_work_experience_earlier_keys(): array
{
    return [
        'html_work_markallen',
        'html_work_rusi',
        'html_work_indigo',
    ];
}


/** Employer work panels edited as title + body in the CMS admin. */


function cms_work_experience_employer_keys(): array
{
    return [
        'html_work_bsi',
        'html_work_nexus',
        'html_work_markallen',
        'html_work_rusi',
        'html_work_indigo',
    ];
}


function cms_work_experience_panel_keys(): array
{
    return array_merge(
        cms_work_experience_primary_keys(),
        cms_work_experience_earlier_keys()
    );
}

/** Recruiter-facing skill tags (primary skills row). */


function cms_skill_tag_items(): array
{
    // Single full-width Skills band — estate-aligned stack (case studies + employer tools).
    return [
        ['label' => 'WordPress', 'icon' => 'fab fa-wordpress'],
        ['label' => 'WordPress Multisite', 'icon' => 'fas fa-sitemap'],
        ['label' => 'WooCommerce', 'icon' => 'fas fa-cart-shopping'],
        ['label' => 'Ecommerce', 'icon' => 'fas fa-store'],
        ['label' => 'EpiServer', 'icon' => 'fas fa-globe'],
        ['label' => 'Drupal', 'icon' => 'fab fa-drupal'],
        ['label' => 'Umbraco', 'icon' => 'fas fa-cube'],
        ['label' => 'ACF', 'icon' => 'fas fa-puzzle-piece'],
        ['label' => 'PHP', 'icon' => 'fab fa-php'],
        ['label' => 'HTML5', 'icon' => 'fab fa-html5'],
        ['label' => 'CSS / SCSS', 'icon' => 'fab fa-sass'],
        ['label' => 'JavaScript', 'icon' => 'fab fa-js'],
        ['label' => 'TypeScript', 'icon' => 'fas fa-code'],
        ['label' => 'React', 'icon' => 'fab fa-react'],
        ['label' => 'Bootstrap', 'icon' => 'fab fa-bootstrap'],
        ['label' => 'Tailwind', 'icon' => 'fas fa-wind'],
        ['label' => 'Vite', 'icon' => 'fas fa-bolt'],
        ['label' => 'Node.js', 'icon' => 'fab fa-node-js'],
        ['label' => 'TanStack Query', 'icon' => 'fas fa-database'],
        ['label' => 'Zustand', 'icon' => 'fas fa-layer-group'],
        ['label' => 'Zod', 'icon' => 'fas fa-check-double'],
        ['label' => 'Git', 'icon' => 'fab fa-git-alt'],
        ['label' => 'Playwright QA', 'icon' => 'fas fa-flask'],
        ['label' => 'Accessibility', 'icon' => 'fas fa-universal-access'],
        ['label' => 'Lighthouse', 'icon' => 'fas fa-gauge-high'],
        ['label' => 'HubSpot', 'icon' => 'fab fa-hubspot'],
        ['label' => 'Canva', 'icon' => 'fas fa-palette'],
        ['label' => 'Photoshop', 'icon' => 'fas fa-image'],
        ['label' => 'Illustrator', 'icon' => 'fas fa-pen-nib'],
        ['label' => 'InDesign', 'icon' => 'fas fa-file-lines'],
        ['label' => 'Campaign design', 'icon' => 'fas fa-bullhorn'],
        ['label' => 'Grip', 'icon' => 'fas fa-handshake'],
        ['label' => 'Workfront', 'icon' => 'fas fa-diagram-project'],
    ];
}

/** Tailored downloads: role CVs, combined Full CV (subtle), marketing portfolio. */

function cms_cv_download_items(array $content): array
{
    return [
        [
            'id' => 'cms',
            'label' => trim((string) ($content['cv_cms_label'] ?? '')) ?: 'CMS CV',
            'href' => trim((string) ($content['cv_cms_pdf'] ?? '')) ?: './media/pdf/michael-reeves-cms-cv.pdf',
            'aria' => 'Download CMS specialist CV (PDF)',
            'icon' => 'fa-newspaper',
            'variant' => 'primary',
            'chip_class' => 'portfolio-chip--cv-cms',
            'footer_class' => 'footer-icon-link--cv-cms',
        ],
        [
            'id' => 'web',
            'label' => trim((string) ($content['cv_web_label'] ?? '')) ?: 'Developer CV',
            'href' => trim((string) ($content['cv_web_pdf'] ?? '')) ?: './media/pdf/michael-reeves-web-developer-cv.pdf',
            'aria' => 'Download front-end web developer CV (PDF)',
            'icon' => 'fa-code',
            'variant' => 'primary',
            'chip_class' => 'portfolio-chip--cv-web',
            'footer_class' => 'footer-icon-link--cv-web',
        ],
        [
            'id' => 'combined',
            'label' => trim((string) ($content['cv_combined_label'] ?? '')) ?: 'Full CV',
            'href' => trim((string) ($content['cv_combined_pdf'] ?? '')) ?: './media/pdf/michael-reeves-cv.pdf',
            'aria' => 'Download full CV combining CMS and developer experience (PDF)',
            'icon' => 'fa-file-lines',
            'variant' => 'subtle',
            'chip_class' => 'portfolio-chip--cv-combined',
            'footer_class' => 'footer-icon-link--cv-combined',
        ],
        [
            'id' => 'marketing',
            'label' => trim((string) ($content['cv_marketing_label'] ?? '')) ?: 'Marketing portfolio',
            'href' => trim((string) ($content['cv_marketing_pdf'] ?? '')) ?: './media/pdf/marketing-portfolio.pdf',
            'aria' => 'Download marketing and campaign design portfolio (PDF)',
            'icon' => 'fa-palette',
            'variant' => 'secondary',
            'chip_class' => 'portfolio-chip--cv-marketing',
            'footer_class' => 'footer-icon-link--cv-marketing',
        ],
    ];
}

/** Render labelled CV / portfolio download chips (hero, contact band, etc.). */

function cms_render_cv_download_chips(array $content, array $options = []): void
{
    $wrapClass = array_key_exists('wrap_class', $options)
        ? trim((string) $options['wrap_class'])
        : 'portfolio-cv-chips';
    $items = cms_cv_download_items($content);
    $extraLinks = $options['extra_links'] ?? [];

    $render = static function () use ($items, $extraLinks): void {
        foreach ($items as $item) {
            $variant = (string) ($item['variant'] ?? 'primary');
            if ($variant === 'subtle') {
                $tone = 'portfolio-chip--subtle';
            } elseif ($variant === 'secondary') {
                $tone = 'portfolio-chip--secondary';
            } else {
                $tone = 'portfolio-chip--primary';
            }
            $chipClass = 'portfolio-chip ' . $tone . ' portfolio-chip--cv ' . (string) ($item['chip_class'] ?? '');
            $icon = (string) ($item['icon'] ?? 'fa-file-pdf');
            ?>
        <a class="<?= esc(trim($chipClass)) ?>" href="<?= esc($item['href']) ?>" target="_blank" rel="noopener noreferrer" title="<?= esc($item['aria']) ?>">
            <i class="fas <?= esc($icon) ?>" aria-hidden="true"></i>
            <span><?= esc($item['label']) ?></span>
        </a>
            <?php
        }
        foreach ($extraLinks as $link) {
            $href = (string) ($link['href'] ?? '#');
            $label = (string) ($link['label'] ?? '');
            $class = (string) ($link['class'] ?? 'portfolio-chip portfolio-chip--secondary');
            if ($label === '') {
                continue;
            }
            ?>
        <a class="<?= esc($class) ?>" href="<?= esc($href) ?>"<?= !empty($link['external']) ? ' target="_blank" rel="noopener noreferrer"' : '' ?>><?= esc($label) ?></a>
            <?php
        }
    };

    if ($wrapClass === '') {
        $render();

        return;
    }

    echo '<span class="' . esc($wrapClass) . '">';
    $render();
    echo '</span>';
}

/** Footer PDF icon links — one per tailored CV. */

function cms_render_footer_cv_pdf_links(array $content): void
{
    foreach (cms_cv_download_items($content) as $item) {
        $icon = (string) ($item['icon'] ?? 'fa-file-pdf');
        $variant = (string) ($item['variant'] ?? 'primary');
        $footerClass = 'footer-cv-chip footer-cv-chip--' . $variant . ' ' . (string) ($item['footer_class'] ?? '');
        ?>
        <a href="<?= esc($item['href']) ?>" class="<?= esc(trim($footerClass)) ?>" aria-label="<?= esc($item['aria']) ?>" title="<?= esc($item['label']) ?>" target="_blank" rel="noopener noreferrer">
            <i class="fas <?= esc($icon) ?>" aria-hidden="true"></i>
            <span class="footer-cv-chip-label"><?= esc($item['label']) ?></span>
        </a>
        <?php
    }
}

/** Role tracks: CMS publishing, front-end WordPress, and marketing design. */

function cms_about_role_tracks(): array
{
    return [
        [
            'title' => 'CMS & publishing',
            'icon' => 'fas fa-newspaper',
            'bullets' => [
                ['icon' => 'fas fa-globe', 'text' => 'Enterprise content operations across 40+ international BSI websites in EpiServer'],
                ['icon' => 'fas fa-file-lines', 'text' => 'Multi-format publishing — blogs, webinars, white papers, and certification assets'],
                ['icon' => 'fas fa-people-group', 'text' => 'Workflow coordination with Workfront, HubSpot campaigns, and stakeholder teams'],
            ],
        ],
        [
            'title' => 'Front-end & WordPress',
            'icon' => 'fab fa-wordpress',
            'bullets' => [
                ['icon' => 'fas fa-paintbrush', 'text' => 'Responsive WordPress themes, ACF-driven content, and Vite-built programme sites'],
                ['icon' => 'fas fa-shield-halved', 'text' => 'MSR portfolio demos with machine-checkable acceptance and Playwright QA gates'],
                ['icon' => 'fas fa-robot', 'text' => 'AI-assisted delivery (Cursor) for faster troubleshooting, refactors, and prototyping'],
            ],
        ],
        [
            'title' => 'Marketing & campaign design',
            'icon' => 'fas fa-palette',
            'bullets' => [
                ['icon' => 'fas fa-envelope-open-text', 'text' => 'HubSpot email campaigns and landing pages for event registration and audience engagement'],
                ['icon' => 'fas fa-share-nodes', 'text' => 'Canva social and event assets for awards, power lists, and sector conferences'],
                ['icon' => 'fas fa-file-pdf', 'text' => 'Agency marketing samples collected in a downloadable portfolio PDF'],
            ],
            'cta' => [
                'href' => './media/pdf/marketing-portfolio.pdf',
                'label' => 'Marketing portfolio (PDF)',
                'icon' => 'fas fa-file-pdf',
            ],
        ],
    ];
}

function cms_render_about_role_tracks(): void
{
    $tracks = cms_about_role_tracks();
    if ($tracks === []) {
        return;
    }
    $trackMods = cms_portfolio_grid_modifiers(count($tracks), 3);
    ?>
    <div class="portfolio-role-tracks portfolio-content-grid<?= esc($trackMods) ?> msr-fade-in" aria-label="What I offer by role">
    <?php foreach ($tracks as $track) {
        $titleIcon = trim((string) ($track['icon'] ?? 'fas fa-circle-check'));
        $cta = is_array($track['cta'] ?? null) ? $track['cta'] : null;
        ?>
        <div class="portfolio-grid-cell"><div class="portfolio-role-track portfolio-panel main_home">
            <h3 class="title portfolio-role-track-title">
                <i class="<?= esc($titleIcon) ?>" aria-hidden="true"></i>
                <span><?= esc((string) $track['title']) ?></span>
            </h3>
            <?php cms_render_icon_bullet_list($track['bullets'] ?? [], 'portfolio-role-track-bullets', 'fas fa-check'); ?>
            <?php if ($cta !== null && trim((string) ($cta['href'] ?? '')) !== '' && trim((string) ($cta['label'] ?? '')) !== '') { ?>
            <p class="portfolio-role-track-cta">
                <a class="portfolio-chip portfolio-chip--secondary" href="<?= esc((string) $cta['href']) ?>" target="_blank" rel="noopener noreferrer">
                    <?php if (trim((string) ($cta['icon'] ?? '')) !== '') { ?>
                    <i class="<?= esc((string) $cta['icon']) ?>" aria-hidden="true"></i>
                    <?php } ?>
                    <span><?= esc((string) $cta['label']) ?></span>
                </a>
            </p>
            <?php } ?>
        </div></div>
    <?php } ?>
    </div>
    <?php
}


/** Skill icon tiles for the skills gallery (static set; grid adapts to count). */




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
        $cls = $first ? 'msr-fade-in' : 'msr-fade-in m-b-2';
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
    return cms_plain_paragraphs_class($plain, 'msr-fade-in m-b-2', false, null);
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
        . '<div class="head_title m-y-3 msr-fade-in"><div class="m-b-2"><div class="main_home">' . "\n"
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
        cms_work_experience_employer_keys(),
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
    if (in_array($key, cms_work_experience_employer_keys(), true)) {
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
    $h3 = '<h3 class="msr-fade-in title">' . esc($title) . '</h3>';
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

    if (in_array($key, cms_work_experience_employer_keys(), true)) {
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


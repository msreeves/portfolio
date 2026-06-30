<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
cms_require_login();

$dataPath = __DIR__ . '/../data/site.json';
require __DIR__ . '/../includes/site-bootstrap.php';
require __DIR__ . '/includes/cms-nav.php';

$labels = [
    'intro_name' => 'Intro — name (line 1)',
    'intro_tagline' => 'Intro — roles (line 2)',
    'about_heading' => 'About — section heading',
    'heading_recent_portfolio' => 'Heading: Recent portfolio',
    'heading_work_for' => 'Heading: Previous work experience',
    'heading_skills' => 'Heading: My skills',
    'heading_testimonials' => 'Heading: Testimonials',
    'heading_portfolio' => 'Heading: Past portfolio work',
    'heading_game_test' => 'Heading: Games tested',
    'heading_timeline' => 'Heading: Timeline',
    'footer_contact_heading' => 'Footer — contact heading',
    'footer_copyright' => 'Footer — copyright line',
];

$fragmentLabels = cms_fragment_labels();

$portfolioJsonCount = count(cms_portfolio_project_json_files());
$portfolioItemsLabel = 'Portfolio — thumbnails (items 1-' . max(1, $portfolioJsonCount) . ')';

$wizardSteps = [
    [
        'title' => 'Intro & about',
        'section_name' => 'Homepage top — name, roles line, about heading, and intro photo',
        'hint' => 'Short text shown at the top of the homepage. Nested groups follow the order of sections on the page. Use Browse on the intro photo to pick a file under media/.',
        'groups' => [
            ['label' => 'Intro — name & tagline', 'keys' => ['intro_name', 'intro_tagline']],
            ['label' => 'About — section heading', 'keys' => ['about_heading']],
            ['label' => 'Intro — main photo (left column)', 'layout' => 'grid', 'keys' => ['img_intro_logo']],
        ],
    ],
    [
        'title' => 'Header navigation',
        'section_name' => 'Top menu links, footer text, and footer logo',
        'hint' => 'Top menu on the homepage: use Add link / Remove on each row; choose a section to scroll to or a custom URL (https://, mailto:, ./path, or #anchor). Up to 15 links; order is left to right. Save in the sidebar updates the site. Below that, set the footer contact heading and copyright line, then the footer logo image under media/.',
        'groups' => [
            ['label' => 'Navbar links', 'keys' => ['__nav_block__']],
            ['label' => 'Footer text', 'keys' => ['footer_contact_heading', 'footer_copyright']],
            ['label' => 'Footer — logo', 'layout' => 'grid', 'keys' => ['img_footer_logo']],
        ],
    ],
    [
        'title' => 'Introduction & recent portfolio',
        'section_name' => 'Intro paragraphs, employer logos, section heading, and recent work strip',
        'hint' => 'Rich text editors (toolbar) for these blocks—same styling as the live site after save. The heading below is the on-page title above the recent portfolio block. Employer logos appear in the About strip; pick images under media/.',
        'groups' => [
            ['label' => '', 'keys' => ['heading_recent_portfolio']],
            ['label' => 'Introduction — item 1', 'keys' => ['html_introduction_1']],
            ['label' => 'Introduction — item 2', 'keys' => ['html_introduction_2']],
            ['label' => 'Recent portfolio — item 1', 'keys' => ['html_recent_portfolio_1']],
            ['label' => 'Recent portfolio — item 2', 'keys' => ['html_recent_portfolio_2']],
            [
                'label' => 'About — employer logos (items 1–8)',
                'layout' => 'grid',
                'grid_preset' => 'gallery',
                'keys' => [
                    'img_gallery_1',
                    'img_gallery_2',
                    'img_gallery_3',
                    'img_gallery_4',
                    'img_gallery_5',
                    'img_gallery_6',
                    'img_gallery_7',
                    'img_gallery_8',
                ],
            ],
        ],
    ],
    [
        'title' => 'Work experience',
        'section_name' => 'Previous jobs — section heading plus each role block',
        'hint' => 'Employer or project name, then a rich-text description (toolbar under the editor). Each block matches one job/role on the page.',
        'groups' => [
            ['label' => '', 'keys' => ['heading_work_for']],
            ['label' => 'Work — item 1 (Nexus)', 'keys' => ['html_work_nexus']],
            ['label' => 'Work — item 2 (Mark Allen Group)', 'keys' => ['html_work_markallen']],
            ['label' => 'Work — item 3 (Gaming intro)', 'keys' => ['html_work_gaming_intro']],
            ['label' => 'Work — item 4 (Indigo)', 'keys' => ['html_work_indigo']],
        ],
    ],
    [
        'title' => 'Skills & testimonials',
        'section_name' => 'Skills tiles, course list, and three-slide testimonials carousel',
        'hint' => 'Skills: heading plus course links — use Add course / Remove on each row (course tiles use the same grid rhythm as the skill icons on the site). Click Save in the sidebar to publish. Set the Canva and Grip tile images below. Testimonials: three slides for the homepage carousel (swipe / arrows). Each slide: name line + rich-text quote; the large quote icon is added on save.',
        'groups' => [
            ['label' => '', 'keys' => ['heading_skills', 'heading_testimonials']],
            ['label' => 'Skills — online courses & list', 'keys' => ['html_skills_courses']],
            ['label' => 'Skills — tile images', 'layout' => 'grid', 'keys' => ['img_skill_canva', 'img_skill_grip']],
            ['label' => 'Testimonials — slide 1', 'keys' => ['html_testimonial_1']],
            ['label' => 'Testimonials — slide 2', 'keys' => ['html_testimonial_2']],
            ['label' => 'Testimonials — slide 3', 'keys' => ['html_testimonial_3']],
        ],
    ],
    [
        'title' => 'Portfolio overlays',
        'section_name' => 'Past work grid — thumbnails, section title, and each tile’s overlay',
        'hint' => 'Set the section title, then each thumbnail for the six homepage tiles, then use Prev/Next in the overlay editor to edit each tile’s lightbox (title, subtitle, description, and link buttons). Files under media/. Click Save in the sidebar to publish.',
        'groups' => [
            ['label' => '', 'keys' => ['heading_portfolio']],
            ['label' => $portfolioItemsLabel, 'keys' => ['__portfolio_json_block__']],
        ],
    ],
    [
        'title' => 'Games & timeline',
        'section_name' => 'Games tested list & timeline carousel slides',
        'hint' => 'Games: use Add game / Remove on each row (only filled titles show on the site); Save publishes. Timeline: carousel slides for the homepage (swipe / arrows). Use Add slide / Remove slide and Prev/Next; Save publishes.',
        'groups' => [
            ['label' => '', 'keys' => ['heading_game_test', 'heading_timeline']],
            ['label' => 'Games tested', 'keys' => ['html_games_tested']],
            ['label' => 'Timeline carousel (all slides)', 'keys' => ['__timeline_block__']],
        ],
    ],
];

$stepCount = count($wizardSteps);
$message = '';
$error = '';

if (isset($_GET['saved']) && $_GET['saved'] === '1') {
    $message = 'Saved. View the site homepage to see changes.';
}

/**
 * Persist editable project card fields (title/stack/summary) back into ./projects/*.json.
 */
function cms_save_portfolio_project_cards(array $post): ?string
{
    /** @var mixed $pathsRaw */
    $pathsRaw = $post['project_json_path'] ?? [];
    /** @var mixed $titlesRaw */
    $titlesRaw = $post['project_json_title'] ?? [];
    /** @var mixed $stacksRaw */
    $stacksRaw = $post['project_json_stack'] ?? [];
    /** @var mixed $summariesRaw */
    $summariesRaw = $post['project_json_summary'] ?? [];

    if (!is_array($pathsRaw) || !is_array($titlesRaw) || !is_array($stacksRaw) || !is_array($summariesRaw)) {
        return null;
    }

    $allowed = array_fill_keys(cms_portfolio_project_json_files(), true);
    $count = count($pathsRaw);

    for ($i = 0; $i < $count; ++$i) {
        $relPath = trim((string) ($pathsRaw[$i] ?? ''));
        if ($relPath === '' || !isset($allowed[$relPath])) {
            continue;
        }

        $absPath = __DIR__ . '/../' . ltrim(str_replace('./', '', $relPath), '/');
        $raw = is_readable($absPath) ? (string) file_get_contents($absPath) : '';
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            $data = [];
        }

        $data['title'] = trim((string) ($titlesRaw[$i] ?? ''));
        $data['stack'] = trim((string) ($stacksRaw[$i] ?? ''));
        $data['summary'] = trim((string) ($summariesRaw[$i] ?? ''));

        try {
            $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return 'Could not encode project file: ' . basename($absPath);
        }

        if (file_put_contents($absPath, $json . "\n") === false) {
            return 'Could not write project file: ' . basename($absPath);
        }
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string) ($_POST['csrf'] ?? '');
    if (!cms_verify_csrf($token)) {
        $error = 'Invalid session. Please sign in again.';
    } else {
        $base = load_site_content();
        $out = $base;
        foreach ($wizardSteps as $stepDef) {
            $out = cms_apply_wizard_step_post($out, $stepDef, $_POST);
        }
        $missing = [];
        foreach (['intro_name', 'intro_tagline', 'about_heading'] as $req) {
            if (($out[$req] ?? '') === '') {
                $missing[] = $req;
            }
        }
        if ($missing !== []) {
            $error = 'Required fields empty: ' . implode(', ', $missing);
        } else {
            try {
                $json = json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                $json = null;
                $error = 'Could not encode data.';
            }
            if ($json !== null) {
                if (file_put_contents($dataPath, $json) === false) {
                    $error = 'Could not write data/site.json. Check folder permissions.';
                } else {
                    $projectSaveError = cms_save_portfolio_project_cards($_POST);
                    if ($projectSaveError !== null) {
                        $error = $projectSaveError;
                    } else {
                        $openN = max(1, min($stepCount, (int) ($_POST['cms_open_panel_n'] ?? 1)));
                        header('Location: edit.php?saved=1&open=' . $openN, true, 303);
                        exit;
                    }
                }
            }
        }
    }
}

$current = load_site_content();

$openN = 1;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cms_open_panel_n'])) {
    $openN = max(1, min($stepCount, (int) $_POST['cms_open_panel_n']));
} elseif (isset($_GET['open'])) {
    $openN = max(1, min($stepCount, (int) $_GET['open']));
} elseif (isset($_GET['p'])) {
    $openN = max(1, min($stepCount, (int) $_GET['p']));
}

function cms_edit_image_field(string $key, string $value, string $label, bool $gridCell = false): void
{
    $defaults = cms_image_paths_defaults();
    $display = trim($value) !== '' ? trim($value) : ($defaults[$key] ?? '');
    $prev = '';
    if ($display !== '' && str_starts_with($display, './')) {
        $prev = '..' . substr($display, 1);
    }

    $wrapClass = $gridCell
        ? 'cms-img-field cms-img-field--grid h-100'
        : 'cms-img-field mb-3 pb-3 border-bottom border-light-subtle';
    echo '<div class="' . esc($wrapClass) . '">';
    $labelClass = $gridCell ? 'form-label cms-img-field__label' : 'form-label';
    echo '<label class="' . esc($labelClass) . '" for="' . esc($key) . '">' . esc($label) . '</label>';
    echo '<div class="cms-media-picker" data-mode="image">';
    echo '<input type="hidden" class="cms-img-path-input cms-media-picker-input" name="' . esc($key) . '" id="' . esc($key) . '" value="' . esc($display) . '" />';
    if ($gridCell) {
        echo '<div class="cms-img-field__preview-row">';
        echo '<div class="cms-media-picker-preview cms-media-picker-preview--image cms-img-field__thumb">';
        if ($prev !== '') {
            echo '<img class="cms-img-preview img-fluid rounded mw-100" src="' . esc($prev) . '" alt="" loading="lazy" />';
        } else {
            echo '<span class="cms-img-field__empty">No image</span>';
        }
        echo '</div>';
        echo '<button type="button" class="btn btn-outline-secondary cms-media-picker-open cms-img-field__browse">Browse…</button>';
        echo '</div>';
        echo '<p class="cms-img-field__hint form-text small mb-0">Choose from <code class="cms-img-field__code">media/</code> on the server.</p>';
    } else {
        echo '<div class="d-flex flex-wrap align-items-center gap-3">';
        echo '<div class="cms-media-picker-preview cms-media-picker-preview--image rounded border p-2 text-center bg-body-secondary flex-shrink-0" style="min-width:120px;min-height:100px">';
        if ($prev !== '') {
            echo '<img class="cms-img-preview img-fluid rounded mw-100" src="' . esc($prev) . '" alt="" style="max-height:120px;object-fit:contain" loading="lazy" />';
        } else {
            echo '<span class="text-muted small">No image</span>';
        }
        echo '</div>';
        echo '<button type="button" class="btn btn-outline-secondary cms-media-picker-open">Browse…</button>';
        echo '</div>';
        echo '<p class="form-text small mb-0 mt-1">Pick a file under <code>media/</code> with Browse.</p>';
    }
    echo '</div></div>';
}

/**
 * @param array{__role?: string, __dates?: string, __location?: string, __body?: string} $parts
 */
function cms_edit_timeline_slide_fields(array $parts, string $imgDisplay, string $imgPrevRel, bool $isTemplate, string $slideClassExtra = ''): void
{
    $bodyHint = esc(cms_wysiwyg_format_help_short());
    $role = $isTemplate ? '' : esc($parts['__role'] ?? '');
    $dates = $isTemplate ? '' : esc($parts['__dates'] ?? '');
    $location = $isTemplate ? '' : esc($parts['__location'] ?? '');
    $body = $isTemplate ? '' : esc($parts['__body'] ?? '');
    $imgEsc = $isTemplate ? '' : esc($imgDisplay);
    $imgSrc = $isTemplate ? '' : esc($imgPrevRel);

    echo '<div class="cms-timeline-slide' . ($isTemplate ? ' d-none' : '') . $slideClassExtra . '" role="group"' . ($isTemplate ? ' data-cms-timeline-template="1"' : '') . '>';
    echo '<p class="small fw-semibold text-secondary mb-2 cms-timeline-slide-label">Slide</p>';
    echo '<div class="mb-2"><label class="form-label small">Role or company</label>';
    echo '<input type="text" class="form-control form-control-sm" name="tl_slide[][__role]" value="' . $role . '" autocomplete="off" spellcheck="true" /></div>';
    echo '<div class="mb-2"><label class="form-label small">Date range</label>';
    echo '<input type="text" class="form-control form-control-sm" name="tl_slide[][__dates]" value="' . $dates . '" placeholder="e.g. Jan 2020 – Mar 2021" autocomplete="off" /></div>';
    echo '<div class="mb-2"><label class="form-label small">Location (optional)</label>';
    echo '<input type="text" class="form-control form-control-sm" name="tl_slide[][__location]" value="' . $location . '" autocomplete="off" /></div>';
    echo '<div class="mb-2"><label class="form-label small">Description</label>';
    echo '<p class="form-text small mb-1">' . $bodyHint . '</p>';
    echo '<textarea class="form-control form-control-sm cms-wysiwyg" name="tl_slide[][__body]" rows="8" spellcheck="true">' . $body . '</textarea></div>';
    echo '<div class="mt-1"><label class="form-label small">Slide icon</label>';
    echo '<div class="cms-media-picker" data-mode="image">';
    echo '<input type="hidden" class="cms-img-path-input cms-timeline-img-input cms-media-picker-input" name="tl_slide[][img]" value="' . $imgEsc . '" />';
    echo '<div class="d-flex flex-wrap align-items-center gap-2">';
    echo '<div class="cms-media-picker-preview rounded border p-1 text-center bg-body-secondary flex-shrink-0" style="min-height:72px;min-width:100px;max-width:140px">';
    if ($imgSrc !== '') {
        echo '<img class="cms-timeline-img-preview img-fluid rounded" src="' . $imgSrc . '" alt="" style="max-height:72px;max-width:120px;object-fit:contain" loading="lazy" />';
    } else {
        echo '<span class="text-muted small">No image</span>';
    }
    echo '</div>';
    echo '<button type="button" class="btn btn-sm btn-outline-secondary cms-media-picker-open">Browse…</button>';
    echo '</div></div></div></div>';
}

function cms_edit_timeline_slider(array $current): void
{
    $max = cms_timeline_max_slides();
    $slideCount = max(1, cms_timeline_effective_count($current));
    $defs = cms_image_paths_defaults();

    echo '<div class="mb-4 cms-timeline-editor border rounded-3 p-3 bg-body-secondary" id="cms-timeline-editor" data-max-slides="' . (int) $max . '">';
    echo '<h3 class="h6 text-uppercase text-secondary border-bottom pb-2 mb-2">Timeline slides <span class="text-muted fw-normal text-lowercase small">(homepage carousel)</span></h3>';
    echo '<p class="form-text small text-secondary mb-3">On the site, these appear as a horizontal carousel (swipe, arrows). Here, use <strong>Prev</strong> / <strong>Next</strong> to edit each slide. <strong>Add slide</strong> appends an empty slide; <strong>Remove slide</strong> deletes the slide you are viewing (at least one row stays). <strong>Save</strong> in the sidebar applies the order shown top-to-bottom and updates the live site.</p>';
    echo '<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 cms-timeline-toolbar">';
    echo '<span class="small fw-semibold text-secondary" id="cms-timeline-counter" aria-live="polite">Slide 1 of ' . (int) $slideCount . '</span>';
    echo '<div class="btn-group btn-group-sm" role="group" aria-label="Switch slide">';
    echo '<button type="button" class="btn btn-outline-secondary" id="cms-tl-prev" aria-label="Previous slide">← Prev</button>';
    echo '<button type="button" class="btn btn-outline-secondary" id="cms-tl-next" aria-label="Next slide">Next →</button>';
    echo '</div>';
    echo '<div class="btn-group btn-group-sm" role="group" aria-label="Add or remove slide">';
    echo '<button type="button" class="btn btn-outline-primary" id="cms-tl-add">Add slide</button>';
    echo '<button type="button" class="btn btn-outline-danger" id="cms-tl-remove">Remove slide</button>';
    echo '</div></div>';

    echo '<template id="cms-timeline-slide-template">';
    cms_edit_timeline_slide_fields([], '', '', true);
    echo '</template>';

    echo '<div id="cms-timeline-slides">';
    for ($i = 1; $i <= $slideCount; ++$i) {
        $html = (string) ($current['html_timeline_' . $i] ?? '');
        $parts = cms_timeline_parse_fragment_html($html);
        $ik = 'img_timeline_' . $i;
        $imgVal = trim((string) ($current[$ik] ?? ''));
        if ($imgVal === '') {
            $imgVal = $defs[$ik] ?? '';
        }
        $prev = '';
        if ($imgVal !== '' && str_starts_with($imgVal, './')) {
            $prev = '..' . substr($imgVal, 1);
        }
        cms_edit_timeline_slide_fields($parts, $imgVal, $prev, false, $i === 1 ? ' is-active' : '');
    }
    echo '</div></div>';
}

/**
 * Portfolio overlay fields (one grid tile) — shared by split-fragment edit and carousel editor.
 *
 * @param array<string, string> $parts
 */
function cms_edit_portfolio_overlay_fields_inner(string $k, array $parts, string $bodyHintEsc): void
{
    $tid = $k . '__title';
    $gid = $k . '__tagline';
    $bid = $k . '__body';
    $btnSlots = cms_portfolio_button_slot_count();
    echo '<div class="mb-3"><label class="form-label" for="' . esc($tid) . '">Project title</label>';
    echo '<input type="text" class="form-control" id="' . esc($tid) . '" name="' . esc($tid) . '" value="' . esc($parts['__title']) . '" /></div>';
    echo '<div class="mb-3"><label class="form-label" for="' . esc($gid) . '">Subtitle or tech line</label>';
    echo '<p class="form-text small mb-2">Shown under the title (e.g. languages or stack). Use the <strong>Highlight</strong> toolbar style for accent emphasis.</p>';
    echo '<textarea class="form-control cms-wysiwyg cms-wysiwyg-compact" name="' . esc($gid) . '" id="' . esc($gid) . '" rows="4" spellcheck="true">' . esc($parts['__tagline'] ?? '') . '</textarea></div>';
    echo '<div class="mb-3"><label class="form-label" for="' . esc($bid) . '">Description</label>';
    echo '<p class="form-text small mb-2">Main project write-up. ' . $bodyHintEsc . '</p>';
    echo '<textarea class="form-control cms-wysiwyg" name="' . esc($bid) . '" id="' . esc($bid) . '" rows="10" spellcheck="true">' . esc($parts['__body']) . '</textarea></div>';
    echo '<p class="small fw-semibold text-secondary mb-1">Link buttons</p>';
    echo '<p class="form-text small mb-2">Each row needs a URL to appear on the site. Suggested labels: VIEW / SEE CODE. Use <strong>Save</strong> in the sidebar to update this tile on the live site.</p>';
    echo '<div class="d-none d-md-flex row g-2 small fw-semibold text-secondary mb-1 px-1"><div class="col-md-4">Button text</div><div class="col-md-8">URL</div></div>';
    for ($i = 1; $i <= $btnSlots; ++$i) {
        $lk = $k . '__btn' . $i . '_label';
        $uk = $k . '__btn' . $i . '_url';
        $lv = $parts['__btn' . $i . '_label'] ?? '';
        $uv = $parts['__btn' . $i . '_url'] ?? '';
        $urlSuffix = trim((string) $uv);
        if ($urlSuffix !== '') {
            $urlSuffix = preg_replace('#^https?://#i', '', $urlSuffix) ?? $urlSuffix;
            $urlSuffix = preg_replace('#^www\.#i', '', $urlSuffix) ?? $urlSuffix;
        }
        $ph = $i === 1 ? 'VIEW' : 'SEE CODE';
        echo '<div class="row g-2 align-items-center mb-2">';
        echo '<div class="col-md-4"><label class="form-label small d-md-none mb-0" for="' . esc($lk) . '">Button ' . (int) $i . ' — text</label>';
        echo '<input type="text" class="form-control form-control-sm" id="' . esc($lk) . '" name="' . esc($lk) . '" value="' . esc($lv) . '" placeholder="' . esc($ph) . '" autocomplete="off" /></div>';
        echo '<div class="col-md-8"><label class="form-label small d-md-none mb-0" for="' . esc($uk) . '">Button ' . (int) $i . ' — URL</label>';
        echo '<input type="hidden" class="cms-url-lock-hidden" id="' . esc($uk) . '" name="' . esc($uk) . '" value="' . esc($uv) . '" />';
        echo '<div class="input-group input-group-sm">';
        echo '<span class="input-group-text">https://www.</span>';
        echo '<input type="text" class="form-control cms-url-lock-suffix" value="' . esc($urlSuffix) . '" placeholder="example.com/path" autocomplete="off" spellcheck="false" inputmode="url" data-url-target="' . esc($uk) . '" />';
        echo '</div></div>';
        echo '</div>';
    }
}

function cms_edit_portfolio_slide_fields(string $k, string $html, string $slideClassExtra): void
{
    $parts = cms_html_parse_split_parts($k, $html);
    if ($parts === null) {
        return;
    }
    $n = 0;
    if (preg_match('#^html_portfolio_(\d+)$#', $k, $m) === 1) {
        $n = (int) $m[1];
    }
    $bodyHint = esc(cms_wysiwyg_format_help_short());
    echo '<div class="cms-portfolio-slide' . $slideClassExtra . '" role="group">';
    echo '<p class="small fw-semibold text-secondary mb-2">Tile ' . (int) $n . ' overlay <span class="text-muted fw-normal">(grid column ' . (int) $n . ')</span></p>';
    cms_edit_portfolio_overlay_fields_inner($k, $parts, $bodyHint);
    echo '</div>';
}

function cms_edit_portfolio_overlays_slider(array $current): void
{
    $n = cms_portfolio_overlay_slot_count();
    echo '<div class="mb-0 cms-portfolio-editor border rounded-3 p-3 bg-body-secondary" id="cms-portfolio-editor" data-portfolio-slots="' . (int) $n . '">';
    echo '<h3 class="h6 text-uppercase text-secondary border-bottom pb-2 mb-2">Portfolio overlay content <span class="text-muted fw-normal text-lowercase small">(lightbox per tile)</span></h3>';
    echo '<p class="form-text small text-secondary mb-3">The homepage grid has six tiles. Set each thumbnail image in the <strong>Portfolio — thumbnails</strong> group above. Use <strong>Prev</strong> / <strong>Next</strong> below to edit one overlay at a time (like the timeline carousel). <strong>Save</strong> in the sidebar writes every tile to the site—edits here are not live until you save.</p>';
    echo '<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 cms-portfolio-toolbar">';
    echo '<span class="small fw-semibold text-secondary" id="cms-portfolio-counter" aria-live="polite">Tile 1 of ' . (int) $n . '</span>';
    echo '<div class="btn-group btn-group-sm" role="group" aria-label="Switch portfolio tile">';
    echo '<button type="button" class="btn btn-outline-secondary" id="cms-pf-prev" aria-label="Previous tile">← Prev</button>';
    echo '<button type="button" class="btn btn-outline-secondary" id="cms-pf-next" aria-label="Next tile">Next →</button>';
    echo '</div></div>';
    echo '<div id="cms-portfolio-items">';
    for ($i = 1; $i <= $n; ++$i) {
        $pk = 'html_portfolio_' . $i;
        cms_edit_portfolio_slide_fields($pk, (string) ($current[$pk] ?? ''), $i === 1 ? ' is-active' : '');
    }
    echo '</div></div>';
}

/**
 * @param array<string, string> $fragmentLabels
 */
function cms_edit_split_fragment_fields(string $k, string $html, array $fragmentLabels): void
{
    $parts = cms_html_parse_split_parts($k, $html);
    if ($parts === null) {
        return;
    }

    $mainLabel = $fragmentLabels[$k] ?? $k;

    echo '<div class="mb-4">';
    echo '<h3 class="h6 text-uppercase text-secondary border-bottom pb-2 mb-3">' . esc($mainLabel) . '</h3>';

    $bodyHint = esc(cms_wysiwyg_format_help_short());

    if (in_array($k, ['html_work_nexus', 'html_work_markallen', 'html_work_indigo'], true)) {
        $tid = $k . '__title';
        $bid = $k . '__body';
        echo '<div class="mb-3"><label class="form-label" for="' . esc($tid) . '">Employer or project name</label>';
        echo '<input type="text" class="form-control" id="' . esc($tid) . '" name="' . esc($tid) . '" value="' . esc($parts['__title']) . '" /></div>';
        echo '<div class="mb-0"><label class="form-label" for="' . esc($bid) . '">Job description & details</label>';
        echo '<p class="form-text small mb-2">' . $bodyHint . '</p>';
        echo '<textarea class="form-control cms-wysiwyg" name="' . esc($bid) . '" id="' . esc($bid) . '" rows="12" spellcheck="true">' . esc($parts['__body']) . '</textarea></div>';
    } elseif (preg_match('#^html_testimonial_\d+$#', $k) === 1) {
        $tid = $k . '__title';
        $bid = $k . '__body';
        echo '<div class="mb-3"><label class="form-label" for="' . esc($tid) . '">Name & role</label>';
        echo '<input type="text" class="form-control" id="' . esc($tid) . '" name="' . esc($tid) . '" value="' . esc($parts['__title']) . '" placeholder="e.g. Jane Doe — Manager at Company" /></div>';
        echo '<div class="mb-0"><label class="form-label" for="' . esc($bid) . '">Quote</label>';
        echo '<p class="form-text small mb-2">This field is one slide in the three-slide testimonials carousel on the homepage (order: quote 1 → 2 → 3). The large quote icon is added automatically. ' . $bodyHint . '</p>';
        echo '<textarea class="form-control cms-wysiwyg" name="' . esc($bid) . '" id="' . esc($bid) . '" rows="12" spellcheck="true">' . esc($parts['__body']) . '</textarea></div>';
    } elseif ($k === 'html_skills_courses') {
        $hid = $k . '__heading';
        echo '<div class="mb-3"><label class="form-label" for="' . esc($hid) . '">Section heading</label>';
        echo '<input type="text" class="form-control" id="' . esc($hid) . '" name="' . esc($hid) . '" value="' . esc($parts['__heading']) . '" /></div>';
        $skillCap = cms_skills_course_row_count();
        $courseRows = [];
        for ($i = 1; $i <= $skillCap; ++$i) {
            $nv = trim((string) ($parts['__course_' . $i . '_name'] ?? ''));
            $uv = trim((string) ($parts['__course_' . $i . '_url'] ?? ''));
            if ($nv === '' && $uv === '') {
                continue;
            }
            $courseRows[] = ['name' => $nv, 'url' => $uv];
        }
        echo '<div class="cms-skills-editor cms-button-panel border rounded-3 p-3 mb-0 bg-body-secondary" id="cms-skills-editor" data-max-rows="' . (int) $skillCap . '">';
        echo '<p class="small fw-semibold text-secondary mb-1">Course links</p>';
        echo '<p class="form-text small mb-2">Each course is a tile in the same <strong>4×2×1 column grid</strong> rhythm as the skill icons on the homepage. Use <strong>Add course</strong> / <strong>Remove</strong> to change rows; use <strong>Browse…</strong> for a <strong>PDF or image</strong> under <code>media/</code>. <strong>Save</strong> in the sidebar updates the live site.</p>';
        echo '<p class="mb-3"><button type="button" class="btn btn-sm btn-outline-primary" id="cms-skills-add">Add course</button></p>';
        echo '<div id="cms-skills-rows" class="cms-skills-rows-grid">';
        foreach ($courseRows as $cr) {
            echo '<div class="cms-skills-row cms-skills-tile">';
            echo '<div class="cms-skills-tile__actions"><button type="button" class="btn btn-sm btn-outline-danger cms-skills-remove w-100">Remove</button></div>';
            echo '<div class="cms-skills-tile__name">';
            echo '<label class="form-label small mb-1">Course name</label>';
            echo '<textarea class="form-control form-control-sm cms-skills-tile__course-name" name="skills_course_name[]" rows="2" placeholder="e.g. WordPress course" autocomplete="off" spellcheck="true">' . esc($cr['name']) . '</textarea></div>';
            echo '<div class="cms-skills-tile__media">';
            echo '<label class="form-label small mb-1">Media (PDF or image)</label>';
            echo '<div class="cms-media-picker" data-mode="course">';
            echo '<input type="hidden" class="cms-media-picker-input cms-course-url-input" name="skills_course_url[]" value="' . esc($cr['url']) . '" />';
            echo '<div class="cms-skills-tile__preview-row">';
            echo '<div class="cms-media-picker-preview cms-media-picker-preview--course cms-skills-tile__thumb rounded border bg-body-secondary"></div>';
            echo '<button type="button" class="btn btn-sm btn-outline-secondary cms-media-picker-open cms-skills-tile__browse w-100">Browse…</button>';
            echo '</div></div></div>';
            echo '</div>';
        }
        echo '</div>';
        echo '<template id="cms-skills-row-template">';
        echo '<div class="cms-skills-row cms-skills-tile">';
        echo '<div class="cms-skills-tile__actions"><button type="button" class="btn btn-sm btn-outline-danger cms-skills-remove w-100">Remove</button></div>';
        echo '<div class="cms-skills-tile__name">';
        echo '<label class="form-label small mb-1">Course name</label>';
        echo '<textarea class="form-control form-control-sm cms-skills-tile__course-name" name="skills_course_name[]" rows="2" placeholder="e.g. WordPress course" autocomplete="off" spellcheck="true"></textarea></div>';
        echo '<div class="cms-skills-tile__media">';
        echo '<label class="form-label small mb-1">Media (PDF or image)</label>';
        echo '<div class="cms-media-picker" data-mode="course">';
        echo '<input type="hidden" class="cms-media-picker-input cms-course-url-input" name="skills_course_url[]" value="" />';
        echo '<div class="cms-skills-tile__preview-row">';
        echo '<div class="cms-media-picker-preview cms-media-picker-preview--course cms-skills-tile__thumb rounded border bg-body-secondary"></div>';
        echo '<button type="button" class="btn btn-sm btn-outline-secondary cms-media-picker-open cms-skills-tile__browse w-100">Browse…</button>';
        echo '</div></div></div>';
        echo '</div>';
        echo '</template>';
        echo '</div>';
    } elseif ($k === 'html_games_tested') {
        $gameCap = cms_games_slot_count();
        $titles = [];
        for ($i = 1; $i <= $gameCap; ++$i) {
            $t = trim((string) ($parts['__game_' . $i] ?? ''));
            if ($t !== '') {
                $titles[] = $t;
            }
        }
        echo '<div class="cms-games-editor mb-0" id="cms-games-editor" data-max-rows="' . (int) $gameCap . '">';
        echo '<p class="form-text small text-secondary mb-2">Only filled titles appear on the site. <strong>Add game</strong> / <strong>Remove</strong> only change this form until you click <strong>Save</strong> in the sidebar.</p>';
        echo '<p class="mb-3"><button type="button" class="btn btn-sm btn-outline-primary" id="cms-games-add">Add game</button></p>';
        echo '<div class="row g-2 align-items-center" id="cms-games-rows">';
        foreach ($titles as $gt) {
            echo '<div class="col-12 col-md-6 col-lg-4 cms-games-row d-flex gap-2 align-items-center">';
            echo '<input type="text" class="form-control form-control-sm flex-grow-1" name="games_title[]" value="' . esc($gt) . '" placeholder="Game title" autocomplete="off" spellcheck="true" />';
            echo '<button type="button" class="btn btn-sm btn-outline-danger cms-games-remove flex-shrink-0" title="Remove">×</button>';
            echo '</div>';
        }
        echo '</div>';
        echo '<template id="cms-games-row-template">';
        echo '<div class="col-12 col-md-6 col-lg-4 cms-games-row d-flex gap-2 align-items-center">';
        echo '<input type="text" class="form-control form-control-sm flex-grow-1" name="games_title[]" value="" placeholder="Game title" autocomplete="off" spellcheck="true" />';
        echo '<button type="button" class="btn btn-sm btn-outline-danger cms-games-remove flex-shrink-0" title="Remove">×</button>';
        echo '</div>';
        echo '</template>';
        echo '</div>';
    } elseif (preg_match('#^html_portfolio_\d+$#', $k) === 1) {
        cms_edit_portfolio_overlay_fields_inner($k, $parts, $bodyHint);
    }

    echo '</div>';
}

/**
 * @param array<string, string> $sections
 * @param array{label?: string, type?: string, target?: string} $row
 */
function cms_edit_nav_row_fields(array $sections, array $row): void
{
    $label = esc(trim((string) ($row['label'] ?? '')));
    $type = (($row['type'] ?? '') === 'url') ? 'url' : 'scroll';
    $tid = (string) ($row['target'] ?? 'intro');
    if (!in_array($tid, cms_site_nav_scroll_id_whitelist(), true)) {
        $tid = 'intro';
    }
    $urlVal = $type === 'url' ? esc((string) ($row['target'] ?? '')) : '';

    echo '<div class="cms-nav-row row g-2 align-items-end mb-2 pb-2 border-bottom border-light-subtle">';
    echo '<div class="col-md-3"><label class="form-label small d-md-none">Label</label>';
    echo '<input type="text" class="form-control form-control-sm" name="nav_label[]" value="' . $label . '" placeholder="e.g. Home" autocomplete="off" /></div>';
    echo '<div class="col-md-2"><label class="form-label small d-md-none">Link type</label>';
    echo '<select class="form-select form-select-sm cms-nav-type" name="nav_type[]">';
    echo '<option value="scroll"' . ($type === 'scroll' ? ' selected' : '') . '>Scroll to section</option>';
    echo '<option value="url"' . ($type === 'url' ? ' selected' : '') . '>Custom URL</option>';
    echo '</select></div>';
    echo '<div class="col-md-3 cms-nav-col-scroll"><label class="form-label small d-md-none">Section</label>';
    echo '<select class="form-select form-select-sm" name="nav_target_scroll[]">';
    foreach ($sections as $sid => $stitle) {
        echo '<option value="' . esc($sid) . '"' . ($tid === $sid ? ' selected' : '') . '>' . esc($stitle) . '</option>';
    }
    echo '</select></div>';
    echo '<div class="col-md-3 cms-nav-col-url"><label class="form-label small d-md-none">Custom URL</label>';
    echo '<input type="text" class="form-control form-control-sm" name="nav_target_url[]" value="' . $urlVal . '" placeholder="https://… or ./path" autocomplete="off" spellcheck="false" /></div>';
    echo '<div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-outline-danger cms-nav-remove w-100">Remove</button></div>';
    echo '</div>';
}

/** @param array<string, mixed> $current */
function cms_edit_nav_block(array $current): void
{
    $items = cms_site_nav_decode_array($current);
    $sections = cms_site_nav_scroll_sections();
    $max = cms_site_nav_max_rows();

    echo '<div class="cms-nav-editor border rounded-3 p-3 bg-body-secondary mb-0" id="cms-nav-editor" data-max-rows="' . (int) $max . '">';
    echo '<p class="form-text small text-secondary mb-2">Use <strong>Add link</strong> / <strong>Remove</strong> on each row. <strong>Scroll to section</strong> jumps to a block on this homepage. <strong>Custom URL</strong>: web address, <code>mailto:…</code>, <code>./path</code>, or <code>#anchor</code>. <strong>Save</strong> in the sidebar updates the menu on the site.</p>';
    echo '<p class="mb-3"><button type="button" class="btn btn-sm btn-outline-primary" id="cms-nav-add">Add link</button> <span class="small text-secondary ms-1" id="cms-nav-count-wrap">(<span id="cms-nav-count">0</span> / ' . (int) $max . ')</span></p>';
    echo '<div class="d-none d-md-flex row g-2 small fw-semibold text-secondary mb-1 px-1"><div class="col-md-3">Label</div><div class="col-md-2">Link type</div><div class="col-md-3">Section</div><div class="col-md-3">Custom URL</div><div class="col-md-1"></div></div>';

    echo '<div id="cms-nav-rows">';
    foreach ($items as $row) {
        cms_edit_nav_row_fields($sections, $row);
    }
    echo '</div>';

    echo '<template id="cms-nav-row-template">';
    cms_edit_nav_row_fields($sections, ['label' => '', 'type' => 'scroll', 'target' => 'intro']);
    echo '</template>';
    echo '</div>';
}

function cms_edit_field_markup(string $k, array $current, array $labels, array $fragmentLabels, array $opts = []): void
{
    if ($k === '__nav_block__') {
        cms_edit_nav_block($current);

        return;
    }

        if ($k === '__portfolio_json_block__') {
        $files = cms_portfolio_project_json_files();

        echo '<div class="cms-portfolio-json border rounded-3 p-3 bg-body-secondary">';

        if ($files === []) {
            echo '<div class="alert alert-warning mb-0">No project JSON files found in <code>projects/</code>.</div>';
            echo '</div>';
            return;
        }

        echo '<div class="row g-3">';
        foreach ($files as $idx => $path) {
            $abs = __DIR__ . '/../' . ltrim(str_replace('./', '', $path), '/');
            $title = basename($path);
            $thumb = '';
            $stack = '';
            $summary = '';
            $view = '';
            $code = '';

            if (is_readable($abs)) {
                $raw = (string) file_get_contents($abs);
                $j = json_decode($raw, true);
                if (is_array($j)) {
                    $title = trim((string) ($j['title'] ?? $title));
                    $thumb = trim((string) ($j['thumb'] ?? ''));
                    $stack = trim((string) ($j['stack'] ?? ''));
                    $summary = trim((string) ($j['summary'] ?? ''));
                    $view = trim((string) ($j['view_url'] ?? ''));
                    $code = trim((string) ($j['code_url'] ?? ''));
                }
            }

            $thumbSrc = '';
            if ($thumb !== '' && str_starts_with($thumb, './')) {
                $thumbSrc = '..' . substr($thumb, 1);
            }

            echo '<div class="col-12 col-md-6">';
            echo '<div class="border rounded p-3 h-100 bg-dark-subtle">';
            echo '<h4 class="h6 mb-2">' . esc(strtoupper('Project ' . ($idx + 1) . ' - ' . $title)) . '</h4>';
            echo '<input type="hidden" name="project_json_path[]" value="' . esc($path) . '">';
            if ($thumbSrc !== '') {
                echo '<img src="' . esc($thumbSrc) . '" alt="" class="img-fluid rounded border mb-2" style="max-height:120px;object-fit:contain">';
            }
            echo '<div class="mb-2"><label class="form-label small mb-1">Project title</label>';
            echo '<input type="text" class="form-control form-control-sm" name="project_json_title[]" value="' . esc($title) . '" /></div>';
            echo '<div class="mb-2"><label class="form-label small mb-1">Stack</label>';
            echo '<input type="text" class="form-control form-control-sm" name="project_json_stack[]" value="' . esc($stack) . '" /></div>';
            echo '<div class="mb-1"><label class="form-label small mb-1">Summary</label>';
            echo '<textarea class="form-control form-control-sm" name="project_json_summary[]" rows="3" spellcheck="true">' . esc($summary) . '</textarea></div>';
            echo '</div></div>';
        }
        echo '</div></div>';
        return;
    }

if ($k === '__portfolio_block__') {
        cms_edit_portfolio_overlays_slider($current);

        return;
    }

    if ($k === '__timeline_block__') {
        cms_edit_timeline_slider($current);

        return;
    }

    if (str_starts_with($k, 'html_') && cms_html_is_split_fragment($k)) {
        cms_edit_split_fragment_fields($k, $current[$k] ?? '', $fragmentLabels);

        return;
    }

    if (str_starts_with($k, 'img_')) {
        $imgLabels = cms_image_labels();
        $imgLabel = $labels[$k] ?? ($imgLabels[$k] ?? $k);
        cms_edit_image_field($k, $current[$k] ?? '', $imgLabel, !empty($opts['grid_cell']));

        return;
    }

    $labelText = $labels[$k] ?? $fragmentLabels[$k] ?? $k;
    $val = $current[$k] ?? '';
    $id = $k;

    if (str_starts_with($k, 'html_')) {
        $val = cms_html_fragment_uses_wysiwyg($k)
            ? cms_editor_html_for_wysiwyg($k, $current[$k] ?? '')
            : cms_editor_plain_for_fragment($k, $current[$k] ?? '');
        echo '<div class="mb-4">';
        echo '<h3 class="h6 text-uppercase text-secondary border-bottom pb-2 mb-3">' . esc($labelText) . '</h3>';
        $extras = cms_html_field_extras($k);
        if ($extras['help'] !== '') {
            echo '<p class="form-text small text-secondary mb-2 cms-field-hint">' . esc($extras['help']) . '</p>';
        }
        if (isset($extras['insert']) && is_array($extras['insert'])) {
            $insLabel = (string) ($extras['insert']['label'] ?? 'Insert template');
            $insText = (string) ($extras['insert']['text'] ?? '');
            if ($insText !== '') {
                $b64 = base64_encode($insText);
                echo '<p class="mb-2"><button type="button" class="btn btn-sm btn-outline-secondary cms-insert-snippet" data-target="' . esc($id) . '" data-snippet="' . esc($b64) . '">' . esc($insLabel) . '</button></p>';
            }
        }
        echo '<label class="form-label" for="' . esc($id) . '">Content</label>';
        $taClass = 'form-control' . (cms_html_fragment_uses_wysiwyg($k) ? ' cms-wysiwyg' : '');
        echo '<textarea class="' . esc($taClass) . '" id="' . esc($id) . '" name="' . esc($id) . '" rows="12" spellcheck="true">' . esc($val) . '</textarea>';
        echo '</div>';

        return;
    }

    echo '<div class="mb-3">';
    echo '<label class="form-label" for="' . esc($id) . '">' . esc($labelText) . '</label>';

    if ($k === 'intro_tagline' || $k === 'footer_copyright') {
        echo '<textarea class="form-control" id="' . esc($id) . '" name="' . esc($id) . '" rows="3">' . esc($val) . '</textarea>';
    } else {
        echo '<input type="text" class="form-control" id="' . esc($id) . '" name="' . esc($id) . '" value="' . esc($val) . '" />';
    }

    echo '</div>';
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>My Portfolio — Edit site content</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" />
  <link rel="stylesheet" href="cms-admin.css" />
</head>
<body class="cms-admin cms-admin-body">
  <?php cms_admin_render_nav('content', $stepCount, $wizardSteps, $openN); ?>
  <div class="cms-admin-main">
  <div class="cms-admin-editor-wrap py-4">
    <h1 class="h4 mb-4">My Portfolio</h1>
    <?php if ($message !== '') { ?>
      <div class="alert alert-success"><?= esc($message) ?></div>
    <?php } ?>
    <?php if ($error !== '') { ?>
      <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php } ?>
    <form method="post" class="card shadow-sm" id="cms-wizard-form" novalidate>
      <div class="card-body p-4">
      <p class="text-muted small mb-3">All <strong>sections</strong> are shown below. Use <strong>Sections</strong> in the sidebar to scroll to one. <strong>Save</strong> stores everything together. Rich text uses the toolbar.</p>

      <input type="hidden" name="csrf" value="<?= esc(cms_csrf_token()) ?>" />
      <input type="hidden" name="cms_open_panel_n" id="cms_open_panel_n" value="<?= (int) $openN ?>" />

      <datalist id="cms-media-datalist">
        <?php foreach (cms_list_media_image_paths() as $mediaPath) { ?>
        <option value="<?= esc($mediaPath) ?>"></option>
        <?php } ?>
      </datalist>
      <datalist id="cms-media-pdf-datalist">
        <?php foreach (cms_list_media_pdf_paths() as $pdfPath) { ?>
        <option value="<?= esc($pdfPath) ?>"></option>
        <?php } ?>
      </datalist>

      <?php foreach ($wizardSteps as $wi => $activeStep) {
          $pageNum = $wi + 1;
          $stepTitle = (string) ($activeStep['title'] ?? '');
          $stepSectionName = trim((string) ($activeStep['section_name'] ?? ''));
          $stepHint = trim((string) ($activeStep['hint'] ?? ''));
          ?>
      <section class="cms-wizard-panel mb-3" id="cms-panel-<?= (int) $pageNum ?>" data-panel-index="<?= (int) $pageNum ?>" aria-labelledby="cms-panel-heading-<?= (int) $pageNum ?>">
        <header class="cms-wizard-panel-header">
          <span class="cms-wizard-panel-num" aria-hidden="true"><?= (int) $pageNum ?></span>
          <div class="cms-wizard-panel-headlines">
            <h2 class="cms-wizard-panel-heading mb-0" id="cms-panel-heading-<?= (int) $pageNum ?>"><?= esc($stepTitle) ?></h2>
            <?php if ($stepSectionName !== '') { ?>
            <p class="cms-wizard-panel-section-name"><?= esc($stepSectionName) ?></p>
            <?php } ?>
            <?php if ($stepHint !== '') { ?>
            <p class="cms-wizard-panel-hint small text-muted mb-0"><?= esc($stepHint) ?></p>
            <?php } ?>
          </div>
        </header>
        <div class="cms-wizard-panel-body">
        <?php
          $stepGroups = $activeStep['groups'] ?? [];
          $seenNestHeadings = [];
          foreach ($stepGroups as $g) {
              $gLabel = (string) ($g['label'] ?? '');
              $gLabelTrim = trim($gLabel);
              $gKeys = $g['keys'] ?? [];
              if (!is_array($gKeys) || $gKeys === []) {
                  continue;
              }
              $effectiveNestHeading = $gLabelTrim !== ''
                  ? $gLabelTrim
                  : ($stepTitle !== '' ? $stepTitle : 'Content');
              $headingKey = strtolower($effectiveNestHeading);
              $showNestH3 = false;
              if (!isset($seenNestHeadings[$headingKey])) {
                  $seenNestHeadings[$headingKey] = true;
                  $redundantWithPanel = $gLabelTrim === ''
                      && $stepTitle !== ''
                      && strtolower($stepTitle) === $headingKey;
                  if (!$redundantWithPanel) {
                      $showNestH3 = true;
                  }
              }
              $useGrid = (($g['layout'] ?? '') === 'grid') && count($gKeys) >= 1;
              $gridPreset = strtolower(preg_replace('/[^a-z0-9_-]/', '', (string) ($g['grid_preset'] ?? 'default')));
              if (!in_array($gridPreset, ['default', 'gallery', 'portfolio'], true)) {
                  $gridPreset = 'default';
              }
              if ($useGrid && count($gKeys) === 1 && $gridPreset === 'default') {
                  $gridPreset = 'single';
              }
              ?>
        <div class="cms-area-nest border rounded-3 p-3 mb-4 bg-body-secondary">
          <?php if ($showNestH3) { ?>
          <h3 class="h6 text-body-secondary mb-3 pb-2 border-bottom border-light-subtle"><?= esc($effectiveNestHeading) ?></h3>
          <?php } ?>
          <?php if ($useGrid) { ?>
          <div class="cms-img-grid cms-img-grid--<?= esc($gridPreset) ?>">
            <?php foreach ($gKeys as $k) { ?>
            <div class="cms-img-grid__cell">
              <?php cms_edit_field_markup($k, $current, $labels, $fragmentLabels, ['grid_cell' => true]); ?>
            </div>
            <?php } ?>
          </div>
          <?php } else { ?>
          <?php foreach ($gKeys as $k) {
              cms_edit_field_markup($k, $current, $labels, $fragmentLabels);
          } ?>
          <?php } ?>
        </div>
        <?php } ?>
        </div>
      </section>
      <?php } ?>
      </div>
    </form>
    <?php
    $cmsMediaImagesJson = json_encode(cms_list_media_image_paths(), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    $cmsMediaPdfsJson = json_encode(cms_list_media_pdf_paths(), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    ?>
    <script type="application/json" id="cms-media-data-images"><?= $cmsMediaImagesJson !== false ? $cmsMediaImagesJson : '[]' ?></script>
    <script type="application/json" id="cms-media-data-pdfs"><?= $cmsMediaPdfsJson !== false ? $cmsMediaPdfsJson : '[]' ?></script>
    <dialog id="cms-media-picker-dialog" class="cms-media-picker-dialog rounded-3 shadow-lg border-0 p-0" aria-labelledby="cms-media-picker-title">
      <div class="cms-media-picker-header p-3 border-bottom">
        <h2 class="h6 mb-2" id="cms-media-picker-title">Choose from media</h2>
        <div class="cms-media-picker-toolbar d-flex flex-wrap gap-2 align-items-center mb-2">
          <button type="button" class="btn btn-sm btn-primary" id="cms-media-upload-btn">Upload…</button>
          <input type="file" id="cms-media-upload-input" class="d-none" />
          <span class="text-muted small">Files live in <code>media/</code> on the server (same as Hostinger File Manager).</span>
        </div>
        <p class="text-danger small mb-2 d-none" id="cms-media-picker-error" role="alert"></p>
        <label class="visually-hidden" for="cms-media-picker-filter">Filter files</label>
        <input type="search" class="form-control form-control-sm" id="cms-media-picker-filter" placeholder="Filter by path or filename…" autocomplete="off" />
      </div>
      <div class="cms-media-picker-grid-wrap p-3">
        <div class="cms-media-picker-grid" id="cms-media-picker-grid"></div>
      </div>
      <div class="cms-media-picker-footer p-2 border-top text-end">
        <button type="button" class="btn btn-sm btn-outline-secondary" id="cms-media-picker-cancel">Close</button>
      </div>
    </dialog>
  </div>
  </div>
  <script src="media-picker.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
  <script>
(function () {
  var cmsForm = document.getElementById('cms-wizard-form');
  var wizardStepCount = <?= (int) $stepCount ?>;
  var lastSectionIndex = <?= (int) $openN ?>;

  function cmsGetOpenPanelIndex() {
    return (lastSectionIndex >= 1 && lastSectionIndex <= wizardStepCount) ? lastSectionIndex : 1;
  }

  function cmsSyncOpenPanelHidden() {
    var h = document.getElementById('cms_open_panel_n');
    if (h) h.value = String(cmsGetOpenPanelIndex());
  }

  function cmsSidebarSetCurrent(panelIndex) {
    var cur = null;
    document.querySelectorAll('.js-cms-section-jump').forEach(function (a) {
      var n = parseInt(a.getAttribute('data-panel'), 10);
      var isC = n === panelIndex;
      a.classList.toggle('is-current', isC);
      if (isC) cur = a;
    });
    if (cur && cur.scrollIntoView) {
      try {
        cur.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
      } catch (err1) {
        try {
          cur.scrollIntoView(false);
        } catch (err2) {}
      }
    }
  }

  document.querySelectorAll('.js-cms-section-jump').forEach(function (a) {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      var n = parseInt(a.getAttribute('data-panel'), 10);
      if (n < 1 || n > wizardStepCount) return;
      lastSectionIndex = n;
      cmsSidebarSetCurrent(n);
      cmsSyncOpenPanelHidden();
      var el = document.getElementById('cms-panel-' + n);
      if (el && el.scrollIntoView) {
        try {
          el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } catch (err) {
          el.scrollIntoView(true);
        }
      }
    });
  });

  if (cmsForm) {
    cmsForm.addEventListener('submit', function () {
      if (typeof tinymce !== 'undefined') tinymce.triggerSave();
      cmsSyncOpenPanelHidden();
    });
  }

  window.addEventListener('load', function () {
    cmsSidebarSetCurrent(cmsGetOpenPanelIndex());
  });

  function cmsUpdateImgPreview(input) {
    if (typeof window.cmsMediaUpdatePreview === 'function') {
      window.cmsMediaUpdatePreview(input);
    }
  }
  document.querySelectorAll('.cms-img-path-input').forEach(function (inp) {
    inp.addEventListener('input', function () { cmsUpdateImgPreview(inp); });
    inp.addEventListener('change', function () { cmsUpdateImgPreview(inp); });
    cmsUpdateImgPreview(inp);
  });
  if (typeof window.cmsMediaPickerSyncPreviews === 'function') {
    window.cmsMediaPickerSyncPreviews();
  }

  (function cmsTimelineSliderUi() {
    var root = document.getElementById('cms-timeline-editor');
    if (!root) return;
    var track = document.getElementById('cms-timeline-slides');
    var tpl = document.getElementById('cms-timeline-slide-template');
    var counter = document.getElementById('cms-timeline-counter');
    var btnPrev = document.getElementById('cms-tl-prev');
    var btnNext = document.getElementById('cms-tl-next');
    var btnAdd = document.getElementById('cms-tl-add');
    var btnRemove = document.getElementById('cms-tl-remove');
    var maxSlides = parseInt(root.getAttribute('data-max-slides') || '20', 10);
    if (!track) return;

    function slideEls() {
      return Array.prototype.slice.call(track.querySelectorAll('.cms-timeline-slide'));
    }

    function activeIndex() {
      var list = slideEls();
      for (var i = 0; i < list.length; i++) {
        if (list[i].classList.contains('is-active')) return i;
      }
      return 0;
    }

    function setActive(idx) {
      var list = slideEls();
      if (!list.length) return;
      if (idx < 0) idx = 0;
      if (idx >= list.length) idx = list.length - 1;
      list.forEach(function (el, i) {
        el.classList.toggle('is-active', i === idx);
      });
      if (counter) counter.textContent = 'Slide ' + (idx + 1) + ' of ' + list.length;
      if (btnRemove) btnRemove.disabled = list.length <= 1;
      if (btnAdd) btnAdd.disabled = list.length >= maxSlides;
    }

    if (btnPrev) btnPrev.addEventListener('click', function () { setActive(activeIndex() - 1); });
    if (btnNext) btnNext.addEventListener('click', function () { setActive(activeIndex() + 1); });

    if (btnAdd) btnAdd.addEventListener('click', function () {
      if (slideEls().length >= maxSlides) return;
      if (!tpl || !tpl.content) return;
      var first = tpl.content.firstElementChild;
      if (!first) return;
      var node = first.cloneNode(true);
      node.classList.remove('d-none');
      node.removeAttribute('data-cms-timeline-template');
      track.appendChild(node);
      var tw = node.querySelector('textarea.cms-wysiwyg');
      var ti = node.querySelector('.cms-timeline-img-input');
      if (ti) {
        ti.addEventListener('input', function () { cmsUpdateImgPreview(ti); });
        ti.addEventListener('change', function () { cmsUpdateImgPreview(ti); });
        cmsUpdateImgPreview(ti);
      }
      setActive(slideEls().length - 1);
    });

    if (btnRemove) btnRemove.addEventListener('click', function () {
      var list = slideEls();
      if (list.length <= 1) return;
      var idx = activeIndex();
      list[idx].parentNode.removeChild(list[idx]);
      setActive(Math.min(idx, slideEls().length - 1));
    });

    setActive(activeIndex());
  })();

  (function cmsPortfolioSliderUi() {
    var root = document.getElementById('cms-portfolio-editor');
    if (!root) return;
    var track = document.getElementById('cms-portfolio-items');
    var counter = document.getElementById('cms-portfolio-counter');
    var btnPrev = document.getElementById('cms-pf-prev');
    var btnNext = document.getElementById('cms-pf-next');
    if (!track) return;

    function slideEls() {
      return Array.prototype.slice.call(track.querySelectorAll('.cms-portfolio-slide'));
    }

    function activeIndex() {
      var list = slideEls();
      for (var i = 0; i < list.length; i++) {
        if (list[i].classList.contains('is-active')) return i;
      }
      return 0;
    }

    function setActive(idx) {
      var list = slideEls();
      if (!list.length) return;
      if (idx < 0) idx = 0;
      if (idx >= list.length) idx = list.length - 1;
      list.forEach(function (el, i) {
        el.classList.toggle('is-active', i === idx);
      });
      if (counter) counter.textContent = 'Tile ' + (idx + 1) + ' of ' + list.length;
      if (btnPrev) btnPrev.disabled = list.length <= 1 || idx <= 0;
      if (btnNext) btnNext.disabled = list.length <= 1 || idx >= list.length - 1;
    }

    if (btnPrev) btnPrev.addEventListener('click', function () { setActive(activeIndex() - 1); });
    if (btnNext) btnNext.addEventListener('click', function () { setActive(activeIndex() + 1); });

    setActive(activeIndex());
  })();

  function cmsRepeaterSyncNavRow(row) {
    var type = row.querySelector('.cms-nav-type');
    if (!type) return;
    var isUrl = type.value === 'url';
    var cs = row.querySelector('.cms-nav-col-scroll');
    var cu = row.querySelector('.cms-nav-col-url');
    if (cs) cs.classList.toggle('opacity-50', isUrl);
    if (cu) cu.classList.toggle('opacity-50', !isUrl);
  }
  function cmsRepeaterUpdateNavCount(root, track) {
    var el = document.getElementById('cms-nav-count');
    if (!el || !track) return;
    var max = parseInt(root.getAttribute('data-max-rows') || '15', 10);
    el.textContent = String(track.children.length);
    var addBtn = document.getElementById('cms-nav-add');
    if (addBtn) addBtn.disabled = track.children.length >= max;
  }
  (function cmsNavRepeater() {
    var root = document.getElementById('cms-nav-editor');
    if (!root) return;
    var track = document.getElementById('cms-nav-rows');
    var tpl = document.getElementById('cms-nav-row-template');
    var max = parseInt(root.getAttribute('data-max-rows') || '15', 10);
    function bindRow(row) {
      var typeSel = row.querySelector('.cms-nav-type');
      if (typeSel) typeSel.addEventListener('change', function () { cmsRepeaterSyncNavRow(row); });
      cmsRepeaterSyncNavRow(row);
      cmsBindAutoUrlNormalization(row);
      var rm = row.querySelector('.cms-nav-remove');
      if (rm) rm.addEventListener('click', function () {
        row.remove();
        cmsRepeaterUpdateNavCount(root, track);
      });
    }
    function addRow() {
      if (!track || !tpl || !tpl.content || !tpl.content.firstElementChild) return;
      if (track.children.length >= max) return;
      var node = tpl.content.firstElementChild.cloneNode(true);
      track.appendChild(node);
      bindRow(node);
      cmsRepeaterUpdateNavCount(root, track);
    }
    var addBtn = document.getElementById('cms-nav-add');
    if (addBtn) addBtn.addEventListener('click', addRow);
    if (track) track.querySelectorAll('.cms-nav-row').forEach(bindRow);
    cmsRepeaterUpdateNavCount(root, track);
  })();

  function cmsNormalizeUrlInputValue(raw) {
    var v = (raw || '').trim();
    if (!v) return v;
    var lower = v.toLowerCase();
    if (
      lower.indexOf('mailto:') === 0 ||
      lower.indexOf('tel:') === 0 ||
      v.indexOf('./') === 0 ||
      v.indexOf('/') === 0 ||
      v.indexOf('#') === 0
    ) {
      return v;
    }
    if (lower.indexOf('javascript:') === 0) {
      return '';
    }

    var domainLike = /^(?:www\.)?[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?(?:\.[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?)+(?:[/?#].*)?$/i.test(v);
    if (!/^[a-z][a-z0-9+\-.]*:\/\//i.test(v) && domainLike) {
      v = 'https://' + v;
    }
    if (/^https?:\/\//i.test(v)) {
      try {
        var u = new URL(v);
        var host = (u.hostname || '').toLowerCase();
        var isIp = /^(\d{1,3}\.){3}\d{1,3}$/.test(host) || host.indexOf(':') !== -1;
        if (host && host !== 'localhost' && !isIp && host.indexOf('www.') !== 0) {
          u.hostname = 'www.' + host;
          v = u.toString();
        } else {
          v = u.toString();
        }
      } catch (e) {}
    }

    return v;
  }

  function cmsBindAutoUrlNormalization(root) {
    var selectors = [
      'input[name="nav_target_url[]"]',
      'input[id$="__btn1_url"]',
      'input[id$="__btn2_url"]'
    ];
    (root || document).querySelectorAll(selectors.join(',')).forEach(function (inp) {
      if (inp.dataset.urlNormalizedBound === '1') return;
      inp.dataset.urlNormalizedBound = '1';
      inp.addEventListener('blur', function () {
        var next = cmsNormalizeUrlInputValue(inp.value);
        if (next !== inp.value) inp.value = next;
      });
    });
  }

  cmsBindAutoUrlNormalization(document);

  function cmsUrlLockNormalizeSuffix(raw) {
    var v = (raw || '').trim();
    if (!v) return '';
    v = v.replace(/^https?:\/\//i, '');
    v = v.replace(/^www\./i, '');
    v = v.replace(/^\/+/, '');
    return v;
  }

  function cmsUrlLockSyncOne(suffixInput) {
    if (!suffixInput) return;
    var targetId = suffixInput.getAttribute('data-url-target');
    if (!targetId) return;
    var hidden = document.getElementById(targetId);
    if (!hidden) return;
    var suffix = cmsUrlLockNormalizeSuffix(suffixInput.value);
    if (suffix !== suffixInput.value) {
      suffixInput.value = suffix;
    }
    hidden.value = suffix ? ('https://www.' + suffix) : '';
  }

  function cmsBindUrlLockInputs(root) {
    (root || document).querySelectorAll('.cms-url-lock-suffix').forEach(function (inp) {
      if (inp.dataset.urlLockBound === '1') return;
      inp.dataset.urlLockBound = '1';
      inp.addEventListener('input', function () { cmsUrlLockSyncOne(inp); });
      inp.addEventListener('blur', function () { cmsUrlLockSyncOne(inp); });
      cmsUrlLockSyncOne(inp);
    });
  }

  cmsBindUrlLockInputs(document);
  if (cmsForm) {
    cmsForm.addEventListener('submit', function () {
      document.querySelectorAll('.cms-url-lock-suffix').forEach(cmsUrlLockSyncOne);
    });
  }

  (function cmsSkillsRepeater() {
    var root = document.getElementById('cms-skills-editor');
    if (!root) return;
    var track = document.getElementById('cms-skills-rows');
    var tpl = document.getElementById('cms-skills-row-template');
    var addBtn = document.getElementById('cms-skills-add');
    var max = parseInt(root.getAttribute('data-max-rows') || '15', 10);
    function bindRow(row) {
      var rm = row.querySelector('.cms-skills-remove');
      if (rm) rm.addEventListener('click', function () {
        row.remove();
        if (addBtn && track) addBtn.disabled = track.children.length >= max;
      });
    }
    function addRow() {
      if (!track || !tpl || !tpl.content || !tpl.content.firstElementChild) return;
      if (track.children.length >= max) return;
      var node = tpl.content.firstElementChild.cloneNode(true);
      track.appendChild(node);
      bindRow(node);
      if (typeof window.cmsMediaPickerSyncPreviews === 'function') {
        window.cmsMediaPickerSyncPreviews(node);
      }
      if (addBtn) addBtn.disabled = track.children.length >= max;
    }
    if (addBtn) {
      addBtn.addEventListener('click', addRow);
      if (track) addBtn.disabled = track.children.length >= max;
    }
    if (track) {
      track.querySelectorAll('.cms-skills-row').forEach(bindRow);
    }
  })();

  (function cmsGamesRepeater() {
    var root = document.getElementById('cms-games-editor');
    if (!root) return;
    var track = document.getElementById('cms-games-rows');
    var tpl = document.getElementById('cms-games-row-template');
    var addBtn = document.getElementById('cms-games-add');
    var max = parseInt(root.getAttribute('data-max-rows') || '64', 10);
    function bindRow(row) {
      var rm = row.querySelector('.cms-games-remove');
      if (rm) rm.addEventListener('click', function () {
        row.remove();
        if (addBtn && track) addBtn.disabled = track.children.length >= max;
      });
    }
    function addRow() {
      if (!track || !tpl || !tpl.content || !tpl.content.firstElementChild) return;
      if (track.children.length >= max) return;
      var node = tpl.content.firstElementChild.cloneNode(true);
      track.appendChild(node);
      bindRow(node);
      if (addBtn) addBtn.disabled = track.children.length >= max;
    }
    if (addBtn) {
      addBtn.addEventListener('click', addRow);
      if (track) addBtn.disabled = track.children.length >= max;
    }
    if (track) track.querySelectorAll('.cms-games-row').forEach(bindRow);
  })();

  document.querySelectorAll('.cms-insert-snippet').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var tid = btn.getAttribute('data-target');
      var b64 = btn.getAttribute('data-snippet');
      if (!tid || !b64) return;
      var text;
      try {
        text = atob(b64);
      } catch (err) {
        return;
      }
      var ta = document.getElementById(tid);
      if (!ta || ta.tagName !== 'TEXTAREA') return;
      var ed = ta.id && typeof tinymce !== 'undefined' ? tinymce.get(ta.id) : null;
      if (ed) {
        ed.insertContent(text);
        ed.focus();
        return;
      }
      var start = typeof ta.selectionStart === 'number' ? ta.selectionStart : 0;
      var end = typeof ta.selectionEnd === 'number' ? ta.selectionEnd : start;
      ta.value = ta.value.slice(0, start) + text + ta.value.slice(end);
      ta.focus();
      var caret = start + text.length;
      ta.setSelectionRange(caret, caret);
    });
  });
})();
  </script>
  <script>
(function () {
  function cmsTinyStart() {
    if (typeof tinymce === 'undefined') return;
    tinymce.init({
      selector: 'textarea.cms-wysiwyg',
      menubar: false,
      statusbar: false,
      plugins: 'link lists autolink charmap code fullscreen searchreplace table visualblocks',
      toolbar: 'undo redo | blocks | styles | bold italic underline | bullist numlist | link unlink | charmap | table | searchreplace | code | fullscreen | removeformat',
      link_default_protocol: 'https',
      link_assume_external_targets: 'https',
      style_formats: [
        { title: 'Highlight', inline: 'strong', classes: 'portfolio-highlight' }
      ],
      branding: false,
      block_formats: 'Paragraph=p',
      formats: {
        portfoliohighlight: { inline: 'strong', classes: 'portfolio-highlight', exact: true }
      },
      content_style:
        'body{font-family:Kodchasan,system-ui,sans-serif;font-size:16px;color:#000;}' +
        '.portfolio-highlight{font-size:24px;font-weight:800;margin:0 0.25em;padding:0 0.05em;vertical-align:baseline;}' +
        'button{border:none;background:none;padding:0;margin:0;}' +
        'button a{background-color:#b22222;color:#fff;padding:10px 5px;font-size:24px;font-weight:800;text-decoration:none;display:inline-block;}',
        plugins: 'link lists autolink charmap code fullscreen searchreplace table visualblocks autoresize',
        min_height: 320,
        max_height: 700,
        autoresize_bottom_margin: 24,
      valid_children: '+p[a|strong|b|em|i|u|sub|sup|br|span|#text],+li[a|strong|b|em|i|u|sub|sup|br|span|ul|ol|p|#text],+button[a|strong|b|em|i|u|sub|sup|br|span|#text]',
      valid_elements: 'p,br,strong/b[class],em/i,u,sub,sup,a[href|target|rel],h2,h3,h4,h5,h6,ul,ol,li,button,blockquote,code,pre,hr,table,thead,tbody,tfoot,tr,th[colspan|rowspan],td[colspan|rowspan],caption,img[src|alt|width|height|loading|decoding],span[class]',
      extended_valid_elements: 'strong[class|style],span[class|style],img[src|alt|width|height|loading|decoding]',
    });
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', cmsTinyStart);
  } else {
    cmsTinyStart();
  }
})();
</script>
</body>
</html>

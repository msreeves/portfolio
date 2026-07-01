<?php
declare(strict_types=1);

/**
 * Portfolio CMS wizard helpers.
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


function cms_plain_format_help_short(): string
{
    return 'Skills: add/remove course name + PDF path from ./media. Archive projects: edit title, stack, and summary in the Archive projects step.';
}

/** Short hint shown under WYSIWYG rich text fields in admin. */


function cms_wysiwyg_format_help_short(): string
{
    return 'Use the toolbar for bold, italic, lists, and links. Use “Insert/edit link” for URLs (including View site links). Highlight text with the custom “Highlight” style where available.';
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
        if (in_array($key, cms_cv_pdf_field_keys(), true)) {
            $clean = cms_sanitize_pdf_path(trim($raw));
            $defs = cms_heading_defaults();
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


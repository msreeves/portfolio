<?php
declare(strict_types=1);

/**
 * Portfolio CMS sanitize helpers.
 */

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


function cms_sanitize_html(string $html): string
{
    $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html);
    $html = preg_replace('#<iframe\b[^>]*>.*?</iframe>#is', '', $html);

    return trim($html);
}

/** Full HTML fragments edited with one rich-text area (not split-field or timeline slides). */


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
            'intro' => ($idx++ === 0) ? 'msr-fade-in' : 'msr-fade-in m-b-2',
            'work', 'recent' => 'msr-fade-in m-b-2',
            'testimonial', 'timeline' => 'description',
            'portfolio_tagline', 'portfolio_body' => '',
            default => 'msr-fade-in m-b-2',
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


<?php
declare(strict_types=1);
/**
 * Hairdressing CMS — full rebuild.
 * Login: hayleykharsa86 / changeme
 * Change hash: php -r "echo password_hash('newpass', PASSWORD_DEFAULT);"
 */

const CMS_USERNAME      = 'hayleykharsa86';
const CMS_PASSWORD_HASH = '$2y$12$ZpZK4WU0bfohmKGqNIS92OyEfNh02Oa2Hj./9CdZxOhW.JNKBgTaa';
const CMS_SESSION_KEY   = 'hk_cms_authed';
const CONTENT_FILE      = __DIR__ . '/../content/site-content.json';

session_start();

// ─── CSRF ─────────────────────────────────────────────────────────────────────
if (!isset($_SESSION['hk_csrf'])) {
    $_SESSION['hk_csrf'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['hk_csrf'];

$authed  = !empty($_SESSION[CMS_SESSION_KEY]);
$message = '';
$error   = '';

// ─── Logout ───────────────────────────────────────────────────────────────────
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: index.php', true, 303);
    exit;
}

// ─── Login POST ───────────────────────────────────────────────────────────────
if (!$authed && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cms_login'])) {
    $user = trim((string) ($_POST['username'] ?? ''));
    $pass = (string) ($_POST['password'] ?? '');
    if ($user === CMS_USERNAME && password_verify($pass, CMS_PASSWORD_HASH)) {
        $_SESSION[CMS_SESSION_KEY] = true;
        header('Location: index.php', true, 303);
        exit;
    }
    $error = 'Invalid username or password.';
}

// ─── Helpers ──────────────────────────────────────────────────────────────────
function hk_v(array $data, string ...$keys): string
{
    $cur = $data;
    foreach ($keys as $k) {
        if (!is_array($cur) || !array_key_exists($k, $cur)) return '';
        $cur = $cur[$k];
    }
    return htmlspecialchars((string) $cur, ENT_QUOTES, 'UTF-8');
}

function hk_field(string $name, string $label, string $value, string $type = 'text', int $rows = 3, string $hint = ''): void
{
    $id  = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $lbl = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    echo '<div class="field">';
    echo '<label for="' . $id . '">' . $lbl . '</label>';
    if ($hint !== '') echo '<p class="field-hint">' . htmlspecialchars($hint) . '</p>';
    $isUrlField = (bool) preg_match('#(?:_url$|^nav_url\[\]$|^booking_url$|^contact_map$|^social_)#', $name);
    $extraClass = $isUrlField ? ' js-url-field' : '';
    if ($type === 'textarea') {
        echo '<textarea id="' . $id . '" name="' . $id . '" rows="' . $rows . '" class="cms-wysiwyg">' . $value . '</textarea>';
    } elseif ($type === 'textarea-plain') {
        echo '<textarea id="' . $id . '" name="' . $id . '" rows="' . $rows . '">' . $value . '</textarea>';
    } else {
        echo '<input type="text" id="' . $id . '" name="' . $id . '" value="' . $value . '" class="' . trim($extraClass) . '" />';
    }
    echo '</div>';
}

function hk_normalize_url(string $raw): string
{
    $u = trim($raw);
    $u = rtrim($u, " \t\n\r\0\x0B›»");
    if ($u === '') return '';

    $lower = strtolower($u);
    $normalizedInternal = strtolower(trim((string)preg_replace('#^https?://[^/]+#i', '', $u)));
    $normalizedInternal = preg_replace('#^\.?/+#', '', $normalizedInternal ?? '') ?? '';
    $normalizedInternal = trim($normalizedInternal, '/');
    $internalRoutes = ['about','services','gallery','testimonials','experience','contact','privacy'];
    if ($normalizedInternal === '' || $normalizedInternal === 'home' || $normalizedInternal === 'index' || $normalizedInternal === 'index.php') {
        return './';
    }
    if (in_array($normalizedInternal, $internalRoutes, true)) {
        return './' . $normalizedInternal;
    }

    if (
        str_starts_with($lower, 'mailto:') ||
        str_starts_with($lower, 'tel:') ||
        str_starts_with($u, './') ||
        str_starts_with($u, '../') ||
        str_starts_with($u, '/') ||
        str_starts_with($u, '#')
    ) {
        return $u;
    }
    if (str_starts_with($lower, 'javascript:')) return '';

    $looksDomain = preg_match('#^(?:www\.)?[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?(?:\.[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?)+(?:[/?\#].*)?$#i', $u) === 1;
    if (preg_match('#^[a-z][a-z0-9+\-.]*://#i', $u) !== 1 && $looksDomain) {
        $u = 'https://' . $u;
    }

    if (preg_match('#^https?://#i', $u) === 1) {
        $parts = parse_url($u);
        if (is_array($parts) && isset($parts['host'])) {
            $host = strtolower((string) $parts['host']);
            $isIp = filter_var($host, FILTER_VALIDATE_IP) !== false;
            if ($host !== '' && $host !== 'localhost' && !$isIp && !str_starts_with($host, 'www.')) {
                $parts['host'] = 'www.' . $host;
                $rebuilt = strtolower((string) ($parts['scheme'] ?? 'https')) . '://';
                if (isset($parts['user']) && $parts['user'] !== '') {
                    $rebuilt .= $parts['user'];
                    if (isset($parts['pass']) && $parts['pass'] !== '') $rebuilt .= ':' . $parts['pass'];
                    $rebuilt .= '@';
                }
                $rebuilt .= (string) $parts['host'];
                if (isset($parts['port'])) $rebuilt .= ':' . (int) $parts['port'];
                $rebuilt .= $parts['path'] ?? '/';
                if (isset($parts['query']) && $parts['query'] !== '') $rebuilt .= '?' . $parts['query'];
                if (isset($parts['fragment']) && $parts['fragment'] !== '') $rebuilt .= '#' . $parts['fragment'];
                $u = $rebuilt;
            }
        }
    }

    return $u;
}

function hk_media_field(string $name, string $label, string $value, string $formName = ''): void
{
    // $formName allows using name="service_image[]" while id="service_image_N"
    $id       = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $fname    = htmlspecialchars($formName !== '' ? $formName : $name, ENT_QUOTES, 'UTF-8');
    $lbl      = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $prevUrl = '';
    if ($value !== '') {
        if (preg_match('#^https?://#i', $value) === 1) $prevUrl = $value;
        else $prevUrl = '../' . ltrim(str_replace('./', '', $value), '/');
    }
    echo '<div class="field">';
    echo '<label>' . $lbl . '</label>';
    echo '<div class="media-picker" data-mode="single">';
    echo '<div class="media-picker-preview">';
    if ($prevUrl !== '') {
        echo '<img src="' . htmlspecialchars($prevUrl, ENT_QUOTES, 'UTF-8') . '" alt="" style="max-height:100px;max-width:100%;border-radius:6px;object-fit:contain" loading="lazy" />';
    } else {
        echo '<span class="picker-no-preview">No image selected</span>';
    }
    echo '</div>';
    echo '<div class="media-picker-controls">';
    echo '<input type="hidden" name="' . $fname . '" class="media-picker-input" data-picker-context="' . $lbl . '" value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '" />';
    echo '<button type="button" class="btn-picker media-picker-open">Choose image</button>';
    echo '<button type="button" class="btn-picker-clear" onclick="this.closest(\'.media-picker\').querySelector(\'.media-picker-input\').value=\'\';this.closest(\'.media-picker\').querySelector(\'.media-picker-preview\').innerHTML=\'<span class=\\\'picker-no-preview\\\'>No image selected</span>\'">Clear</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function hk_list_images(): array
{
    $base = realpath(__DIR__ . '/../assets/images');
    if (!$base || !is_dir($base)) return [];
    $result = [];
    try {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        foreach ($it as $file) {
            if (!$file->isFile()) continue;
            $ext = strtolower($file->getExtension());
            if (!in_array($ext, $allowed, true)) continue;
            $real = realpath($file->getPathname());
            if (!$real || !str_starts_with($real, $base)) continue;
            $rel = str_replace('\\', '/', substr($real, strlen($base)));
            $result[] = './assets/images' . $rel;
        }
    } catch (Throwable) {}
    sort($result);
    return $result;
}

// ─── Save POST ────────────────────────────────────────────────────────────────
if ($authed && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cms_save'])) {
    $raw  = is_readable(CONTENT_FILE) ? (string) file_get_contents(CONTENT_FILE) : '{}';
    $data = json_decode($raw, true);
    if (!is_array($data)) $data = [];

    // site
    $data['site']['brandName']       = trim((string) ($_POST['brand_name'] ?? ''));
    $data['site']['tagline']         = trim((string) ($_POST['tagline'] ?? ''));
    $data['site']['metaDescription'] = trim((string) ($_POST['meta_description'] ?? ''));
    $data['site']['openingHours']    = trim((string) ($_POST['opening_hours'] ?? ''));
    $data['site']['bookingUrl']      = hk_normalize_url((string) ($_POST['booking_url'] ?? ''));
    $data['site']['showBookingForm'] = !empty($_POST['show_booking_form']);

    // social links (fixed platforms)
    $platforms = ['linkedin','instagram','facebook','tiktok','youtube','pinterest','twitter'];
    $labels    = ['LinkedIn','Instagram','Facebook','TikTok','YouTube','Pinterest','Twitter / X'];
    $data['site']['socialLinks'] = [];
    foreach ($platforms as $i => $p) {
        $data['site']['socialLinks'][] = [
            'platform' => $p,
            'url'      => hk_normalize_url((string) ($_POST['social_' . $p] ?? '')),
            'label'    => $labels[$i],
        ];
    }

    // pages SEO
    $pageKeys = ['home','about','services','gallery','testimonials','contact','experience'];
    foreach ($pageKeys as $pk) {
        $data['pages'][$pk]['metaTitle']       = trim((string) ($_POST["page_{$pk}_title"] ?? ''));
        $data['pages'][$pk]['metaDescription'] = trim((string) ($_POST["page_{$pk}_desc"] ?? ''));
    }

    // navigation (dynamic)
    $navLabels = (array) ($_POST['nav_label'] ?? []);
    $navUrls   = (array) ($_POST['nav_url']   ?? []);
    $data['navigation'] = [];
    foreach ($navLabels as $i => $lbl) {
        if (trim($lbl) !== '') {
            $data['navigation'][] = ['label' => trim($lbl), 'url' => hk_normalize_url((string)($navUrls[$i] ?? ''))];
        }
    }

    // hero
    $data['hero']['eyebrow']           = trim((string) ($_POST['hero_eyebrow'] ?? ''));
    $data['hero']['heading']           = trim((string) ($_POST['hero_heading'] ?? ''));
    $data['hero']['text']              = trim((string) ($_POST['hero_text'] ?? ''));
    $data['hero']['primaryCtaLabel']   = trim((string) ($_POST['hero_cta_label'] ?? ''));
    $data['hero']['primaryCtaUrl']     = hk_normalize_url((string) ($_POST['hero_cta_url'] ?? ''));
    $data['hero']['secondaryCtaLabel'] = trim((string) ($_POST['hero_cta2_label'] ?? ''));
    $data['hero']['secondaryCtaUrl']   = hk_normalize_url((string) ($_POST['hero_cta2_url'] ?? ''));
    $data['hero']['image']['url']      = trim((string) ($_POST['hero_image'] ?? ''));
    $data['hero']['image']['alt']      = trim((string) ($_POST['hero_image_alt'] ?? ''));

    // about
    $data['about']['heading']     = trim((string) ($_POST['about_heading'] ?? ''));
    $data['about']['homeSummary'] = trim((string) ($_POST['about_home_summary'] ?? ''));
    $data['about']['body']        = trim((string) ($_POST['about_body'] ?? ''));
    // metrics
    $mLabels = (array) ($_POST['metric_label'] ?? []);
    $mValues = (array) ($_POST['metric_value'] ?? []);
    $data['about']['metrics'] = [];
    foreach ($mLabels as $i => $lbl) {
        if (trim($lbl) !== '' || trim($mValues[$i] ?? '') !== '') {
            $data['about']['metrics'][] = ['label' => trim($lbl), 'value' => trim($mValues[$i] ?? '')];
        }
    }

    // services (dynamic)
    $sTitles   = (array) ($_POST['service_title']      ?? []);
    $sSummary  = (array) ($_POST['service_summary']    ?? []);
    $sImages   = (array) ($_POST['service_image']      ?? []);
    $sAlts     = (array) ($_POST['service_alt']        ?? []);
    $sBookLbl  = (array) ($_POST['service_book_label'] ?? []);
    $sBookUrl  = (array) ($_POST['service_book_url']   ?? []);
    $data['services'] = [];
    foreach ($sTitles as $i => $title) {
        $data['services'][] = [
            'title'        => trim($title),
            'summary'      => trim($sSummary[$i] ?? ''),
            'image'        => trim($sImages[$i]  ?? ''),
            'alt'          => trim($sAlts[$i]    ?? ''),
            'bookCtaLabel' => trim($sBookLbl[$i] ?? 'Book'),
            'bookCtaUrl'   => hk_normalize_url((string)($sBookUrl[$i] ?? '')),
        ];
    }

    // gallery (dynamic)
    $gImages = (array) ($_POST['gallery_image'] ?? []);
    $gTitles = (array) ($_POST['gallery_title'] ?? []);
    $gAlts   = (array) ($_POST['gallery_alt']   ?? []);
    $data['gallery'] = [];
    foreach ($gImages as $i => $img) {
        if (trim($img) !== '') {
            $data['gallery'][] = [
                'image' => trim($img),
                'title' => trim($gTitles[$i] ?? ''),
                'alt'   => trim($gAlts[$i]   ?? ''),
            ];
        }
    }

    // testimonials (dynamic)
    $tQuotes = (array) ($_POST['testimonial_quote'] ?? []);
    $tNames  = (array) ($_POST['testimonial_name']  ?? []);
    $tRoles  = (array) ($_POST['testimonial_role']  ?? []);
    $data['testimonials'] = [];
    foreach ($tQuotes as $i => $q) {
        $n = trim($tNames[$i] ?? '');
        if (trim($q) !== '' || $n !== '') {
            $data['testimonials'][] = [
                'quote' => trim($q),
                'name'  => $n,
                'role'  => trim($tRoles[$i] ?? ''),
            ];
        }
    }

    // experience hero
    $data['experiencePage']['heroHeading'] = trim((string) ($_POST['exp_heading'] ?? ''));
    $data['experiencePage']['heroText']    = trim((string) ($_POST['exp_text'] ?? ''));
    // jobs
    $jPeriods    = (array) ($_POST['job_period']  ?? []);
    $jRoles      = (array) ($_POST['job_role']    ?? []);
    $jShows      = (array) ($_POST['job_show']    ?? []);
    $jCompanies  = (array) ($_POST['job_company'] ?? []);
    $jVenues     = (array) ($_POST['job_venue']   ?? []);
    $jPlaces     = (array) ($_POST['job_place_query'] ?? []);
    $jImages     = (array) ($_POST['job_image'] ?? []);
    $data['experiencePage']['jobs'] = [];
    foreach ($jPeriods as $i => $period) {
        $data['experiencePage']['jobs'][] = [
            'period'  => trim($period),
            'role'    => trim($jRoles[$i]     ?? ''),
            'show'    => trim($jShows[$i]     ?? ''),
            'company' => trim($jCompanies[$i] ?? ''),
            'venue'   => trim($jVenues[$i]    ?? ''),
            'placeQuery' => trim($jPlaces[$i] ?? ''),
            'image'   => hk_normalize_url((string)($jImages[$i] ?? '')),
        ];
    }
    // education
    $ePeriods = (array) ($_POST['edu_period'] ?? []);
    $eSchools = (array) ($_POST['edu_school'] ?? []);
    $eQuals   = (array) ($_POST['edu_qual']   ?? []);
    $data['experiencePage']['education'] = [];
    foreach ($ePeriods as $i => $period) {
        $data['experiencePage']['education'][] = [
            'period'        => trim($period),
            'school'        => trim($eSchools[$i] ?? ''),
            'qualification' => trim($eQuals[$i]   ?? ''),
        ];
    }

    // contact
    $data['contact']['heading']   = trim((string) ($_POST['contact_heading'] ?? ''));
    $data['contact']['body']      = trim((string) ($_POST['contact_body'] ?? ''));
    $data['contact']['phone']     = trim((string) ($_POST['contact_phone'] ?? ''));
    $data['contact']['email']     = trim((string) ($_POST['contact_email'] ?? ''));
    $data['contact']['mapEmbedUrl'] = hk_normalize_url((string) ($_POST['contact_map'] ?? ''));
    $data['contact']['copyright'] = trim((string) ($_POST['contact_copyright'] ?? ''));

    try {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $json  = null;
        $error = 'Could not encode content: ' . $e->getMessage();
    }
    if ($json !== null) {
        if (file_put_contents(CONTENT_FILE, $json . "\n") === false) {
            $error = 'Could not write content file. Check folder permissions.';
        } else {
            header('Location: index.php?saved=1', true, 303);
            exit;
        }
    }
}

if (isset($_GET['saved'])) $message = 'Content saved successfully.';

// ─── Load data ────────────────────────────────────────────────────────────────
$raw = is_readable(CONTENT_FILE) ? (string) file_get_contents(CONTENT_FILE) : '{}';
$c   = json_decode($raw, true) ?? [];

$allImages    = hk_list_images();
$imagesJson   = json_encode($allImages, JSON_UNESCAPED_UNICODE);
$socialPlatforms = [
    'linkedin'  => 'LinkedIn',
    'instagram' => 'Instagram',
    'facebook'  => 'Facebook',
    'tiktok'    => 'TikTok',
    'youtube'   => 'YouTube',
    'pinterest' => 'Pinterest',
    'twitter'   => 'Twitter / X',
];
// Build social URL lookup
$socialUrls = [];
foreach ((array) ($c['site']['socialLinks'] ?? []) as $sl) {
    $socialUrls[$sl['platform'] ?? ''] = (string) ($sl['url'] ?? '');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hayley Kharsa — Site Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
  <link rel="stylesheet" href="./admin.css?v=<?= urlencode((string) @filemtime(__DIR__ . '/admin.css')) ?>" />
</head>
<body>

<?php if (!$authed): ?>
<div class="login-wrap">
  <div class="login-card">
    <h1>Hayley Kharsa &mdash; Site Admin</h1>
    <?php if ($error !== ''): ?>
      <div class="alert alert--err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autocomplete="username" required />
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required />
      </div>
      <button class="btn-save" type="submit" name="cms_login" value="1">Sign in</button>
    </form>
  </div>
</div>

<?php else: ?>

<div class="layout">
  <aside class="sidebar">
    <h1>Hayley Kharsa<br>Site Admin</h1>
    <a href="../index.php" target="_blank" style="margin-top:.25rem">View Site &nearr;</a>
    <a class="logout" href="index.php?logout=1">Sign out</a>
    <hr class="sidebar-divider" />
    <span class="sidebar-label">Global</span>
    <a href="#nav">Navigation</a>
    <a href="#site">Site settings</a>
    <a href="#site-social">Social links</a>
    <a href="#site-booking">Booking settings</a>
    <hr class="sidebar-divider" />
    <span class="sidebar-label">Homepage</span>
    <a href="#hero">Hero</a>
    <a href="#about-home">About teaser</a>
    <a href="#services-home">Services preview</a>
    <a href="#gallery-home">Gallery preview</a>
    <a href="#testimonials-home">Testimonials preview</a>
    <a href="#experience-home">Experience preview</a>
    <a href="#contact-home">Contact strip</a>
    <div class="panel-mode-toggle">
      <button type="button" id="hk-show-all-sections">Show all sections</button>
    </div>
    <hr class="sidebar-divider" />
    <span class="sidebar-label">Pages</span>
    <a href="#about-page">About page</a>
    <a href="#services-page">Services page</a>
    <a href="#gallery-page">Gallery page</a>
    <a href="#testimonials-page">Testimonials page</a>
    <a href="#experience-page">Experience page</a>
    <a href="#contact-page">Contact page</a>
    <hr class="sidebar-divider" />
  </aside>

  <div class="main-content">
    <?php if ($message !== ''): ?>
      <div class="alert alert--ok"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
      <div class="alert alert--err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" id="cms-form">
      <div class="card">
        <h3>How content flows</h3>
        <p class="field-hint">This CMS follows the live site flow. Homepage sections and full pages share the same datasets below, so updates stay in sync.</p>
      </div>
      <input type="hidden" name="cms_save" value="1" />
      <input type="hidden" name="cms_csrf" value="<?= htmlspecialchars($csrf) ?>" />

      <!-- ── 1. SITE SETTINGS ─────────────────────────────────────────────── -->
      <div class="card cms-panel" id="site">
        <h3>1. Site Settings</h3>
        <div class="grid-2">
          <?php hk_field('brand_name', 'Brand Name', hk_v($c,'site','brandName')) ?>
          <?php hk_field('tagline', 'Tagline', hk_v($c,'site','tagline')) ?>
        </div>
        <?php hk_field('meta_description', 'Site-wide Meta Description', hk_v($c,'site','metaDescription'), 'textarea-plain', 2) ?>
        <div class="grid-2" id="site-booking">
          <?php hk_field('opening_hours', 'Opening Hours', hk_v($c,'site','openingHours'), 'text') ?>
          <?php hk_field('booking_url', 'Default Booking URL', hk_v($c,'site','bookingUrl'), 'text') ?>
        </div>
        <div class="toggle-wrap">
          <input type="checkbox" id="show_booking_form" name="show_booking_form" value="1"
            <?= !empty($c['site']['showBookingForm']) ? 'checked' : '' ?> />
          <label for="show_booking_form">Show booking enquiry form on Contact page</label>
        </div>

        <h4 id="site-social">Social Links</h4>
        <p class="field-hint" style="margin-bottom:.75rem">Leave blank to hide. Active ones will show as icons on the site.</p>
        <?php foreach ($socialPlatforms as $platform => $lbl): ?>
          <?php hk_field('social_' . $platform, $lbl . ' URL', $socialUrls[$platform] ?? '') ?>
        <?php endforeach; ?>
      </div>

      <!-- ── 2. NAVIGATION ──────────────────────────────────────────────────── -->
      <div class="card cms-panel" id="nav">
        <h3>2. Navigation</h3>
        <p class="field-hint">Home is excluded — it links via the brand logo. Add, remove or reorder links below.</p>
        <div id="nav-rows">
          <?php foreach ((array)($c['navigation'] ?? []) as $nav): ?>
          <div class="repeater-row">
            <div class="grid-2">
              <div class="field"><label>Label</label><input type="text" name="nav_label[]" value="<?= htmlspecialchars((string)($nav['label']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>URL</label><input type="text" name="nav_url[]" class="js-url-field" value="<?= htmlspecialchars((string)($nav['url']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            </div>
            <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" onclick="addNavRow()">+ Add Nav Link</button>
        <template id="nav-row-tpl">
          <div class="repeater-row">
            <div class="grid-2">
              <div class="field"><label>Label</label><input type="text" name="nav_label[]" value="" /></div>
              <div class="field"><label>URL</label><input type="text" name="nav_url[]" class="js-url-field" value="" /></div>
            </div>
            <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
          </div>
        </template>
      </div>

      <!-- ── 3. HERO ────────────────────────────────────────────────────────── -->
      <div class="card cms-panel" id="hero">
        <h3>Hero (Homepage)</h3>
        <?php hk_field('hero_eyebrow', 'Eyebrow Text', hk_v($c,'hero','eyebrow')) ?>
        <?php hk_field('hero_heading', 'Heading', hk_v($c,'hero','heading')) ?>
        <?php hk_field('hero_text', 'Body Text', hk_v($c,'hero','text'), 'textarea', 3) ?>
        <div class="grid-2">
          <?php hk_field('hero_cta_label', 'Primary Button Label', hk_v($c,'hero','primaryCtaLabel')) ?>
          <?php hk_field('hero_cta_url', 'Primary Button URL', hk_v($c,'hero','primaryCtaUrl')) ?>
        </div>
        <div class="grid-2">
          <?php hk_field('hero_cta2_label', 'Secondary Button Label', hk_v($c,'hero','secondaryCtaLabel')) ?>
          <?php hk_field('hero_cta2_url', 'Secondary Button URL', hk_v($c,'hero','secondaryCtaUrl')) ?>
        </div>
        <?php hk_media_field('hero_image', 'Hero Image', hk_v($c,'hero','image','url')) ?>
        <?php hk_field('hero_image_alt', 'Hero Image Alt Text', hk_v($c,'hero','image','alt')) ?>
        <div class="grid-2">
          <?php hk_field('page_home_title', 'Home Page Title (SEO)', hk_v($c,'pages','home','metaTitle')) ?>
          <?php hk_field('page_home_desc', 'Home Meta Description (SEO)', hk_v($c,'pages','home','metaDescription')) ?>
        </div>
      </div>

      <!-- ── 4. ABOUT ───────────────────────────────────────────────────────── -->
      <div class="card cms-panel" id="about">
        <h3>About (Homepage teaser + About page)</h3>
        <div class="grid-2">
          <?php hk_field('page_about_title', 'About Page Title (SEO)', hk_v($c,'pages','about','metaTitle')) ?>
          <?php hk_field('page_about_desc', 'About Meta Description (SEO)', hk_v($c,'pages','about','metaDescription')) ?>
        </div>
        <?php hk_field('about_heading', 'Heading', hk_v($c,'about','heading')) ?>
        <?php hk_field('about_home_summary', 'About teaser (Homepage only)', hk_v($c,'about','homeSummary'), 'textarea-plain', 3) ?>
        <?php hk_field('about_body', 'Full About content (/about)', hk_v($c,'about','body'), 'textarea', 8) ?>

        <h4>Metrics / Stats</h4>
        <div id="metric-rows">
          <?php foreach ((array)($c['about']['metrics'] ?? []) as $m): ?>
          <div class="repeater-row">
            <div class="grid-2">
              <div class="field"><label>Value</label><input type="text" name="metric_value[]" value="<?= htmlspecialchars((string)($m['value']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>Label</label><input type="text" name="metric_label[]" value="<?= htmlspecialchars((string)($m['label']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            </div>
            <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" onclick="addMetricRow()">+ Add Metric</button>
        <template id="metric-row-tpl">
          <div class="repeater-row">
            <div class="grid-2">
              <div class="field"><label>Value</label><input type="text" name="metric_value[]" value="" /></div>
              <div class="field"><label>Label</label><input type="text" name="metric_label[]" value="" /></div>
            </div>
            <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
          </div>
        </template>
      </div>

      <!-- ── 5. SERVICES ────────────────────────────────────────────────────── -->
      <div class="card cms-panel" id="services">
        <h3>Services (Homepage preview + Services page)</h3>
        <div class="grid-2">
          <?php hk_field('page_services_title', 'Services Page Title (SEO)', hk_v($c,'pages','services','metaTitle')) ?>
          <?php hk_field('page_services_desc', 'Services Meta Description (SEO)', hk_v($c,'pages','services','metaDescription')) ?>
        </div>
        <div id="service-rows">
          <?php foreach ((array)($c['services'] ?? []) as $idx => $s):
            $si = (string) $idx;
          ?>
          <div class="repeater-row">
            <div class="repeater-row-head">
              <span class="repeater-row-label">Service</span>
              <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
            </div>
            <div class="field"><label>Title</label><input type="text" name="service_title[]" value="<?= htmlspecialchars((string)($s['title']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            <div class="field"><label>Summary</label><textarea name="service_summary[]" rows="3" class="cms-wysiwyg"><?= htmlspecialchars((string)($s['summary']??''), ENT_QUOTES,'UTF-8') ?></textarea></div>
            <?php hk_media_field('service_image_' . $si, 'Service Image', (string)($s['image']??''), 'service_image[]') ?>
            <div class="field"><label>Image Alt Text</label><input type="text" name="service_alt[]" value="<?= htmlspecialchars((string)($s['alt']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            <div class="grid-2">
              <div class="field"><label>Book Button Label</label><input type="text" name="service_book_label[]" value="<?= htmlspecialchars((string)($s['bookCtaLabel']??'Book'), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>Book Button URL</label><input type="text" name="service_book_url[]" class="js-url-field" value="<?= htmlspecialchars((string)($s['bookCtaUrl']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" onclick="addServiceRow()">+ Add Service</button>
        <template id="service-row-tpl">
          <div class="repeater-row">
            <div class="repeater-row-head">
              <span class="repeater-row-label">Service</span>
              <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
            </div>
            <div class="field"><label>Title</label><input type="text" name="service_title[]" value="" /></div>
            <div class="field"><label>Summary</label><textarea name="service_summary[]" rows="3"></textarea></div>
            <div class="field"><label>Image</label>
              <div class="media-picker" data-mode="single">
                <div class="media-picker-preview"><span class="picker-no-preview">No image selected</span></div>
                <div class="media-picker-controls">
                  <input type="hidden" name="service_image[]" class="media-picker-input" data-picker-context="Service Image" value="" />
                  <button type="button" class="btn-picker media-picker-open">Choose image</button>
                  <button type="button" class="btn-picker-clear" onclick="this.closest('.media-picker').querySelector('.media-picker-input').value='';this.closest('.media-picker').querySelector('.media-picker-preview').innerHTML='<span class=\'picker-no-preview\'>No image selected</span>'">Clear</button>
                </div>
              </div>
            </div>
            <div class="field"><label>Image Alt Text</label><input type="text" name="service_alt[]" value="" /></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
              <div class="field"><label>Book Button Label</label><input type="text" name="service_book_label[]" value="Book" /></div>
              <div class="field"><label>Book Button URL</label><input type="text" name="service_book_url[]" class="js-url-field" value="./contact" /></div>
            </div>
          </div>
        </template>
      </div>

      <!-- ── 6. GALLERY ─────────────────────────────────────────────────────── -->
      <div class="card cms-panel" id="gallery">
        <h3>Gallery (Homepage preview + Gallery page)</h3>
        <div class="grid-2">
          <?php hk_field('page_gallery_title', 'Gallery Page Title (SEO)', hk_v($c,'pages','gallery','metaTitle')) ?>
          <?php hk_field('page_gallery_desc', 'Gallery Meta Description (SEO)', hk_v($c,'pages','gallery','metaDescription')) ?>
        </div>
        <p class="field-hint">Images can be reordered by dragging. Use &ldquo;Add Images&rdquo; to select multiple images at once.</p>
        <div id="gallery-rows">
          <?php foreach ((array)($c['gallery'] ?? []) as $g): ?>
          <?php $gimg = (string)($g['image']??''); $gprev = $gimg !== '' ? '../'.ltrim(str_replace('./','/',$gimg),'/') : ''; ?>
          <div class="repeater-row gallery-row" draggable="true">
            <div class="gallery-thumb-row">
              <img class="gallery-thumb-img" src="<?= htmlspecialchars($gprev, ENT_QUOTES,'UTF-8') ?>" alt="" loading="lazy" onerror="this.style.display='none'" />
              <div class="gallery-row-fields">
                <input type="hidden" name="gallery_image[]" class="gallery-img-val" value="<?= htmlspecialchars($gimg, ENT_QUOTES,'UTF-8') ?>" />
                <input type="hidden" name="gallery_title[]" value="<?= htmlspecialchars((string)($g['title']??''), ENT_QUOTES,'UTF-8') ?>" />
                <div class="field" style="margin:0"><label style="font-size:.72rem">Alt Text</label><input type="text" name="gallery_alt[]" value="<?= htmlspecialchars((string)($g['alt']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              </div>
              <button type="button" class="btn-remove" onclick="this.closest('.gallery-row').remove()">×</button>
            </div>
          </div>
          <?php endforeach; ?>
          <div class="gallery-add-tile">
            <button type="button" class="btn-add-gallery" id="gallery-add-btn">+ Add Images</button>
          </div>
        </div>
        <template id="gallery-row-tpl">
          <div class="repeater-row gallery-row" draggable="true">
            <div class="gallery-thumb-row">
              <img class="gallery-thumb-img" src="" alt="" loading="lazy" onerror="this.style.display='none'" />
              <div class="gallery-row-fields">
                <input type="hidden" name="gallery_image[]" class="gallery-img-val" value="" />
                <input type="hidden" name="gallery_title[]" value="" />
                <div class="field" style="margin:0"><label style="font-size:.72rem">Alt Text</label><input type="text" name="gallery_alt[]" value="" /></div>
              </div>
              <button type="button" class="btn-remove" onclick="this.closest('.gallery-row').remove()">×</button>
            </div>
          </div>
        </template>
      </div>

      <!-- ── 7. TESTIMONIALS ────────────────────────────────────────────────── -->
      <div class="card cms-panel" id="testimonials">
        <h3>Testimonials (Homepage preview + Testimonials page)</h3>
        <div class="grid-2">
          <?php hk_field('page_testimonials_title', 'Testimonials Page Title (SEO)', hk_v($c,'pages','testimonials','metaTitle')) ?>
          <?php hk_field('page_testimonials_desc', 'Testimonials Meta Description (SEO)', hk_v($c,'pages','testimonials','metaDescription')) ?>
        </div>
        <div id="testimonial-rows">
          <?php
          $testimonials = (array)($c['testimonials'] ?? []);
          if (empty($testimonials)) $testimonials = [['quote'=>'','name'=>'','role'=>'']];
          foreach ($testimonials as $t):
          ?>
          <div class="repeater-row">
            <div class="repeater-row-head">
              <span class="repeater-row-label">Testimonial</span>
              <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
            </div>
            <div class="field"><label>Quote</label><textarea name="testimonial_quote[]" rows="3"><?= htmlspecialchars((string)($t['quote']??''), ENT_QUOTES,'UTF-8') ?></textarea></div>
            <div class="grid-2">
              <div class="field"><label>Client Name</label><input type="text" name="testimonial_name[]" value="<?= htmlspecialchars((string)($t['name']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>Role / Context (optional)</label><input type="text" name="testimonial_role[]" value="<?= htmlspecialchars((string)($t['role']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" onclick="addTestimonialRow()">+ Add Testimonial</button>
        <template id="testimonial-row-tpl">
          <div class="repeater-row">
            <div class="repeater-row-head">
              <span class="repeater-row-label">Testimonial</span>
              <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
            </div>
            <div class="field"><label>Quote</label><textarea name="testimonial_quote[]" rows="3"></textarea></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
              <div class="field"><label>Client Name</label><input type="text" name="testimonial_name[]" value="" /></div>
              <div class="field"><label>Role / Context (optional)</label><input type="text" name="testimonial_role[]" value="" /></div>
            </div>
          </div>
        </template>
      </div>

      <!-- ── 8. EXPERIENCE ──────────────────────────────────────────────────── -->
      <div class="card cms-panel" id="experience">
        <h3>Experience (Homepage preview + Experience page)</h3>
        <div class="grid-2">
          <?php hk_field('page_experience_title', 'Experience Page Title (SEO)', hk_v($c,'pages','experience','metaTitle')) ?>
          <?php hk_field('page_experience_desc', 'Experience Meta Description (SEO)', hk_v($c,'pages','experience','metaDescription')) ?>
        </div>
        <?php hk_field('exp_heading', 'Page Heading', hk_v($c,'experiencePage','heroHeading')) ?>
        <?php hk_field('exp_text', 'Page Intro Text', hk_v($c,'experiencePage','heroText'), 'textarea-plain', 2) ?>

        <h4>Work Experience</h4>
        <div id="job-rows">
          <?php foreach ((array)($c['experiencePage']['jobs'] ?? []) as $j): ?>
          <div class="repeater-row">
            <div class="grid-3">
              <div class="field"><label>Period</label><input type="text" name="job_period[]" value="<?= htmlspecialchars((string)($j['period']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>Role</label><input type="text" name="job_role[]" value="<?= htmlspecialchars((string)($j['role']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>Show / Production</label><input type="text" name="job_show[]" value="<?= htmlspecialchars((string)($j['show']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            </div>
            <div class="grid-2">
              <div class="field"><label>Company</label><input type="text" name="job_company[]" value="<?= htmlspecialchars((string)($j['company']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>Venue / Tour</label><input type="text" name="job_venue[]" value="<?= htmlspecialchars((string)($j['venue']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            </div>
            <div class="grid-2">
              <div class="field"><label>Location (optional)</label><input type="text" name="job_place_query[]" value="<?= htmlspecialchars((string)($j['placeQuery']??''), ENT_QUOTES,'UTF-8') ?>" placeholder="e.g. Royal Albert Hall London" /></div>
              <div class="field"><label>Image URL</label><input type="text" name="job_image[]" class="js-url-field" value="<?= htmlspecialchars((string)($j['image']??''), ENT_QUOTES,'UTF-8') ?>" placeholder="https://www..." /></div>
            </div>
            <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" onclick="addJobRow()">+ Add Job</button>
        <template id="job-row-tpl">
          <div class="repeater-row">
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem">
              <div class="field"><label>Period</label><input type="text" name="job_period[]" value="" /></div>
              <div class="field"><label>Role</label><input type="text" name="job_role[]" value="" /></div>
              <div class="field"><label>Show / Production</label><input type="text" name="job_show[]" value="" /></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
              <div class="field"><label>Company</label><input type="text" name="job_company[]" value="" /></div>
              <div class="field"><label>Venue / Tour</label><input type="text" name="job_venue[]" value="" /></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
              <div class="field"><label>Location (optional)</label><input type="text" name="job_place_query[]" value="" placeholder="e.g. Royal Albert Hall London" /></div>
              <div class="field"><label>Image URL</label><input type="text" name="job_image[]" class="js-url-field" value="" placeholder="https://www..." /></div>
            </div>
            <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
          </div>
        </template>

        <h4 style="margin-top:1.5rem">Education</h4>
        <div id="edu-rows">
          <?php foreach ((array)($c['experiencePage']['education'] ?? []) as $e): ?>
          <div class="repeater-row">
            <div class="grid-3">
              <div class="field"><label>Period</label><input type="text" name="edu_period[]" value="<?= htmlspecialchars((string)($e['period']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>School / College</label><input type="text" name="edu_school[]" value="<?= htmlspecialchars((string)($e['school']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
              <div class="field"><label>Qualification</label><input type="text" name="edu_qual[]" value="<?= htmlspecialchars((string)($e['qualification']??''), ENT_QUOTES,'UTF-8') ?>" /></div>
            </div>
            <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" onclick="addEduRow()">+ Add Education</button>
        <template id="edu-row-tpl">
          <div class="repeater-row">
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem">
              <div class="field"><label>Period</label><input type="text" name="edu_period[]" value="" /></div>
              <div class="field"><label>School / College</label><input type="text" name="edu_school[]" value="" /></div>
              <div class="field"><label>Qualification</label><input type="text" name="edu_qual[]" value="" /></div>
            </div>
            <button type="button" class="btn-remove" onclick="this.closest('.repeater-row').remove()">Remove</button>
          </div>
        </template>
      </div>

      <!-- ── 9. CONTACT ─────────────────────────────────────────────────────── -->
      <div class="card cms-panel" id="contact">
        <h3>Contact (Homepage strip + Contact page)</h3>
        <div class="grid-2">
          <?php hk_field('page_contact_title', 'Contact Page Title (SEO)', hk_v($c,'pages','contact','metaTitle')) ?>
          <?php hk_field('page_contact_desc', 'Contact Meta Description (SEO)', hk_v($c,'pages','contact','metaDescription')) ?>
        </div>
        <?php hk_field('contact_heading', 'Heading', hk_v($c,'contact','heading')) ?>
        <?php hk_field('contact_body', 'Intro Text', hk_v($c,'contact','body'), 'textarea-plain', 2) ?>
        <div class="grid-2">
          <?php hk_field('contact_phone', 'Phone', hk_v($c,'contact','phone')) ?>
          <?php hk_field('contact_email', 'Email', hk_v($c,'contact','email')) ?>
        </div>
        <?php hk_field('contact_map', 'Google Maps Embed URL (iframe src)', hk_v($c,'contact','mapEmbedUrl')) ?>
        <?php hk_field('contact_copyright', 'Copyright Line', hk_v($c,'contact','copyright')) ?>
      </div>

      <div class="save-bar">
        <button class="btn-save" type="submit">Save all changes</button>
        <span style="font-size:.85rem;color:var(--muted)">Changes are saved to site-content.json</span>
      </div>
    </form>
  </div>
</div>

<!-- ── Media picker dialog ────────────────────────────────────────────────── -->
<dialog id="hk-picker-dialog">
  <div class="picker-dialog-head">
    <h2 id="hk-picker-title">Choose Image</h2>
    <button id="hk-picker-cancel" type="button" style="background:none;border:1px solid var(--line);border-radius:6px;padding:.3rem .75rem;cursor:pointer">Close</button>
  </div>
  <div class="picker-dialog-body">
    <div id="hk-picker-error"></div>
    <div class="picker-toolbar">
      <input type="text" id="hk-picker-filter" placeholder="Filter by filename&hellip;" autocomplete="off" />
      <button type="button" id="hk-picker-upload-btn">Upload image</button>
      <input type="file" id="hk-picker-upload-input" accept="image/jpeg,image/png,image/gif,image/webp,.jpg,.jpeg,.png,.gif,.webp" />
      <button type="button" id="hk-picker-add-selected" style="display:none" disabled>Add Selected</button>
    </div>
    <div class="picker-grid" id="hk-picker-grid"></div>
  </div>
</dialog>

<!-- Inline image list for picker -->
<script type="application/json" id="hk-media-data"><?= $imagesJson ?></script>

<script src="media-picker.js"></script>

<script src="./admin.js?v=<?= urlencode((string) @filemtime(__DIR__ . '/admin.js')) ?>"></script>

<?php endif; ?>
</body>
</html>

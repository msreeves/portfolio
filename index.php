<?php
require __DIR__ . '/includes/site-bootstrap.php';
require __DIR__ . '/includes/vendor-assets.php';
$content = load_site_content();
$projects = cms_load_portfolio_projects();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Michael Reeves — Front-End WordPress Developer & CMS Specialist. Digital publishing, enterprise CMS delivery, and labelled programme demos with downloadable CV." />
    <meta name="keywords" content="Michael Reeves, portfolio, front-end developer, WordPress developer, CMS web editor, digital content, marketing design, Canva, campaign design, EpiServer, HTML, CSS, JavaScript, PHP" />
    <meta name="author" content="Michael Reeves">
    <title>Michael Reeves — Portfolio</title>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Michael Reeves — Portfolio" />
    <meta property="og:description" content="Front-End WordPress Developer & CMS Specialist — selected work, experience, and downloadable CV." />
    <meta property="og:url" content="https://www.msreeves.co.uk/" />
    <meta property="og:image" content="https://www.msreeves.co.uk/media/images/case-studies/atlas-ops.png" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Michael Reeves — Portfolio" />
    <meta name="twitter:description" content="Front-End WordPress Developer & CMS Specialist — digital publishing and front-end delivery." />
    <meta name="twitter:image" content="https://www.msreeves.co.uk/media/images/case-studies/atlas-ops.png" />
    <link rel="canonical" href="https://www.msreeves.co.uk/" />
    <link rel="stylesheet" href="<?= esc(cms_vendor_href('fonts/kodchasan/kodchasan.css')) ?>" />
    <link rel="stylesheet" href="<?= esc(cms_vendor_href('bootstrap/css/bootstrap.min.css')) ?>" />
    <link rel="stylesheet" href="<?= esc(cms_vendor_href('fontawesome/css/all.min.css')) ?>" />
    <link rel="stylesheet" href="<?= esc(cms_vendor_href('fontawesome/css/v4-shims.min.css')) ?>" />
    <link rel="icon" href="<?= esc(cms_img_src($content, 'img_intro_logo')) ?>" type="image/jpeg" />
    <link rel="preload" as="image" href="<?= esc(cms_img_src($content, 'img_intro_logo')) ?>" fetchpriority="high" />
    <link rel="stylesheet" href="./css/style.css?v=<?= esc(cms_asset_v('css/style.css')) ?>" />
    <link rel="stylesheet" href="./css/responsive.css?v=<?= esc(cms_asset_v('css/responsive.css')) ?>" />
</head>

<body class="msr-portfolio">
	<a class="visually-hidden-focusable" href="#site-content"><?= esc( 'Skip to content' ) ?></a>

        <header class="portfolio-header">
            <nav class="navbar navbar-expand-lg portfolio-nav" aria-label="<?= esc('Primary') ?>">
                <div class="portfolio-nav-inner">
                    <button class="navbar-toggler portfolio-nav-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
                        aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="<?= esc('Toggle navigation') ?>">
                        <span class="navbar-toggler-icon" aria-hidden="true">
                            <i class="fas fa-bars nav-toggler-bars" aria-hidden="true"></i>
                            <i class="fas fa-xmark nav-toggler-close" aria-hidden="true"></i>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse portfolio-nav-collapse" id="navbarTogglerDemo01">
                        <ul class="navbar-nav portfolio-nav-list mx-lg-auto">
                            <?php foreach (cms_site_nav_items_for_render($content) as $navItem) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= esc($navItem['href']) ?>"><?= esc($navItem['label']) ?></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="intro" class="intro-hero">
            <div class="intro-hero-layout">
                <div class="intro-hero-media">
                    <img class="intro-hero-photo" src="<?= esc(cms_img_src($content, 'img_intro_logo')) ?>" alt="<?= esc(cms_img_alt_for_key('img_intro_logo')) ?>" width="1200" height="1200" fetchpriority="high" decoding="async" />
                </div>
                <div class="intro-hero-panel">
                    <div class="intro-hero-copy">
                        <h1 class="intro-hero-title msr-fade-in"><?= esc(cms_intro_headline_for_hero($content)) ?></h1>
                        <p class="intro-hero-byline msr-fade-in"><?= esc((string) ($content['intro_name'] ?? 'Michael Reeves')) ?></p>
                        <p class="intro-tagline intro-hero-tagline msr-fade-in"><?= esc(cms_intro_tagline_for_hero($content)) ?></p>
<?php
                        $heroMethod = cms_intro_method_for_hero($content);
                        if ($heroMethod !== '') {
?>
                        <p class="intro-hero-method msr-fade-in"><?= esc($heroMethod) ?></p>
<?php } ?>
                        <div class="intro-hero-ctas msr-fade-in">
                            <?php cms_render_cv_download_chips($content, [
                                'wrap_class' => 'portfolio-hero-cta-row',
                                'extra_links' => [
                                    [
                                        'href' => '#recent-portfolio',
                                        'label' => 'View selected work',
                                        'class' => 'portfolio-chip portfolio-chip--primary portfolio-chip--hero-work',
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </header>

    <main id="site-content" class="portfolio-main portfolio-flow">
    <section id="career-highlights" class="portfolio-scan-band" aria-labelledby="career-highlights-heading">
        <div class="container portfolio-shell portfolio-scan-band__inner">
<?php cms_render_recruiter_scan_section($content); ?>
        </div>
    </section>
    <section id="recent-portfolio">
        <div class="container portfolio-shell">
<?php
$selectedWorkHeading = trim((string) ($content['heading_recent_portfolio'] ?? ''));
if ($selectedWorkHeading === '' || strcasecmp($selectedWorkHeading, 'Featured case studies') === 0) {
    $selectedWorkHeading = 'Selected work';
}
cms_render_section_heading($selectedWorkHeading);
?>

<?php cms_render_panel_grid($content, ['html_recent_portfolio_1']); ?>

<?php cms_render_msr_case_study_grid($content); ?>
        </div>
    </section>
    <section id="work-for">
        <div class="container portfolio-shell">
<?php cms_render_section_heading((string) $content['heading_work_for']); ?>
<?php cms_render_work_experience_section($content); ?>
        </div>
    </section>
    <section id="how-i-work" aria-labelledby="how-i-work-heading">
        <div class="container portfolio-shell">
<?php cms_render_how_i_work_section($content); ?>
        </div>
    </section>
    <section id="portfolio-transparency" class="portfolio-transparency-band" aria-label="Labelling and production transparency">
        <div class="container portfolio-shell portfolio-transparency-stack">
            <details id="portfolio-lanes" class="portfolio-disclosure portfolio-transparency-disclosure msr-fade-in">
                <summary class="portfolio-disclosure-summary">How work is labelled here</summary>
                <div class="portfolio-disclosure-body">
<?php cms_render_portfolio_lanes_section($content, false); ?>
                </div>
            </details>
            <details id="demo-vs-live" class="portfolio-disclosure portfolio-transparency-disclosure msr-fade-in">
                <summary class="portfolio-disclosure-summary">Demo vs live client (production checklist)</summary>
                <div class="portfolio-disclosure-body">
<?php cms_render_demo_vs_live_strip($content, false); ?>
                </div>
            </details>
        </div>
    </section>
    <section>
        <div id="introduction">
            <div class="container portfolio-shell">
<?php cms_render_section_heading((string) $content['about_heading']); ?>
<?php cms_render_panel_grid($content, ['html_introduction_1', 'html_introduction_2']); ?>
                <div class="employer-logo-grid">
                    <p class="employer-logo-grid-caption">Websites I worked on — brand and publishing sites from current and agency roles</p>
                    <div class="employer-logo-grid-inner employer-brand-grid">
<?php foreach (cms_employer_logo_items() as $logo) {
    $logoLabel = (string) ($logo['label'] ?? '');
    $logoHref = (string) ($logo['href'] ?? '');
    $isExternal = preg_match('#^https?://#i', $logoHref) === 1;
    ?>
                        <a href="<?= esc($logoHref) ?>"<?= $isExternal ? ' target="_blank" rel="noopener noreferrer"' : '' ?> class="employer-logo-link employer-brand-card" aria-label="<?= esc($logoLabel . ($isExternal ? ' (opens in a new tab)' : '')) ?>">
                            <span class="employer-brand-card__mark">
                                <img src="<?= esc(cms_img_src($content, $logo['img'])) ?>" alt="" loading="lazy" decoding="async">
                            </span>
                            <span class="employer-brand-card__label">
                                <?= esc($logoLabel) ?>
<?php if ($isExternal) { ?>
                                <i class="fas fa-external-link-alt" aria-hidden="true"></i>
<?php } else { ?>
                                <i class="fas fa-file-pdf" aria-hidden="true"></i>
<?php } ?>
                            </span>
                        </a>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="skills">
        <div class="container portfolio-shell">
            <div class="skills-section-layout skills-section-layout--tags">
<?php cms_render_section_heading((string) $content['heading_skills']); ?>
<?php cms_render_skills_section($content); ?>
            </div>
        </div>
    </section>
    <section id="testimonials">
        <div class="container portfolio-shell">
<?php cms_render_section_heading((string) $content['heading_testimonials']); ?>
<?php
$featuredParts = cms_html_parse_split_parts('html_testimonial_1', (string) ($content['html_testimonial_1'] ?? ''));
$featuredTitle = is_array($featuredParts) ? trim((string) ($featuredParts['__title'] ?? '')) : '';
$featuredBody = is_array($featuredParts) ? trim((string) ($featuredParts['__body'] ?? '')) : '';
if ($featuredBody === '' && cms_html_has_content($content, 'html_testimonial_1')) {
    $featuredBody = trim(strip_tags(cms_html_raw($content, 'html_testimonial_1')));
}
?>
            <figure class="testimonial-featured msr-fade-in">
                <blockquote class="testimonial-featured-quote">
<?php if ($featuredBody !== '') { ?>
                    <?= $featuredBody ?>
<?php } else {
    content_html($content, 'html_testimonial_1');
} ?>
                </blockquote>
<?php if ($featuredTitle !== '') { ?>
                <figcaption class="testimonial-featured-cite"><?= esc($featuredTitle) ?></figcaption>
<?php } ?>
            </figure>
            <div class="testimonial-disclosure-list">
<?php for ($ti = 2; $ti <= 3; $ti++) {
    $tKey = 'html_testimonial_' . $ti;
    if (!cms_html_has_content($content, $tKey)) {
        continue;
    }
    $tRaw = (string) ($content[$tKey] ?? '');
    $tParts = cms_html_parse_split_parts($tKey, $tRaw);
    $btnLabel = 'Testimonial ' . $ti;
    if (is_array($tParts) && trim((string) ($tParts['__title'] ?? '')) !== '') {
        $btnLabel = trim(strip_tags((string) $tParts['__title']));
    }
    $hId = 'testimonialHeading' . $ti;
    $cId = 'testimonialCollapse' . $ti;
    ?>
            <details class="portfolio-disclosure testimonial-disclosure msr-fade-in">
                <summary class="portfolio-disclosure-summary" id="<?= esc($hId) ?>">
                    <?= esc($btnLabel) ?>
                </summary>
                <div class="portfolio-disclosure-body" id="<?= esc($cId) ?>" aria-labelledby="<?= esc($hId) ?>">
                    <div class="testimonials">
                        <div class="msr-fade-in inner-content">
                            <i class="fas fa-quote-left" aria-hidden="true"></i>
<?php
    if (is_array($tParts) && trim((string) ($tParts['__body'] ?? '')) !== '') {
        echo (string) $tParts['__body'];
    } else {
        content_html($content, $tKey);
    }
?>
                        </div>
                    </div>
                </div>
            </details>
<?php } ?>
            </div>
        </div>
    </section>
<?php cms_render_archive_projects_section($content, $projects); ?>
    </main>

<section id="contact-band" class="contact-band">
    <div class="container portfolio-shell">
        <div class="row">
            <div class="col-12">
                <h2 class="contact-band-heading h4"><?= esc($content['contact_band_heading']) ?></h2>
                <p class="contact-band-intent"><?= esc($content['contact_band_intent']) ?></p>
            </div>
        </div>
    </div>
</section>

<footer id="contact" class="footer_area">
    <div class="container portfolio-shell">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <img class="img-fluid footer-logo" src="<?= esc(cms_img_src($content, 'img_footer_logo')) ?>" alt="Michael Reeves logo" loading="lazy" />
            </div>
            <div class="col-lg-6 col-md-6 position-relative">
                <div class="footer-details">
                <h2 class="h4"><?= esc($content['footer_contact_heading']) ?></h2>
                <div class="footer-contact-groups">
                  <div class="footer-contact-group footer-contact-group--pdfs">
                    <p class="footer-contact-group-label">Downloads</p>
                    <div class="footer-contact-icons footer-contact-icons--pdfs">
                      <?php cms_render_footer_cv_pdf_links($content); ?>
                    </div>
                  </div>
                  <div class="footer-contact-group footer-contact-group--social" aria-label="Social and email">
                    <p class="footer-contact-group-label">Connect</p>
                    <div class="footer-contact-icons footer-contact-icons--social">
                      <a href="mailto:<?= esc((string) ($content['contact_band_email'] ?? 'reevesy87@hotmail.co.uk')) ?>" class="footer-icon-link footer-icon-link--social" aria-label="Email Michael Reeves">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                      </a>
                      <a href="https://www.linkedin.com/in/michael-reeves-394467117/" class="footer-icon-link footer-icon-link--social" target="_blank" rel="noopener noreferrer" aria-label="Michael Reeves on LinkedIn">
                        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                      </a>
                    </div>
                  </div>
                </div>
                    <div class="copyright">
                            <h5><?= esc($content['footer_copyright']) ?></h5>
                        </div>  
                    </div>
            </div>
        </div>
    </div>
</footer>

<script src="<?= esc(cms_vendor_href('bootstrap/js/bootstrap.bundle.min.js')) ?>"></script>
<script src="./js/portfolio-site.js?v=<?= esc(cms_asset_v('js/portfolio-site.js')) ?>" defer></script>
</body>
</html>
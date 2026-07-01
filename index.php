<?php
require __DIR__ . '/includes/site-bootstrap.php';
$content = load_site_content();
$projects = cms_load_portfolio_projects();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Michael Reeves portfolio: CMS specialist and front-end WordPress developer — enterprise publishing, EpiServer, WordPress themes, MSR programme demos, and digital content." />
    <meta name="keywords" content="Michael Reeves, portfolio, front-end developer, WordPress developer, CMS web editor, digital content, web design, marketing, HTML, CSS, JavaScript, PHP, Bootstrap" />
    <meta name="author" content="Michael Reeves">
    <title>Michael Reeves — Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/v4-shims.min.css"
        integrity="sha512-u6rY9/wehqytU8mKIhPvMDHtZmj6SbJ90Ctq8r5C+esABLe7qlQ2PY4l9gwK7xmr9fMp7d8yHvg2s3+nEsRjOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="<?= esc(cms_img_src($content, 'img_intro_logo')) ?>" type="image/jpeg" />
    <link rel="preload" as="image" href="<?= esc(cms_img_src($content, 'img_intro_logo')) ?>" fetchpriority="high" />
    <link rel="stylesheet" href="./css/style.css?v=<?= esc(cms_asset_v('css/style.css')) ?>" />
    <link rel="stylesheet" href="./css/responsive.css?v=<?= esc(cms_asset_v('css/responsive.css')) ?>" />
</head>

<body class="msr-portfolio">
	<a class="visually-hidden-focusable" href="#site-content"><?= esc( 'Skip to content' ) ?></a>

        <header>
            
            <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
                    aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                    <i class="fas fa-bars nav-toggler-bars" aria-hidden="true"></i>
                    <i class="fas fa-xmark nav-toggler-close" aria-hidden="true"></i>
                </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav mx-auto">
                        <?php foreach (cms_site_nav_items_for_render($content) as $navItem) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= esc($navItem['href']) ?>"><?= esc($navItem['label']) ?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
          
            <div id="intro" class="intro-hero">
            <div class="intro-hero-layout">
                <div class="intro-hero-media">
                    <img class="intro-hero-photo" src="<?= esc(cms_img_src($content, 'img_intro_logo')) ?>" alt="<?= esc(cms_img_alt_for_key('img_intro_logo')) ?>" width="1200" height="1200" fetchpriority="high" decoding="async" />
                </div>
                <div class="intro-hero-panel">
                    <div class="intro-hero-copy">
                        <h1 class="intro-hero-title msr-fade-in"><?= esc($content['intro_name']) ?></h1>
                        <p class="intro-tagline intro-hero-tagline msr-fade-in"><?= esc(cms_intro_tagline_for_hero($content)) ?></p>
                        <div class="intro-hero-ctas msr-fade-in">
                            <?php cms_render_cv_download_chips($content, [
                                'wrap_class' => '',
                                'extra_links' => [
                                    [
                                        'href' => '#recent-portfolio',
                                        'label' => 'View case studies',
                                        'class' => 'portfolio-chip portfolio-chip--secondary',
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </header>

    <main id="site-content" class="portfolio-main">
    <section id="recent-portfolio">
        <div class="container">
<?php cms_render_section_heading((string) $content['heading_recent_portfolio']); ?>

<?php cms_render_panel_grid($content, ['html_recent_portfolio_1', 'html_recent_portfolio_2']); ?>

<?php cms_render_msr_case_study_grid(); ?>
        </div>
    </section>
    <section>
        <div id="introduction">
            <div class="container">
<?php cms_render_section_heading((string) $content['about_heading']); ?>
<?php cms_render_panel_grid($content, ['html_introduction_1', 'html_introduction_2']); ?>
<?php cms_render_about_role_tracks(); ?>
                <div class="employer-logo-grid">
                    <div class="employer-logo-grid-inner">
<?php foreach (cms_employer_logo_items() as $logo) { ?>
                        <a href="<?= esc($logo['href']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= esc($logo['label']) ?>">
                            <img class="item" src="<?= esc(cms_img_src($content, $logo['img'])) ?>" alt="<?= esc(cms_img_alt_for_key($logo['img'])) ?>">
                        </a>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="work-for">
        <div class="container">
<?php cms_render_section_heading((string) $content['heading_work_for']); ?>
<?php cms_render_work_experience_section($content); ?>
        </div>
    </section>
    <section id="skills">
        <div class="container">
            <div class="skills-section-layout skills-section-layout--tags">
<?php cms_render_section_heading((string) $content['heading_skills']); ?>
<?php cms_render_skills_section($content); ?>
            </div>
        </div>
    </section>
    <section id="testimonials">
        <div class="container">
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
            <div class="accordion testimonial-accordion testimonial-accordion--more" id="testimonialsAccordion">
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
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="<?= esc($hId) ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc($cId) ?>" aria-expanded="false" aria-controls="<?= esc($cId) ?>">
                                    <?= esc($btnLabel) ?>
                                </button>
                            </h3>
                            <div id="<?= esc($cId) ?>" class="accordion-collapse collapse" aria-labelledby="<?= esc($hId) ?>" data-bs-parent="#testimonialsAccordion">
                                <div class="accordion-body">
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
                            </div>
                        </div>
<?php } ?>
            </div>
        </div>
    </section>
<?php cms_render_archive_projects_section($content, $projects); ?>
    </main>

<section id="contact-band" class="contact-band">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="contact-band-heading h4"><?= esc($content['contact_band_heading']) ?></h2>
                <p class="contact-band-intent"><?= esc($content['contact_band_intent']) ?></p>
                <p class="contact-band-email">
                    <a href="mailto:<?= esc($content['contact_band_email']) ?>"><?= esc($content['contact_band_email']) ?></a>
                </p>
            </div>
            <div class="col-lg-4 contact-band-actions">
                <?php cms_render_cv_download_chips($content, ['wrap_class' => '']); ?>
                <a class="portfolio-chip portfolio-chip--secondary" href="https://www.linkedin.com/in/michael-reeves-394467117/" target="_blank" rel="noopener noreferrer">LinkedIn</a>
            </div>
        </div>
    </div>
</section>

<footer id="contact" class="footer_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <img class="img-fluid footer-logo" src="<?= esc(cms_img_src($content, 'img_footer_logo')) ?>" alt="Michael Reeves logo" loading="lazy" />
            </div>
            <div class="col-lg-6 col-md-6 position-relative">
                <div class="footer-details">
                <h2 class="h4"><?= esc($content['footer_contact_heading']) ?></h2>
                <div class="footer-contact-icons">
                  <?php cms_render_footer_cv_pdf_links($content); ?>
                  <a href="mailto:reevesy87@hotmail.co.uk" class="footer-icon-link" aria-label="Email Michael Reeves">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                  </a>
                  <a href="https://www.linkedin.com/in/michael-reeves-394467117/" class="footer-icon-link" target="_blank" rel="noopener noreferrer" aria-label="Michael Reeves on LinkedIn">
                    <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                  </a>
                </div>
                    <div class="copywright">
                            <h5><?= esc($content['footer_copyright']) ?></h5>
                        </div>  
                    </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  if ('IntersectionObserver' in window) {
    var revealEls = document.querySelectorAll('.msr-fade-in');
    if (revealEls.length) {
      var revealObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        });
      }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
      revealEls.forEach(function (el) { revealObserver.observe(el); });
    }
  } else {
    document.querySelectorAll('.msr-fade-in').forEach(function (el) {
      el.classList.add('is-visible');
    });
  }
});
</script>
</body>
</html>
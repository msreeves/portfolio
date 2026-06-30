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
    <meta name="description" content="Michael Reeves portfolio: CMS web editor/publisher, front-end WordPress developer, digital content and marketing projects, web builds, and creative work." />
    <meta name="keywords" content="Michael Reeves, portfolio, front-end developer, WordPress developer, CMS web editor, digital content, web design, marketing, HTML, CSS, JavaScript, PHP, Bootstrap" />
    <meta name="author" content="Michael Reeves">
    <title>Michael Reeves — Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Chewy&family=Kodchasan:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/v4-shims.min.css"
        integrity="sha512-u6rY9/wehqytU8mKIhPvMDHtZmj6SbJ90Ctq8r5C+esABLe7qlQ2PY4l9gwK7xmr9fMp7d8yHvg2s3+nEsRjOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="<?= esc(cms_img_src($content, 'img_intro_logo')) ?>" type="image/jpeg" />
    <link rel="preload" as="image" href="<?= esc(cms_img_src($content, 'img_intro_logo')) ?>" fetchpriority="high" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" crossorigin="anonymous" />
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
                        <p class="intro-hero-ctas msr-fade-in">
                            <a class="portfolio-chip portfolio-chip--primary" href="./media/pdf/michael-reeves-cv.pdf" target="_blank" rel="noopener noreferrer">Download CV</a>
                            <a class="portfolio-chip portfolio-chip--secondary" href="javascript:myscroll('recent-portfolio')">View case studies</a>
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </header>

    <main id="site-content" class="portfolio-main">
    <section>
        <div id="introduction">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="msr-portfolio-section name-panel intro-overlay">
                            <div class="intro-content">
                                <h2 class="name-title"><?= esc($content['about_heading']) ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
<?php cms_render_panel_grid($content, ['html_introduction_1', 'html_introduction_2']); ?>
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
    <section id="recent-portfolio">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="msr-portfolio-section name-panel intro-overlay">
                        <div class="intro-content">
                            <h2 class="name-title"><?= esc($content['heading_recent_portfolio']) ?></h2>
                        </div>
                    </div>
                </div>
            </div>

<?php cms_render_panel_grid($content, ['html_recent_portfolio_1', 'html_recent_portfolio_2']); ?>

            <div class="portfolio-content-grid portfolio-content-grid--cards msr-programme-grid<?= esc(cms_portfolio_grid_modifiers(count(cms_msr_case_study_cards()))) ?>">
<?php foreach (cms_msr_case_study_cards() as $card) { ?>
                <div class="portfolio-grid-cell">
                    <article class="msr-programme-card msr-fade-in">
                        <div class="msr-programme-card-body">
                            <h3 class="h5 msr-programme-card-title"><?= esc($card['title']) ?></h3>
                            <p class="msr-programme-card-stack"><?= esc($card['stack']) ?></p>
                            <p class="msr-programme-card-summary"><?= esc($card['summary']) ?></p>
                            <p class="msr-programme-card-ctas">
                                <a class="portfolio-chip portfolio-chip--primary" href="<?= esc($card['view_url']) ?>" target="_blank" rel="noopener noreferrer">View live</a>
                                <a class="portfolio-chip portfolio-chip--secondary" href="<?= esc($card['code_url']) ?>" target="_blank" rel="noopener noreferrer">GitHub</a>
                            </p>
                        </div>
                    </article>
                </div>
<?php } ?>
            </div>
        </div>
    </section>
    <section id="work-for">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="msr-portfolio-section name-panel intro-overlay">
                        <div class="intro-content">
                            <h2 class="name-title"><?= esc($content['heading_work_for']) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
<?php cms_render_panel_grid($content, cms_work_experience_panel_keys()); ?>
        </div>
    </section>
    <section id="skills">
        <div class="container">
            <div class="skills-section-layout">
                <div class="skills-courses-cell">
                    <div class="msr-portfolio-section name-panel intro-overlay">
                        <div class="intro-content">
                            <h2 class="name-title"><?= esc($content['heading_skills']) ?></h2>
                        </div>
                    </div>
<?php if (cms_html_has_content($content, 'html_skills_courses')) { ?>
                    <div class="online portfolio-panel">
                        <div class="inner-content">
<?php content_html($content, 'html_skills_courses'); ?>
                        </div>
                    </div>
<?php } ?>
                </div>
                <div class="skills-gallery">
                    <div class="portfolio-content-grid portfolio-content-grid--skills-icons skills-icon-grid">
<?php foreach (cms_skill_icon_items() as $skill) { ?>
                        <div class="portfolio-grid-cell">
                            <div class="skills-item <?= esc($skill['class']) ?>" title="<?= esc($skill['title']) ?>">
<?php if ($skill['kind'] === 'image') { ?>
                                <img class="skills-item-logo" src="<?= esc(cms_img_src($content, $skill['img'])) ?>" width="120" height="120" alt="<?= esc(cms_img_alt_for_key($skill['img'])) ?>" />
<?php } else { ?>
                                <i class="<?= esc($skill['icon']) ?>" aria-hidden="true"></i>
<?php } ?>
                                <span class="visually-hidden"><?= esc($skill['label']) ?></span>
                            </div>
                        </div>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="msr-portfolio-section name-panel intro-overlay">
                        <div class="intro-content">
                            <h2 class="name-title"><?= esc($content['heading_testimonials']) ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="accordion testimonial-accordion" id="testimonialsAccordion">
<?php for ($ti = 1; $ti <= 3; $ti++) {
    $tKey = 'html_testimonial_' . $ti;
    $tRaw = (string) ($content[$tKey] ?? '');
    $tParts = cms_html_parse_split_parts($tKey, $tRaw);
    $btnLabel = 'Testimonial ' . $ti;
    if (is_array($tParts) && trim((string) ($tParts['__title'] ?? '')) !== '') {
        $btnLabel = trim(strip_tags((string) $tParts['__title']));
    }
    $hId = 'testimonialHeading' . $ti;
    $cId = 'testimonialCollapse' . $ti;
    $isFirst = $ti === 1;
    ?>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="<?= esc($hId) ?>">
                                <button class="accordion-button<?= $isFirst ? '' : ' collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc($cId) ?>" aria-expanded="<?= $isFirst ? 'true' : 'false' ?>" aria-controls="<?= esc($cId) ?>">
                                    <?= esc($btnLabel) ?>
                                </button>
                            </h3>
                            <div id="<?= esc($cId) ?>" class="accordion-collapse collapse<?= $isFirst ? ' show' : '' ?>" aria-labelledby="<?= esc($hId) ?>" data-bs-parent="#testimonialsAccordion">
                                <div class="accordion-body">
                                    <div class="testimonials">
                                        <div class="block animatable bounceIn inner-content">
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
            </div>
        </div>
    </section>
<?php if ($projects !== []) {
    $projectGridMods = cms_portfolio_grid_modifiers(count($projects));
?>
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="msr-portfolio-section name-panel intro-overlay">
                        <div class="intro-content">
                            <h2 class="name-title"><?= esc($content['heading_portfolio']) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portfolio-content-grid portfolio-content-grid--projects portfolio-project-grid<?= esc($projectGridMods) ?>">
<?php foreach ($projects as $project) { ?>
                <div class="portfolio-grid-cell">
                    <article class="portfolio-project-card msr-fade-in">
                        <div class="portfolio-project-card-media">
                            <img class="portfolio-project-card-thumb" src="<?= esc($project['thumb']) ?>" alt="<?= esc($project['title']) ?>" loading="lazy" decoding="async" />
                        </div>
                        <div class="portfolio-project-card-body">
                            <h3 class="h5 portfolio-project-card-title"><?= esc($project['title']) ?></h3>
                            <?php if ($project['stack'] !== '') { ?>
                            <p class="portfolio-project-card-stack">Languages: <?= esc($project['stack']) ?></p>
                            <?php } ?>
                            <?php if ($project['summary'] !== '') { ?>
                            <p class="portfolio-project-card-summary"><?= esc($project['summary']) ?></p>
                            <?php } ?>
                            <p class="portfolio-project-card-ctas">
                                <?php if ($project['view_url'] !== '') { ?>
                                <a class="portfolio-chip portfolio-chip--primary" href="<?= esc($project['view_url']) ?>" target="_blank" rel="noopener noreferrer">VIEW</a>
                                <?php } ?>
                                <?php if ($project['code_url'] !== '') { ?>
                                <a class="portfolio-chip portfolio-chip--secondary" href="<?= esc($project['code_url']) ?>" target="_blank" rel="noopener noreferrer">SEE CODE</a>
                                <?php } ?>
                            </p>
                        </div>
                    </article>
                </div>
<?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
    <section id="game-test">
        <div class="container">
            <div class="row g-4">
                <div class="col-12">
                    <div class="msr-portfolio-section name-panel intro-overlay">
                        <div class="intro-content">
                            <h2 class="name-title"><?= esc($content['heading_game_test']) ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="online portfolio-panel">
                        <div class="inner-content">
<?php content_html($content, 'html_games_tested'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="timeline">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="msr-portfolio-section name-panel intro-overlay">
                        <div class="intro-content">
                            <h2 class="name-title"><?= esc($content['heading_timeline']) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
<?php
$timelineSlideCount = cms_timeline_effective_count($content);
if ($timelineSlideCount > 0) {
    ?>
        <div class="swiper timeline-swiper">
            <div class="swiper-wrapper">
<?php
    for ($ti = 1; $ti <= $timelineSlideCount; $ti++) {
        $imgKey = 'img_timeline_' . $ti;
        $htmlKey = 'html_timeline_' . $ti;
        ?>
                <div class="swiper-slide">
                    <div class="timeline">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <img class="img-fluid" src="<?= esc(cms_img_src($content, $imgKey)) ?>" alt="<?= esc(cms_img_alt_for_key($imgKey)) ?>">
                            </div>
                            <div class="block animatable bounceIn inner-content">

<?php content_html($content, $htmlKey); ?>
                            </div>
                        </div>
                    </div>
                </div>
<?php
    }
    ?>
            </div>
            <div class="swiper-button-prev timeline-swiper-prev"></div>
            <div class="swiper-button-next timeline-swiper-next"></div>
        </div>
<?php } ?>
        </div>
    </section>
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
                <a class="portfolio-chip portfolio-chip--primary" href="./media/pdf/michael-reeves-cv.pdf" target="_blank" rel="noopener noreferrer">Download CV</a>
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
                  <a href="./media/pdf/michael-reeves-cv.pdf" class="footer-icon-link" aria-label="Download CV (PDF)" rel="noopener noreferrer">
                    <i class="fas fa-file-pdf" aria-hidden="true"></i>
                  </a>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" crossorigin="anonymous"></script>
<script src="./script.js?v=<?= esc(cms_asset_v('script.js')) ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper === 'undefined') {
    return;
  }
  var common = {
    slidesPerView: 1,
    spaceBetween: 14,
    autoHeight: true,
    rewind: true,
    speed: 480,
    grabCursor: true,
    watchSlidesProgress: true,
    autoplay: {
      delay: 8000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
  };
  var tlEl = document.querySelector('#timeline .timeline-swiper');
  if (tlEl) {
    new Swiper(tlEl, Object.assign({}, common, {
      navigation: {
        nextEl: '#timeline .timeline-swiper-next',
        prevEl: '#timeline .timeline-swiper-prev',
      },
    }));
  }
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
function myscroll(myID) {
  var offset = jQuery("#" + myID).offset();
  window.scrollTo(0, offset.top);
}
</script>
</body>
</html>
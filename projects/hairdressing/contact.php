<?php
$page = 'contact';
require_once __DIR__ . '/inc/meta.php';
$status = htmlspecialchars((string) ($_GET['status'] ?? ''), ENT_QUOTES, 'UTF-8');
// Load services for dropdown
$_servicesRaw = is_readable(__DIR__ . '/content/site-content.json')
    ? json_decode((string) file_get_contents(__DIR__ . '/content/site-content.json'), true)
    : [];
$_services = (array) ($_servicesRaw['services'] ?? []);
$_showForm = (bool) ($_servicesRaw['site']['showBookingForm'] ?? true);
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $metaTitle ?></title>
  <meta name="description" content="<?= $metaDesc ?>" />
  <meta property="og:title" content="<?= $metaTitle ?>" />
  <meta property="og:description" content="<?= $metaDesc ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600;700&family=Raleway:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/main.css?v=<?= urlencode((string) @filemtime(__DIR__ . '/assets/css/main.css')) ?>" />
  <script>window.HK_FALLBACK_IMAGES = <?= $fallbackImagesJson ?>;</script>
</head>
<body data-page="contact">
  <header class="site-header">
    <div class="container nav-wrap">
      <a class="brand" href="./" data-brand-name><?= $brandName ?></a>
      <button class="nav-toggle" aria-label="Open navigation" aria-expanded="false" aria-controls="primary-nav">
        <span class="nav-toggle-bar"></span><span class="nav-toggle-bar"></span><span class="nav-toggle-bar"></span>
      </button>
      <nav class="site-nav" id="primary-nav" aria-label="Primary navigation"><ul data-nav-list></ul></nav>
    </div>
  </header>

  <main>
    <section class="page-hero">
      <div class="container">
        <p class="eyebrow">Reach out</p>
        <h1 data-contact-heading>Get in Touch</h1>
      </div>
    </section>

    <section class="section-contact">
      <div class="container contact-layout">

        <!-- Contact info -->
        <div class="contact-info">
          <p class="lead" data-contact-body></p>
          <ul class="contact-details-list">
            <li data-contact-phone></li>
            <li data-contact-email></li>
            <li class="contact-hours" data-opening-hours></li>
          </ul>
          <div class="social-links" data-social-links></div>

          <?php if (!empty($_servicesRaw['contact']['mapEmbedUrl'])): ?>
          <div class="map-embed">
            <iframe
              src="<?= htmlspecialchars((string) $_servicesRaw['contact']['mapEmbedUrl'], ENT_QUOTES, 'UTF-8') ?>"
              width="100%" height="260" style="border:0;border-radius:12px" allowfullscreen loading="lazy"
              referrerpolicy="no-referrer-when-downgrade" title="Location map"></iframe>
          </div>
          <?php endif; ?>
        </div>

        <!-- Booking form -->
        <?php if ($_showForm): ?>
        <div class="contact-form-wrap">
          <?php if ($status === 'sent'): ?>
            <div class="alert alert--ok">Thank you! Your message has been sent. I'll be in touch soon.</div>
          <?php elseif ($status === 'error'): ?>
            <div class="alert alert--err">Sorry, something went wrong. Please try again or contact me directly.</div>
          <?php endif; ?>

          <h2>Send a Booking Enquiry</h2>
          <form class="contact-form" method="post" action="./inc/contact-handler.php" novalidate>
            <input type="text" name="_hp_field" style="display:none" tabindex="-1" autocomplete="off" />
            <input type="hidden" name="contact_submit" value="1" />

            <div class="form-field">
              <label for="contact_name">Your name <span aria-hidden="true">*</span></label>
              <input type="text" id="contact_name" name="contact_name" autocomplete="name" required placeholder="Jane Smith" style="font-size:16px" />
            </div>

            <div class="form-field">
              <label for="contact_contact">Email or phone <span aria-hidden="true">*</span></label>
              <input type="text" id="contact_contact" name="contact_contact" autocomplete="email" required placeholder="jane@example.com or 07xxx xxxxxx" style="font-size:16px" />
            </div>

            <div class="form-field">
              <label for="contact_service">Service of interest</label>
              <select id="contact_service" name="contact_service" style="font-size:16px">
                <option value="">— Select a service (optional) —</option>
                <?php foreach ($_services as $svc): ?>
                  <option value="<?= htmlspecialchars((string) ($svc['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars((string) ($svc['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-field">
              <label for="contact_date">Preferred date</label>
              <input type="text" id="contact_date" name="contact_date" placeholder="e.g. June 2026" style="font-size:16px" />
            </div>

            <div class="form-field">
              <label for="contact_message">Message <span aria-hidden="true">*</span></label>
              <textarea id="contact_message" name="contact_message" rows="5" required placeholder="Tell me about your project or event..." style="font-size:16px"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send Enquiry</button>
          </form>
        </div>
        <?php endif; ?>

      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <div class="footer-brand">
        <a class="brand" href="./" data-brand-name-footer><?= $brandName ?></a>
        <p class="muted" data-tagline-footer></p>
        <p class="muted footer-hours" data-opening-hours></p>
      </div>
      <nav class="footer-nav" aria-label="Footer navigation"><ul data-footer-nav></ul></nav>
      <div class="footer-social" data-footer-social></div>
    </div>
    <div class="container footer-bottom">
      <p class="muted" data-copyright></p>
      <a href="./privacy" class="footer-privacy-link muted">Privacy &amp; Cookies</a>
    </div>
  </footer>

  <div class="mobile-booking-bar" id="mobile-booking-bar" aria-hidden="true">
    <a class="mbb-btn mbb-call" data-mbb-call href="#" aria-label="Call us">
      <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
      Call
    </a>
    <a class="mbb-btn mbb-book" href="./contact">
      <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
      Book
    </a>
    <button class="mbb-dismiss" id="mbb-dismiss" aria-label="Dismiss">&times;</button>
  </div>
  <div class="cookie-banner" id="cookie-banner" role="dialog" aria-labelledby="cookie-title" aria-hidden="true">
    <p id="cookie-title">We use essential cookies to make this site work. <a href="./privacy">Learn more</a></p>
    <div class="cookie-actions">
      <button class="btn btn-primary btn-sm" id="cookie-accept">Accept</button>
      <button class="btn btn-secondary btn-sm" id="cookie-reject">Essential only</button>
    </div>
  </div>
  <script src="./assets/js/main.js?v=<?= urlencode((string) @filemtime(__DIR__ . '/assets/js/main.js')) ?>" defer></script>
</body>
</html>

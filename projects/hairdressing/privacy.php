<?php
$page = 'home';
require_once __DIR__ . '/inc/meta.php';
$metaTitle = htmlspecialchars('Privacy &amp; Cookies | ' . strip_tags($brandName));
$metaDesc  = 'Privacy and cookie policy for Hayley Kharsa Hair Studio.';
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $metaTitle ?></title>
  <meta name="description" content="<?= $metaDesc ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600;700&family=Raleway:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/main.css?v=<?= urlencode((string) @filemtime(__DIR__ . '/assets/css/main.css')) ?>" />
</head>
<body data-page="privacy">
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
        <h1>Privacy &amp; Cookies</h1>
      </div>
    </section>

    <section>
      <div class="container prose">
        <h2>Who we are</h2>
        <p>This website is operated by Hayley Kharsa Hair Studio. If you have any questions about this policy, please contact us via the <a href="./contact">contact page</a>.</p>

        <h2>What data we collect</h2>
        <p>When you submit the booking enquiry form, we collect: your name, contact details (email or phone number), your message, and any other information you choose to provide. This data is used solely to respond to your enquiry and is not shared with third parties.</p>

        <h2>Cookies</h2>
        <p>This site uses essential session cookies to maintain your preferences (such as cookie consent). No analytics, tracking, or advertising cookies are used.</p>
        <p>Essential cookies cannot be disabled as they are required for the site to function. You can clear cookies at any time via your browser settings.</p>

        <h2>Your rights</h2>
        <p>Under UK GDPR you have the right to access, correct, or delete personal data we hold about you. To exercise these rights, please contact us via the <a href="./contact">contact page</a>.</p>

        <h2>Changes to this policy</h2>
        <p>This policy may be updated from time to time. The date of the last update is shown below.</p>
        <p class="muted"><small>Last updated: April 2026</small></p>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <div class="footer-brand">
        <a class="brand" href="./" data-brand-name-footer><?= $brandName ?></a>
        <p class="muted" data-tagline-footer></p>
      </div>
      <nav class="footer-nav" aria-label="Footer navigation"><ul data-footer-nav></ul></nav>
      <div class="footer-social" data-footer-social></div>
    </div>
    <div class="container footer-bottom">
      <p class="muted" data-copyright></p>
      <a href="./privacy" class="footer-privacy-link muted">Privacy &amp; Cookies</a>
    </div>
  </footer>
  <script src="./assets/js/main.js?v=<?= urlencode((string) @filemtime(__DIR__ . '/assets/js/main.js')) ?>" defer></script>
</body>
</html>

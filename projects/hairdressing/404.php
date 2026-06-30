<?php
http_response_code(404);
$page = 'home';
require_once __DIR__ . '/inc/meta.php';
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Page Not Found | <?= $brandName ?></title>
  <meta name="robots" content="noindex" />
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600;700&family=Raleway:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/main.css?v=<?= urlencode((string) @filemtime(__DIR__ . '/assets/css/main.css')) ?>" />
</head>
<body data-page="error">
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
    <section class="page-hero page-hero--404">
      <div class="container" style="text-align:center;padding:5rem 1rem">
        <p class="eyebrow">404</p>
        <h1>Page Not Found</h1>
        <p class="lead muted">Sorry, the page you were looking for doesn't exist or has been moved.</p>
        <div class="cta-row" style="justify-content:center;margin-top:2rem">
          <a class="btn btn-primary" href="./">Back to Home</a>
          <a class="btn btn-secondary" href="./contact">Contact Us</a>
        </div>
        <nav class="error-nav" style="margin-top:3rem">
          <p class="muted" style="margin-bottom:.75rem">Or browse:</p>
          <ul style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center">
            <li><a href="./about">About</a></li>
            <li><a href="./services">Services</a></li>
            <li><a href="./gallery">Gallery</a></li>
            <li><a href="./experience">Experience</a></li>
            <li><a href="./testimonials">Testimonials</a></li>
            <li><a href="./contact">Contact</a></li>
          </ul>
        </nav>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-bottom">
      <p class="muted" data-copyright></p>
    </div>
  </footer>
  <script src="./assets/js/main.js?v=<?= urlencode((string) @filemtime(__DIR__ . '/assets/js/main.js')) ?>" defer></script>
</body>
</html>

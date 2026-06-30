/* Hayley Kharsa Hair Studio — main.js */
(function () {
  'use strict';

  var CONTENT_PATH = './content/site-content.json';
  var _content = null;

  // ─── DOM helpers ────────────────────────────────────────────────────────────
  function setText(sel, val) {
    var el = document.querySelector(sel);
    if (el) el.textContent = val || '';
  }
  function setHtml(sel, val) {
    var el = document.querySelector(sel);
    if (el) el.innerHTML = val || '';
  }
  function setAttr(sel, attr, val) {
    var el = document.querySelector(sel);
    if (el) el.setAttribute(attr, val || '');
  }
  function all(sel) { return Array.from(document.querySelectorAll(sel)); }
  function isPdfHref(href) {
    return typeof href === 'string' && /\.pdf(?:$|[?#])/i.test(href.trim());
  }
  function applyPdfTarget(a, href) {
    if (!a || !href) return;
    if (isPdfHref(href)) {
      a.target = '_blank';
      a.rel = 'noopener noreferrer';
    } else {
      a.removeAttribute('target');
      if ((a.getAttribute('rel') || '').toLowerCase() === 'noopener noreferrer') a.removeAttribute('rel');
    }
  }
  function enforcePdfLinksNewTab(root) {
    (root || document).querySelectorAll('a[href]').forEach(function (a) {
      applyPdfTarget(a, a.getAttribute('href') || '');
    });
  }

  // ─── SVG social icons ────────────────────────────────────────────────────────
  var SOCIAL_ICONS = {
    linkedin:  '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.36V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.36-1.85 3.59 0 4.26 2.36 4.26 5.44v6.3zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9H7.12v11.45z"/></svg>',
    instagram: '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>',
    facebook:  '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>',
    tiktok:    '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.3 6.3 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.13 8.13 0 0 0 4.78 1.53V6.77a4.85 4.85 0 0 1-1.01-.08z"/></svg>',
    youtube:   '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>',
    pinterest: '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/></svg>',
    twitter:   '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.259 5.63 5.905-5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>'
  };

  // ─── Social links renderer ───────────────────────────────────────────────────
  function renderSocial(sel, links) {
    var containers = all(sel);
    if (!containers.length || !Array.isArray(links)) return;
    containers.forEach(function (root) {
      root.innerHTML = '';
      links.forEach(function (item) {
        if (!item.url) return;
        var a = document.createElement('a');
        a.href = item.url;
        a.target = '_blank';
        a.rel = 'noopener noreferrer';
        a.className = 'social-link';
        a.setAttribute('aria-label', item.label || item.platform);
        var icon = SOCIAL_ICONS[item.platform] || '';
        a.innerHTML = icon + '<span class="visually-hidden">' + (item.label || item.platform) + '</span>';
        root.appendChild(a);
      });
    });
  }

  // ─── Navigation ──────────────────────────────────────────────────────────────
  function renderNav(items) {
    var defaultItems = [
      { label: 'About', url: './about' },
      { label: 'Services', url: './services' },
      { label: 'Gallery', url: './gallery' },
      { label: 'Experience', url: './experience' },
      { label: 'Contact', url: './contact' }
    ];
    var sourceItems = Array.isArray(items) && items.length ? items : defaultItems;
    var currentPath = window.location.pathname.replace(/\/$/, '').split('/').pop() || 'index';
    all('[data-nav-list]').forEach(function (list) {
      list.innerHTML = '';
      sourceItems.forEach(function (item) {
        var li = document.createElement('li');
        li.className = 'nav-item';
        var a = document.createElement('a');
        a.className = 'nav-link';
        var href = (item && item.url ? String(item.url) : '').trim();
        if (!href) href = '#';
        if (/^(about|services|gallery|testimonials|experience|contact|privacy)$/i.test(href)) href = './' + href.toLowerCase();
        if (href === '/' || href === '/index' || href === '/index.php') href = './';
        a.href = href;
        applyPdfTarget(a, href);
        a.textContent = item.label || '';
        var pageSlug = href.replace(/^\.\//, '').replace(/\/$/, '').replace(/\.php$/, '');
        if (pageSlug === currentPath || (currentPath === '' && pageSlug === 'index')) {
          a.classList.add('is-active');
          a.setAttribute('aria-current', 'page');
        }
        li.appendChild(a);
        list.appendChild(li);
      });
    });
    // Footer nav
    all('[data-footer-nav]').forEach(function (list) {
      list.innerHTML = '';
      sourceItems.forEach(function (item) {
        var li = document.createElement('li');
        var a = document.createElement('a');
        var href = (item && item.url ? String(item.url) : '').trim();
        if (!href) href = '#';
        if (/^(about|services|gallery|testimonials|experience|contact|privacy)$/i.test(href)) href = './' + href.toLowerCase();
        if (href === '/' || href === '/index' || href === '/index.php') href = './';
        a.href = href;
        applyPdfTarget(a, href);
        a.textContent = item.label || '';
        li.appendChild(a);
        list.appendChild(li);
      });
    });
  }

  // ─── Card factories ───────────────────────────────────────────────────────────
  function createServiceCard(item, showBookCta) {
    var art = document.createElement('article');
    art.className = 'service-card';
    var img = document.createElement('img');
    img.loading = 'lazy';
    img.src = item.image || '';
    img.alt = item.alt || '';
    img.onerror = handleImgError;
    var h3 = document.createElement('h3');
    h3.textContent = item.title || '';
    var p = document.createElement('p');
    p.innerHTML = item.summary || '';
    art.appendChild(img);
    art.appendChild(h3);
    art.appendChild(p);
    if (showBookCta !== false && item.bookCtaUrl) {
      var a = document.createElement('a');
      a.className = 'btn btn-primary btn-sm service-book-cta';
      a.href = item.bookCtaUrl;
      applyPdfTarget(a, item.bookCtaUrl);
      a.textContent = item.bookCtaLabel || 'Book';
      art.appendChild(a);
    }
    return art;
  }

  function createGalleryCard(item, index, allItems, openLightbox) {
    var fig = document.createElement('figure');
    fig.className = 'gallery-card';
    var img = document.createElement('img');
    img.loading = 'lazy';
    img.src = item.image || '';
    img.alt = item.alt || '';
    img.onerror = handleImgError;
    if (typeof openLightbox === 'function') {
      img.style.cursor = 'pointer';
      img.addEventListener('click', function () { openLightbox(index, allItems); });
      fig.style.cursor = 'pointer';
      fig.addEventListener('click', function () { openLightbox(index, allItems); });
    }
    fig.appendChild(img);
    if (item.title) {
      var cap = document.createElement('figcaption');
      cap.textContent = item.title;
      fig.appendChild(cap);
    }
    return fig;
  }

  function createQuoteCard(item) {
    var bq = document.createElement('blockquote');
    bq.className = 'quote-card';
    var p = document.createElement('p');
    p.textContent = item.quote || '';
    var cite = document.createElement('cite');
    cite.textContent = item.name + (item.role ? ', ' + item.role : '');
    bq.appendChild(p);
    bq.appendChild(cite);
    return bq;
  }

  function createTimelineCard(item) {
    var art = document.createElement('article');
    art.className = 'timeline-card';
    art.innerHTML =
      '<p class="timeline-period">' + (item.period || '') + '</p>' +
      '<h3>' + (item.role || '') + '</h3>' +
      (item.show ? '<p class="timeline-show">' + item.show + '</p>' : '') +
      '<p class="muted">' + [item.company, item.venue].filter(Boolean).join(' &mdash; ') + '</p>';
    return art;
  }

  function createEducationCard(item) {
    var art = document.createElement('article');
    art.className = 'timeline-card';
    art.innerHTML =
      '<p class="timeline-period">' + (item.period || '') + '</p>' +
      '<h3>' + (item.school || '') + '</h3>' +
      '<p class="muted">' + (item.qualification || '') + '</p>';
    return art;
  }

  // ─── Metrics ─────────────────────────────────────────────────────────────────
  function renderMetrics(items) {
    all('[data-about-metrics]').forEach(function (root) {
      root.innerHTML = '';
      (items || []).forEach(function (m) {
        var d = document.createElement('div');
        d.className = 'metric-chip';
        d.innerHTML = '<strong>' + (m.value || '') + '</strong><span>' + (m.label || '') + '</span>';
        root.appendChild(d);
      });
    });
  }

  // ─── Image 404 fallback ───────────────────────────────────────────────────────
  function handleImgError() {
    var pool = window.HK_FALLBACK_IMAGES;
    if (!pool || !pool.length) return;
    var idx = Math.floor(Math.random() * pool.length);
    if (this.src !== pool[idx]) this.src = pool[idx];
  }
  function installImgFallback() {
    document.addEventListener('error', function (e) {
      if (e.target && e.target.tagName === 'IMG') handleImgError.call(e.target);
    }, true);
  }

  // ─── Shared footer / common content ──────────────────────────────────────────
  function hydrateCommon(c) {
    var brand = c.site && c.site.brandName ? c.site.brandName : 'Hayley Kharsa Hair Studio';
    all('[data-brand-name], [data-brand-name-footer]').forEach(function (el) {
      el.textContent = brand;
    });
    setText('[data-tagline]', c.site && c.site.tagline);
    setText('[data-tagline-footer]', c.site && c.site.tagline);
    setText('[data-opening-hours]', c.site && c.site.openingHours);
    setText('[data-copyright]', c.contact && c.contact.copyright);
    renderNav(c.navigation || []);
    renderSocial('[data-social-links], [data-footer-social]', c.site && c.site.socialLinks || []);
    // Mobile booking bar: set call href
    var mbbCall = document.querySelector('[data-mbb-call]');
    if (mbbCall && c.contact && c.contact.phone) mbbCall.href = 'tel:' + c.contact.phone;
  }

  // ─── Home page hydration ──────────────────────────────────────────────────────
  function hydrateHome(c) {
    document.title = (c.pages && c.pages.home && c.pages.home.metaTitle) || c.site && c.site.brandName || 'Hayley Kharsa';
    hydrateCommon(c);

    // Hero
    setText('[data-hero-eyebrow]', c.hero && c.hero.eyebrow);
    setText('[data-hero-heading]', c.hero && c.hero.heading);
    setHtml('[data-hero-text]', c.hero && c.hero.text);
    var heroImg = document.querySelector('[data-hero-image]');
    if (heroImg && c.hero && c.hero.image) { heroImg.src = c.hero.image.url || ''; heroImg.alt = c.hero.image.alt || ''; }
    var hp = document.querySelector('[data-hero-primary]');
    if (hp) {
      var heroPrimaryUrl = c.hero && c.hero.primaryCtaUrl || './contact';
      hp.textContent = c.hero && c.hero.primaryCtaLabel || 'Book';
      hp.href = heroPrimaryUrl;
      applyPdfTarget(hp, heroPrimaryUrl);
    }
    var hs = document.querySelector('[data-hero-secondary]');
    if (hs) {
      var heroSecondaryUrl = c.hero && c.hero.secondaryCtaUrl || './experience';
      hs.textContent = c.hero && c.hero.secondaryCtaLabel || 'Learn more';
      hs.href = heroSecondaryUrl;
      applyPdfTarget(hs, heroSecondaryUrl);
    }

    // About teaser
    setText('[data-about-heading]', c.about && c.about.heading);
    setText('[data-about-summary]', c.about && c.about.homeSummary);
    renderMetrics(c.about && c.about.metrics || []);

    // Services preview (first 3)
    var spRoot = document.querySelector('[data-services-preview]');
    if (spRoot) {
      spRoot.innerHTML = '';
      (c.services || []).slice(0, 3).forEach(function (s) {
        spRoot.appendChild(createServiceCard(s, true));
      });
    }

    // Gallery preview (first 6)
    var gpRoot = document.querySelector('[data-gallery-preview]');
    if (gpRoot) {
      gpRoot.innerHTML = '';
      (c.gallery || []).slice(0, 6).forEach(function (g, i, arr) {
        gpRoot.appendChild(createGalleryCard(g, i, arr.slice(0, 6), openLightbox));
      });
    }

    // Testimonials preview (first 3)
    var tpRoot = document.querySelector('[data-testimonials-preview]');
    if (tpRoot) {
      tpRoot.innerHTML = '';
      var tItems = (c.testimonials || []).slice(0, 3);
      if (tItems.length === 0) {
        tpRoot.closest('section') && (tpRoot.closest('section').style.display = 'none');
      } else {
        tItems.forEach(function (t) { tpRoot.appendChild(createQuoteCard(t)); });
      }
    }

    // Experience preview (first 3 jobs)
    var epRoot = document.querySelector('[data-experience-preview]');
    if (epRoot) {
      epRoot.innerHTML = '';
      (c.experiencePage && c.experiencePage.jobs || []).slice(0, 3).forEach(function (j) {
        epRoot.appendChild(createTimelineCard(j));
      });
    }

    // Contact strip
    setText('[data-contact-heading]', c.contact && c.contact.heading);
    setText('[data-contact-body]', c.contact && c.contact.body);
    var phone = c.contact && c.contact.phone;
    var email = c.contact && c.contact.email;
    setHtml('[data-contact-phone]', phone ? '<strong>' + (c.contact.phoneLabel || 'Phone') + ':</strong> <a href="tel:' + phone + '">' + phone + '</a>' : '');
    setHtml('[data-contact-email]', email ? '<strong>' + (c.contact.emailLabel || 'Email') + ':</strong> <a href="mailto:' + email + '">' + email + '</a>' : '');
    enforcePdfLinksNewTab();
  }

  // ─── About page ──────────────────────────────────────────────────────────────
  function hydrateAbout(c) {
    document.title = (c.pages && c.pages.about && c.pages.about.metaTitle) || 'About | Hayley Kharsa';
    hydrateCommon(c);
    setText('[data-about-heading]', c.about && c.about.heading);
    var bodyEl = document.querySelector('[data-about-body]');
    if (bodyEl) bodyEl.innerHTML = (c.about && c.about.body) || '';
    renderMetrics(c.about && c.about.metrics || []);
    enforcePdfLinksNewTab();
  }

  // ─── Services page ───────────────────────────────────────────────────────────
  function hydrateServices(c) {
    document.title = (c.pages && c.pages.services && c.pages.services.metaTitle) || 'Services | Hayley Kharsa';
    hydrateCommon(c);
    var root = document.querySelector('[data-services-full]');
    if (root) {
      root.innerHTML = '';
      (c.services || []).forEach(function (s) { root.appendChild(createServiceCard(s, true)); });
    }
    enforcePdfLinksNewTab();
  }

  // ─── Gallery page ─────────────────────────────────────────────────────────────
  function hydrateGallery(c) {
    document.title = (c.pages && c.pages.gallery && c.pages.gallery.metaTitle) || 'Gallery | Hayley Kharsa';
    hydrateCommon(c);
    var items = c.gallery || [];
    var root = document.querySelector('[data-gallery-full]');
    if (root) {
      root.innerHTML = '';
      items.forEach(function (g, i) {
        root.appendChild(createGalleryCard(g, i, items, openLightbox));
      });
    }
    enforcePdfLinksNewTab();
  }

  // ─── Testimonials page ───────────────────────────────────────────────────────
  function hydrateTestimonials(c) {
    document.title = (c.pages && c.pages.testimonials && c.pages.testimonials.metaTitle) || 'Testimonials | Hayley Kharsa';
    hydrateCommon(c);
    var root = document.querySelector('[data-testimonials-full]');
    var empty = document.getElementById('testimonials-empty');
    var items = c.testimonials || [];
    if (root) {
      root.innerHTML = '';
      if (items.length === 0) {
        if (empty) empty.style.display = '';
      } else {
        if (empty) empty.style.display = 'none';
        items.forEach(function (t) { root.appendChild(createQuoteCard(t)); });
      }
    }
    enforcePdfLinksNewTab();
  }

  // ─── Contact page ─────────────────────────────────────────────────────────────
  function hydrateContact(c) {
    document.title = (c.pages && c.pages.contact && c.pages.contact.metaTitle) || 'Contact | Hayley Kharsa';
    hydrateCommon(c);
    setText('[data-contact-heading]', c.contact && c.contact.heading);
    setText('[data-contact-body]', c.contact && c.contact.body);
    var phone = c.contact && c.contact.phone;
    var email = c.contact && c.contact.email;
    var hours = c.site && c.site.openingHours;
    setHtml('[data-contact-phone]', phone ? '<strong>' + (c.contact.phoneLabel || 'Phone') + ':</strong> <a href="tel:' + phone + '">' + phone + '</a>' : '');
    setHtml('[data-contact-email]', email ? '<strong>' + (c.contact.emailLabel || 'Email') + ':</strong> <a href="mailto:' + email + '">' + email + '</a>' : '');
    setHtml('[data-opening-hours]', hours ? '<strong>Hours:</strong> ' + hours : '');
    enforcePdfLinksNewTab();
  }

  // ─── Experience page ─────────────────────────────────────────────────────────
  function hydrateExperience(c) {
    document.title = (c.pages && c.pages.experience && c.pages.experience.metaTitle) || 'Experience | Hayley Kharsa';
    hydrateCommon(c);
    setText('[data-experience-heading]', c.experiencePage && c.experiencePage.heroHeading);
    setText('[data-experience-text]', c.experiencePage && c.experiencePage.heroText);
    var jobRoot = document.querySelector('[data-jobs-list]');
    if (jobRoot) {
      jobRoot.innerHTML = '';
      (c.experiencePage && c.experiencePage.jobs || []).forEach(function (j) {
        jobRoot.appendChild(createTimelineCard(j));
      });
    }
    var eduRoot = document.querySelector('[data-education-list]');
    if (eduRoot) {
      eduRoot.innerHTML = '';
      (c.experiencePage && c.experiencePage.education || []).forEach(function (e) {
        eduRoot.appendChild(createEducationCard(e));
      });
    }
    var phone = c.contact && c.contact.phone;
    var email = c.contact && c.contact.email;
    setHtml('[data-contact-phone]', phone ? '<strong>' + (c.contact && c.contact.phoneLabel || 'Phone') + ':</strong> <a href="tel:' + phone + '">' + phone + '</a>' : '');
    setHtml('[data-contact-email]', email ? '<strong>' + (c.contact && c.contact.emailLabel || 'Email') + ':</strong> <a href="mailto:' + email + '">' + email + '</a>' : '');
    setText('[data-contact-heading]', c.contact && c.contact.heading);
    enforcePdfLinksNewTab();
  }

  // ─── Simple page (privacy, error, etc.) ─────────────────────────────────────
  function hydrateSimple(c) {
    hydrateCommon(c);
    enforcePdfLinksNewTab();
  }

  // ─── Lightbox ────────────────────────────────────────────────────────────────
  var _lbItems = [];
  var _lbIdx   = 0;

  function openLightbox(index, items) {
    _lbItems = items || [];
    _lbIdx   = index;
    showLightboxItem();
    var lb = document.getElementById('lightbox');
    if (lb) { lb.removeAttribute('aria-hidden'); lb.classList.add('is-open'); document.body.classList.add('lightbox-open'); }
  }

  function closeLightbox() {
    var lb = document.getElementById('lightbox');
    if (lb) { lb.setAttribute('aria-hidden', 'true'); lb.classList.remove('is-open'); document.body.classList.remove('lightbox-open'); }
  }

  function showLightboxItem() {
    var item = _lbItems[_lbIdx];
    if (!item) return;
    var img = document.getElementById('lightbox-img');
    var cap = document.getElementById('lightbox-caption');
    if (img) { img.src = item.image || ''; img.alt = item.alt || ''; }
    if (cap) cap.textContent = item.title || '';
  }

  function lightboxPrev() { if (_lbItems.length < 2) return; _lbIdx = (_lbIdx - 1 + _lbItems.length) % _lbItems.length; showLightboxItem(); }
  function lightboxNext() { if (_lbItems.length < 2) return; _lbIdx = (_lbIdx + 1) % _lbItems.length; showLightboxItem(); }

  function initLightbox() {
    var lb = document.getElementById('lightbox');
    if (!lb) return;
    document.getElementById('lightbox-close') && document.getElementById('lightbox-close').addEventListener('click', closeLightbox);
    document.getElementById('lightbox-prev')  && document.getElementById('lightbox-prev').addEventListener('click', lightboxPrev);
    document.getElementById('lightbox-next')  && document.getElementById('lightbox-next').addEventListener('click', lightboxNext);
    lb.addEventListener('click', function (e) { if (e.target === lb) closeLightbox(); });

    // Keyboard
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('is-open')) return;
      if (e.key === 'Escape') closeLightbox();
      if (e.key === 'ArrowLeft')  lightboxPrev();
      if (e.key === 'ArrowRight') lightboxNext();
    });

    // Touch swipe
    var _tx = 0;
    lb.addEventListener('touchstart', function (e) { _tx = e.changedTouches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
      var dx = e.changedTouches[0].clientX - _tx;
      if (Math.abs(dx) > 50) { if (dx < 0) lightboxNext(); else lightboxPrev(); }
    });
  }

  // ─── Mobile nav drawer ───────────────────────────────────────────────────────
  function initMobileNav() {
    var toggle = document.querySelector('.nav-toggle');
    var nav    = document.getElementById('primary-nav');
    var headerBrand = document.querySelector('.nav-wrap .brand');
    if (!toggle || !nav) return;

    function closeNav() {
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Open navigation');
      toggle.classList.remove('is-active');
      nav.classList.remove('is-open');
      document.body.classList.remove('nav-open');
    }

    function syncMode() {
      if (!window.matchMedia('(max-width: 768px)').matches) closeNav();
    }

    // Build mobile nav header (brand + close) once.
    if (!nav.querySelector('.mobile-nav-head')) {
      var head = document.createElement('div');
      head.className = 'mobile-nav-head';
      if (headerBrand) {
        var brandLink = document.createElement('a');
        brandLink.className = 'mobile-nav-brand';
        brandLink.href = headerBrand.getAttribute('href') || './';
        brandLink.textContent = headerBrand.textContent || '';
        head.appendChild(brandLink);
      }
      var closeBtn = document.createElement('button');
      closeBtn.type = 'button';
      closeBtn.className = 'mobile-nav-close';
      closeBtn.setAttribute('aria-label', 'Close navigation');
      closeBtn.innerHTML = '&times;';
      closeBtn.addEventListener('click', closeNav);
      head.appendChild(closeBtn);
      nav.insertBefore(head, nav.firstChild);
    }

    toggle.addEventListener('click', function () {
      var expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!expanded));
      toggle.setAttribute('aria-label', expanded ? 'Open navigation' : 'Close navigation');
      toggle.classList.toggle('is-active', !expanded);
      nav.classList.toggle('is-open', !expanded);
      document.body.classList.toggle('nav-open', !expanded);
      if (!expanded) {
        var list = nav.querySelector('[data-nav-list]');
        if (!list) {
          list = document.createElement('ul');
          list.setAttribute('data-nav-list', '');
          nav.appendChild(list);
        }
        if (!list.children.length) renderNav(_content && _content.navigation ? _content.navigation : []);
      }
    });
    // Close on link click
    nav.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') {
        closeNav();
      }
    });
    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!nav.contains(e.target) && !toggle.contains(e.target) && nav.classList.contains('is-open')) {
        closeNav();
      }
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) closeNav();
    });
    window.addEventListener('resize', syncMode);
    syncMode();
  }

  // ─── Mobile booking bar ───────────────────────────────────────────────────────
  function updateMobileBarOffset() {
    var bar = document.getElementById('mobile-booking-bar');
    if (!bar) return;
    var banner = document.getElementById('cookie-banner');
    var bannerVisible = !!(banner && banner.classList.contains('is-visible') && banner.style.display !== 'none');
    bar.classList.toggle('is-offset-for-cookie', bannerVisible);
  }

  function initMobileBar() {
    var bar = document.getElementById('mobile-booking-bar');
    if (!bar) return;
    if (sessionStorage.getItem('hk_mbb_dismissed') === '1') {
      bar.style.display = 'none';
      document.body.classList.remove('has-mobile-booking-bar');
      return;
    }
    bar.removeAttribute('aria-hidden');
    document.body.classList.add('has-mobile-booking-bar');
    updateMobileBarOffset();
    var dismiss = document.getElementById('mbb-dismiss');
    if (dismiss) dismiss.addEventListener('click', function () {
      bar.style.display = 'none';
      document.body.classList.remove('has-mobile-booking-bar');
      sessionStorage.setItem('hk_mbb_dismissed', '1');
    });
  }

  // ─── Cookie banner ────────────────────────────────────────────────────────────
  function initCookieBanner() {
    var banner = document.getElementById('cookie-banner');
    if (!banner) return;
    var consent = getCookie('hk_cookie_consent');
    if (consent) return;
    banner.removeAttribute('aria-hidden');
    banner.classList.add('is-visible');
    updateMobileBarOffset();
    var accept = document.getElementById('cookie-accept');
    var reject = document.getElementById('cookie-reject');
    function dismiss(val) {
      setCookie('hk_cookie_consent', val, 365);
      banner.classList.remove('is-visible');
      updateMobileBarOffset();
      setTimeout(function () { banner.style.display = 'none'; }, 300);
    }
    if (accept) accept.addEventListener('click', function () { dismiss('accepted'); });
    if (reject) reject.addEventListener('click', function () { dismiss('rejected'); });
  }

  function getCookie(name) {
    var m = document.cookie.match('(?:^|;)\\s*' + name + '=([^;]*)');
    return m ? decodeURIComponent(m[1]) : null;
  }
  function setCookie(name, val, days) {
    var d = new Date();
    d.setTime(d.getTime() + days * 86400000);
    document.cookie = name + '=' + encodeURIComponent(val) + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
  }

  // ─── Main init ────────────────────────────────────────────────────────────────
  async function init() {
    installImgFallback();
    initMobileNav();
    // Ensure nav items are visible immediately, even if JSON load fails.
    renderNav([]);
    initMobileBar();
    initCookieBanner();
    initLightbox();

    try {
      var r = await fetch(CONTENT_PATH, { cache: 'no-store' });
      if (!r.ok) throw new Error('Failed to load content');
      var c = await r.json();
      _content = c;

      var page = (document.body.dataset.page || 'home').toLowerCase();
      switch (page) {
        case 'home':         hydrateHome(c);         break;
        case 'about':        hydrateAbout(c);        break;
        case 'services':     hydrateServices(c);     break;
        case 'gallery':      hydrateGallery(c);      break;
        case 'testimonials': hydrateTestimonials(c); break;
        case 'contact':      hydrateContact(c);      break;
        case 'experience':   hydrateExperience(c);   break;
        default:             hydrateSimple(c);        break;
      }
    } catch (e) {
      console.error('Hairdressing site: could not load content JSON', e);
      renderNav([]);
    }
  }

  document.addEventListener('DOMContentLoaded', init);
})();

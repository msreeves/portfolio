// ─── TinyMCE ──────────────────────────────────────────────────────────────────
tinymce.init({
  selector: 'textarea.cms-wysiwyg',
  plugins: 'link lists autolink charmap code fullscreen searchreplace autoresize',
  toolbar: 'undo redo | bold italic underline | bullist numlist | link | code fullscreen',
  menubar: false,
  branding: false,
  resize: false,
  min_height: 180,
  link_assume_external_targets: 'https',
  link_default_protocol: 'https',
  default_link_target: '_blank',
  link_target_list: [
    { title: 'Current window', value: '' },
    { title: 'New window', value: '_blank' }
  ],
  file_picker_types: 'file',
  file_picker_callback: function (cb, value, meta) {
    if (meta && meta.filetype === 'file') {
      hkOpenPdfPickerForTinyMce(cb);
    }
  },
  valid_elements: 'p,br,strong/b,em/i,u,a[href|target|rel],ul,ol,li,h2,h3,h4,blockquote,span[class],small',
  setup: function(ed) {
    ed.on('change', function() { ed.save(); });
    ed.on('BeforeSetContent', function(e) {
      if (!e || !e.content) return;
      e.content = e.content.replace(/href="([^"]+)"/gi, function(all, href) {
        return 'href="' + hkNormalizeUrlValue(href) + '"';
      });
    });
  }
});
document.getElementById('cms-form').addEventListener('submit', function() {
  if (typeof tinymce !== 'undefined') tinymce.triggerSave();
  document.querySelectorAll('textarea.cms-wysiwyg').forEach(function (ta) {
    ta.value = ta.value.replace(/href=(["'])(.*?)\1/gi, function (all, quote, href) {
      return 'href=' + quote + hkNormalizeUrlValue(href) + quote;
    });
  });
});

// ─── Repeater helpers ─────────────────────────────────────────────────────────
function cloneTemplate(tplId, containerId) {
  var tpl = document.getElementById(tplId);
  var con = document.getElementById(containerId);
  if (!tpl || !con) return null;
  var clone = tpl.content.cloneNode(true);
  con.appendChild(clone);
  if (window.hkMediaPicker) window.hkMediaPicker.syncPreviews(con.lastElementChild);
  hkBindUrlFields(con.lastElementChild);
  return con.lastElementChild;
}
function addNavRow()         { cloneTemplate('nav-row-tpl','nav-rows'); }
function addMetricRow()      { cloneTemplate('metric-row-tpl','metric-rows'); }
function addServiceRow()     { cloneTemplate('service-row-tpl','service-rows'); }
function addTestimonialRow() { cloneTemplate('testimonial-row-tpl','testimonial-rows'); }
function addJobRow()         { cloneTemplate('job-row-tpl','job-rows'); }
function addEduRow()         { cloneTemplate('edu-row-tpl','edu-rows'); }

function hkNormalizeUrlValue(raw) {
  var v = (raw || '').trim().replace(/[›»\s]+$/g, '');
  if (!v) return v;
  var stripped = v.toLowerCase().replace(/^https?:\/\/[^/]+/i, '').replace(/^\.?\/+/, '').replace(/^\/+/, '').replace(/\/+$/, '');
  var internal = ['about', 'services', 'gallery', 'testimonials', 'experience', 'contact', 'privacy'];
  if (stripped === '' || stripped === 'home' || stripped === 'index' || stripped === 'index.php') return './';
  if (internal.indexOf(stripped) !== -1) return './' + stripped;
  var lower = v.toLowerCase();
  if (
    lower.indexOf('mailto:') === 0 ||
    lower.indexOf('tel:') === 0 ||
    v.indexOf('./') === 0 ||
    v.indexOf('../') === 0 ||
    v.indexOf('/') === 0 ||
    v.indexOf('#') === 0
  ) {
    return v;
  }
  if (lower.indexOf('javascript:') === 0) return '';
  var domainLike = /^(?:www\.)?[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?(?:\.[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?)+(?:[/?#].*)?$/i.test(v);
  if (!/^[a-z][a-z0-9+\-.]*:\/\//i.test(v) && domainLike) v = 'https://' + v;
  if (/^https?:\/\//i.test(v)) {
    try {
      var u = new URL(v);
      var host = (u.hostname || '').toLowerCase();
      var isIp = /^(\d{1,3}\.){3}\d{1,3}$/.test(host) || host.indexOf(':') !== -1;
      if (host && host !== 'localhost' && !isIp && host.indexOf('www.') !== 0) u.hostname = 'www.' + host;
      return u.toString();
    } catch (e) {
      return v;
    }
  }
  return v;
}

function hkOpenUrlPopup(input) {
  if (!input) return;
  hkUrlDialogOpen(input);
}

function hkGetUrlCtaPresets(input) {
  var key = ((input.name || input.id || '') + '').toLowerCase();
  var isExternalOnly = key.indexOf('social_') === 0 || key.indexOf('contact_map') !== -1 || key.indexOf('job_image') !== -1;
  if (isExternalOnly) {
    return [
      { label: 'HTTPS', value: 'https://' }
    ];
  }
  return [
    { label: 'Contact', value: './contact' },
    { label: 'Services', value: './services' },
    { label: 'Gallery', value: './gallery' },
    { label: 'Experience', value: './experience' },
    { label: 'About', value: './about' },
    { label: 'Home', value: './' }
  ];
}

function hkEnsureUrlCtaUi(input) {
  if (!input || input.dataset.urlUiBound === '1') return;
  input.dataset.urlUiBound = '1';
  input.classList.add('is-cta-input');
  input.readOnly = true;
  input.title = 'Click to update URL';

  input.addEventListener('click', function () { hkOpenUrlPopup(input); });
  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      hkOpenUrlPopup(input);
    }
  });

  var wrap = document.createElement('div');
  wrap.className = 'url-cta-wrap';

  var select = document.createElement('select');
  select.className = 'url-cta-select';
  select.setAttribute('aria-label', 'Quick URL links');
  var placeholder = document.createElement('option');
  placeholder.value = '';
  placeholder.textContent = 'Quick link...';
  placeholder.selected = true;
  select.appendChild(placeholder);
  var pdfOption = document.createElement('option');
  pdfOption.value = '__pdf__';
  pdfOption.textContent = 'PDF (choose/upload)';
  select.appendChild(pdfOption);
  hkGetUrlCtaPresets(input).forEach(function (preset) {
    var opt = document.createElement('option');
    opt.value = preset.value;
    opt.textContent = preset.label;
    select.appendChild(opt);
  });
  select.addEventListener('change', function () {
    if (!select.value) return;
    if (select.value === '__pdf__') {
      hkOpenPdfPickerForInput(input);
      return;
    }
    input.value = hkNormalizeUrlValue(select.value);
    input.dispatchEvent(new Event('blur', { bubbles: true }));
    select.value = '';
  });
  wrap.appendChild(select);

  var pdfBtn = document.createElement('button');
  pdfBtn.type = 'button';
  pdfBtn.className = 'url-cta-btn';
  pdfBtn.textContent = 'Choose PDF';
  pdfBtn.addEventListener('click', function () { hkOpenPdfPickerForInput(input); });
  wrap.appendChild(pdfBtn);

  var clearBtn = document.createElement('button');
  clearBtn.type = 'button';
  clearBtn.className = 'url-cta-btn';
  clearBtn.textContent = 'Clear';
  clearBtn.addEventListener('click', function () { input.value = ''; });
  wrap.appendChild(clearBtn);

  input.insertAdjacentElement('afterend', wrap);
}

var hkUrlDialog = (function () {
  var dlg = null;
  var inputEl = null;
  var sourceInput = null;
  var cancelBtn = null;
  var saveBtn = null;

  function ensure() {
    if (dlg) return;
    var html =
      '<dialog id="hk-url-dialog">' +
        '<div class="url-dialog-inner">' +
          '<div class="url-dialog-head">' +
            '<h3>Insert/Edit Link</h3>' +
            '<button type="button" class="url-dialog-close" data-url-close aria-label="Close">&times;</button>' +
          '</div>' +
          '<div class="url-dialog-body">' +
            '<div class="field"><label>URL</label><input type="text" id="hk-url-dialog-input" autocomplete="off" spellcheck="false" /></div>' +
            '<div class="url-cta-wrap"><button type="button" class="url-cta-btn" id="hk-url-dialog-pdf-btn">Choose/Upload PDF</button></div>' +
          '</div>' +
          '<div class="url-dialog-foot">' +
            '<button type="button" class="url-dialog-btn url-dialog-btn--cancel" data-url-cancel>Cancel</button>' +
            '<button type="button" class="url-dialog-btn url-dialog-btn--save" data-url-save>Save</button>' +
          '</div>' +
        '</div>' +
      '</dialog>';
    document.body.insertAdjacentHTML('beforeend', html);
    dlg = document.getElementById('hk-url-dialog');
    inputEl = document.getElementById('hk-url-dialog-input');
    cancelBtn = dlg.querySelector('[data-url-cancel]');
    saveBtn = dlg.querySelector('[data-url-save]');
    var pdfBtn = document.getElementById('hk-url-dialog-pdf-btn');
    dlg.querySelector('[data-url-close]').addEventListener('click', close);
    cancelBtn.addEventListener('click', close);
    saveBtn.addEventListener('click', save);
    if (pdfBtn) {
      pdfBtn.addEventListener('click', function () {
        hkOpenPdfPickerForInput(inputEl);
      });
    }
    dlg.addEventListener('cancel', function (e) { e.preventDefault(); close(); });
    inputEl.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') { e.preventDefault(); save(); }
      if (e.key === 'Escape') { e.preventDefault(); close(); }
    });
  }

  function open(srcInput) {
    ensure();
    sourceInput = srcInput;
    inputEl.value = sourceInput && sourceInput.value ? sourceInput.value : '';
    if (typeof dlg.showModal === 'function') dlg.showModal(); else dlg.setAttribute('open', 'open');
    setTimeout(function () { inputEl.focus(); inputEl.select(); }, 0);
  }

  function close() {
    if (!dlg) return;
    if (typeof dlg.close === 'function') dlg.close(); else dlg.removeAttribute('open');
    sourceInput = null;
  }

  function save() {
    if (!sourceInput) return close();
    sourceInput.value = hkNormalizeUrlValue(inputEl.value || '');
    sourceInput.dispatchEvent(new Event('blur', { bubbles: true }));
    close();
  }

  return { open: open };
})();

function hkUrlDialogOpen(input) {
  hkUrlDialog.open(input);
}

// ─── PDF picker for URL fields + TinyMCE links ───────────────────────────────
var hkPdfPicker = (function () {
  var dlg = null;
  var list = [];
  var activeInput = null;
  var tinyCb = null;

  function esc(s) {
    var d = document.createElement('div');
    d.textContent = s;
    return d.innerHTML;
  }

  function getCsrf() {
    var el = document.querySelector('input[name="cms_csrf"]');
    return el ? el.value : '';
  }

  function ensureDialog() {
    if (dlg) return;
    var html =
      '<dialog id="hk-pdf-dialog">' +
      '  <div class="pdf-dialog-head">' +
      '    <h3>Choose PDF</h3>' +
      '    <button type="button" class="btn-picker-clear" data-pdf-close>Close</button>' +
      '  </div>' +
      '  <div class="pdf-dialog-body">' +
      '    <div class="pdf-toolbar">' +
      '      <input type="text" id="hk-pdf-filter" placeholder="Filter by filename..." autocomplete="off" />' +
      '      <button type="button" class="btn-picker" id="hk-pdf-upload-btn">Upload PDF</button>' +
      '      <input type="file" id="hk-pdf-upload-input" accept="application/pdf,.pdf" style="display:none" />' +
      '    </div>' +
      '    <div class="pdf-grid" id="hk-pdf-grid"></div>' +
      '  </div>' +
      '</dialog>';
    document.body.insertAdjacentHTML('beforeend', html);
    dlg = document.getElementById('hk-pdf-dialog');

    dlg.querySelector('[data-pdf-close]').addEventListener('click', close);
    dlg.addEventListener('cancel', function (e) { e.preventDefault(); close(); });
    document.getElementById('hk-pdf-filter').addEventListener('input', function (e) {
      render(e.target.value || '');
    });
    var upBtn = document.getElementById('hk-pdf-upload-btn');
    var upIn = document.getElementById('hk-pdf-upload-input');
    upBtn.addEventListener('click', function () { upIn.click(); });
    upIn.addEventListener('change', function () {
      var f = upIn.files && upIn.files[0];
      upIn.value = '';
      if (f) uploadPdf(f);
    });
  }

  function render(filter) {
    var grid = document.getElementById('hk-pdf-grid');
    if (!grid) return;
    var q = (filter || '').trim().toLowerCase();
    var shown = list.filter(function (p) {
      return !q || p.toLowerCase().indexOf(q) !== -1;
    });
    grid.innerHTML = '';
    if (!shown.length) {
      grid.innerHTML = '<p class="pdf-empty">No PDF files found.</p>';
      return;
    }
    shown.forEach(function (path) {
      var row = document.createElement('div');
      row.className = 'pdf-item';
      row.innerHTML =
        '<span class="pdf-item-name">' + esc(path.split('/').pop() || path) + '</span>' +
        '<button type="button" class="btn-picker">Use</button>' +
        '<button type="button" class="btn-picker-clear">Delete</button>';
      var useBtn = row.querySelector('.btn-picker');
      var delBtn = row.querySelector('.btn-picker-clear');
      useBtn.addEventListener('click', function () { select(path); });
      delBtn.addEventListener('click', function () { deletePdf(path); });
      grid.appendChild(row);
    });
  }

  function select(path) {
    if (activeInput) {
      activeInput.value = hkNormalizeUrlValue(path);
      activeInput.dispatchEvent(new Event('blur', { bubbles: true }));
    } else if (tinyCb) {
      tinyCb(path, { text: path.split('/').pop() || path, target: '_blank' });
    }
    close();
  }

  function fetchList() {
    return fetch('media-api.php?action=list_pdf', { credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        list = data && data.files ? data.files : [];
        render('');
      })
      .catch(function () { list = []; render(''); });
  }

  function uploadPdf(file) {
    var csrf = getCsrf();
    if (!csrf) return;
    var fd = new FormData();
    fd.append('csrf', csrf);
    fd.append('action', 'upload_pdf');
    fd.append('file', file);
    fetch('media-api.php', { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data || !data.ok) return;
        list = data.files || list;
        render('');
        if (data.path) select(data.path);
      })
      .catch(function () {});
  }

  function deletePdf(path) {
    if (!confirm('Delete this PDF?')) return;
    var csrf = getCsrf();
    if (!csrf) return;
    var fd = new FormData();
    fd.append('csrf', csrf);
    fd.append('action', 'delete_pdf');
    fd.append('path', path);
    fetch('media-api.php', { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data || !data.ok) return;
        list = data.files || [];
        render(document.getElementById('hk-pdf-filter').value || '');
      })
      .catch(function () {});
  }

  function openForInput(input) {
    ensureDialog();
    activeInput = input || null;
    tinyCb = null;
    fetchList();
    dlg.showModal();
  }

  function openForTinyMce(cb) {
    ensureDialog();
    activeInput = null;
    tinyCb = cb || null;
    fetchList();
    dlg.showModal();
  }

  function close() {
    if (dlg && dlg.open) dlg.close();
    activeInput = null;
    tinyCb = null;
  }

  return {
    openForInput: openForInput,
    openForTinyMce: openForTinyMce
  };
})();

function hkOpenPdfPickerForInput(input) {
  hkPdfPicker.openForInput(input);
}

function hkOpenPdfPickerForTinyMce(cb) {
  hkPdfPicker.openForTinyMce(cb);
}

function hkBindUrlFields(root) {
  (root || document).querySelectorAll('.js-url-field').forEach(function (inp) {
    if (inp.dataset.urlBound === '1') return;
    inp.dataset.urlBound = '1';
    hkEnsureUrlCtaUi(inp);
    inp.addEventListener('blur', function () {
      var n = hkNormalizeUrlValue(inp.value);
      if (n !== inp.value) inp.value = n;
    });
  });
}

// ─── Panel navigation mode ─────────────────────────────────────────────────────
var hkPanelIds = ['site', 'nav', 'hero', 'about', 'services', 'gallery', 'testimonials', 'experience', 'contact'];
var hkPanelAlias = {
  'site-social': 'site',
  'site-booking': 'site',
  'about-home': 'about',
  'about-page': 'about',
  'services-home': 'services',
  'services-page': 'services',
  'gallery-home': 'gallery',
  'gallery-page': 'gallery',
  'testimonials-home': 'testimonials',
  'testimonials-page': 'testimonials',
  'experience-home': 'experience',
  'experience-page': 'experience',
  'contact-home': 'contact',
  'contact-page': 'contact'
};
var hkCmsDirty = false;
var hkBypassDirtyCheck = false;

function hkSetDirtyWatch() {
  var form = document.getElementById('cms-form');
  if (!form) return;
  form.addEventListener('input', function () { hkCmsDirty = true; });
  form.addEventListener('change', function () { hkCmsDirty = true; });
  form.addEventListener('submit', function () { hkCmsDirty = false; hkBypassDirtyCheck = true; });
  window.addEventListener('beforeunload', function (e) {
    if (!hkCmsDirty || hkBypassDirtyCheck) return;
    e.preventDefault();
    e.returnValue = '';
  });
}

function hkActivateSidebar(hash) {
  document.querySelectorAll('.sidebar a[href^="#"]').forEach(function (a) {
    var isMatch = a.getAttribute('href') === hash;
    a.classList.toggle('is-active', isMatch);
  });
}

function hkShowAllPanels() {
  document.body.classList.remove('is-single-panel');
  document.querySelectorAll('.cms-panel').forEach(function (p) { p.classList.add('is-active'); });
  hkActivateSidebar('');
}

function hkShowSinglePanel(hash, opts) {
  var options = opts || {};
  var rawId = (hash || '').replace(/^#/, '');
  var id = hkPanelAlias[rawId] || rawId;
  if (hkPanelIds.indexOf(id) === -1) id = 'hero';

  document.body.classList.add('is-single-panel');
  document.querySelectorAll('.cms-panel').forEach(function (p) {
    p.classList.toggle('is-active', p.id === id);
  });
  hkActivateSidebar('#' + rawId);

  if (options.updateHash !== false) {
    window.location.hash = '#' + rawId;
  }
  if (rawId !== id) {
    var sub = document.getElementById(rawId);
    if (sub) sub.scrollIntoView({ block: 'start', behavior: 'smooth' });
  }
}

function hkBindPanelNavigation() {
  var showAllBtn = document.getElementById('hk-show-all-sections');
  if (showAllBtn) {
    showAllBtn.addEventListener('click', function () {
      if (hkCmsDirty && !confirm('You have unsaved changes. Continue?')) return;
      hkShowAllPanels();
      history.replaceState(null, '', window.location.pathname + window.location.search);
    });
  }

  document.querySelectorAll('.sidebar a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var hash = a.getAttribute('href') || '';
      if (!hash || hash === '#') return;
      if (hkCmsDirty && !confirm('You have unsaved changes. Continue to another section?')) {
        e.preventDefault();
        return;
      }
      e.preventDefault();
      hkShowSinglePanel(hash);
    });
  });

  window.addEventListener('hashchange', function () {
    if (!window.location.hash) return hkShowAllPanels();
    hkShowSinglePanel(window.location.hash, { updateHash: false });
  });

  if (window.location.hash) hkShowSinglePanel(window.location.hash, { updateHash: false });
  else hkShowSinglePanel('#hero', { updateHash: false });
}

// ─── Gallery multi-select ─────────────────────────────────────────────────────
document.getElementById('gallery-add-btn').addEventListener('click', function() {
  window.hkMediaPicker.open(null, 'multi', function(paths) {
    var tpl = document.getElementById('gallery-row-tpl');
    var con = document.getElementById('gallery-rows');
    var addTile = con ? con.querySelector('.gallery-add-tile') : null;
    paths.forEach(function(p) {
      var clone = tpl.content.cloneNode(true);
      var row = clone.querySelector('.gallery-row');
      row.querySelector('.gallery-img-val').value = p;
      var img = row.querySelector('.gallery-thumb-img');
      if (img) { img.src = p.replace(/^\.\//, '../'); img.style.display = ''; }
      if (addTile) con.insertBefore(clone, addTile); else con.appendChild(clone);
    });
  });
});

// ─── Gallery drag-to-reorder ─────────────────────────────────────────────────
(function() {
  var dragging = null;
  document.getElementById('gallery-rows').addEventListener('dragstart', function(e) {
    dragging = e.target.closest('.gallery-row');
    if (dragging) dragging.style.opacity = '.4';
  });
  document.getElementById('gallery-rows').addEventListener('dragend', function() {
    if (dragging) dragging.style.opacity = '';
    dragging = null;
  });
  document.getElementById('gallery-rows').addEventListener('dragover', function(e) {
    e.preventDefault();
    var target = e.target.closest('.gallery-row');
    if (!target || target === dragging) return;
    var rect = target.getBoundingClientRect();
    var after = e.clientY > rect.top + rect.height / 2;
    if (after) target.after(dragging); else target.before(dragging);
  });
})();

hkBindUrlFields(document);
hkSetDirtyWatch();
hkBindPanelNavigation();

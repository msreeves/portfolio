/**
 * Media picker for hairdressing CMS.
 * Modes:
 *   single — click image to select (default)
 *   multi  — show checkboxes, "Add Selected" button for gallery repeater
 */
(function () {
  var images = [];

  function parseJsonEl(id) {
    var el = document.getElementById(id);
    if (!el || !el.textContent) return [];
    try { return JSON.parse(el.textContent); } catch (e) { return []; }
  }

  function pathToPreviewUrl(p) {
    if (!p) return '';
    // ./assets/images/... → ../assets/images/...
    return p.replace(/^\.\//, '../');
  }

  function fileName(p) {
    return String(p).replace(/\\/g, '/').split('/').pop() || p;
  }

  function escHtml(s) {
    var d = document.createElement('div');
    d.textContent = s;
    return d.innerHTML;
  }

  function escAttr(s) {
    return String(s)
      .replace(/&/g, '&amp;').replace(/"/g, '&quot;')
      .replace(/</g, '&lt;').replace(/>/g, '&gt;');
  }

  function getCsrfToken() {
    var el = document.querySelector('input[name="cms_csrf"]');
    return el ? el.value : '';
  }

  function showError(msg) {
    var el = document.getElementById('hk-picker-error');
    if (el) { el.textContent = msg || ''; el.style.display = msg ? '' : 'none'; }
  }

  // ─── State ───────────────────────────────────────────────────────────────────
  var activeInput  = null;  // single-mode target input
  var activeMode   = 'single';
  var selected     = [];    // multi-mode selected paths
  var multiCallback = null; // fn(paths[]) called on "Add Selected"

  // ─── Rendering ───────────────────────────────────────────────────────────────
  function renderGrid(filter) {
    var grid = document.getElementById('hk-picker-grid');
    if (!grid) return;
    var q = (filter || '').trim().toLowerCase();
    var list = images.filter(function (p) {
      return !q || String(p).toLowerCase().indexOf(q) !== -1;
    });
    grid.innerHTML = '';

    if (!list.length) {
      grid.innerHTML = '<p class="picker-empty">No images found.</p>';
      return;
    }

    list.forEach(function (path) {
      var cell = document.createElement('div');
      cell.className = 'picker-cell';
      if (activeMode === 'multi' && selected.indexOf(path) !== -1) {
        cell.classList.add('is-selected');
      }

      var thumb = document.createElement('button');
      thumb.type = 'button';
      thumb.className = 'picker-cell-btn';
      var url = pathToPreviewUrl(path);
      thumb.innerHTML =
        '<span class="picker-thumb"><img src="' + escAttr(url) + '" alt="" loading="lazy" /></span>' +
        '<span class="picker-name">' + escHtml(fileName(path)) + '</span>';

      if (activeMode === 'multi') {
        var chk = document.createElement('span');
        chk.className = 'picker-check';
        chk.setAttribute('aria-hidden', 'true');
        chk.innerHTML = '&#10003;';
        cell.appendChild(chk);
        thumb.addEventListener('click', function () {
          var idx = selected.indexOf(path);
          if (idx === -1) { selected.push(path); cell.classList.add('is-selected'); }
          else { selected.splice(idx, 1); cell.classList.remove('is-selected'); }
          updateMultiCount();
        });
      } else {
        thumb.addEventListener('click', function () { selectSingle(path); });
      }

      // Delete button
      var del = document.createElement('button');
      del.type = 'button';
      del.className = 'picker-del';
      del.setAttribute('aria-label', 'Delete file');
      del.innerHTML = '&times;';
      del.addEventListener('click', function (e) {
        e.stopPropagation();
        if (!confirm('Delete "' + fileName(path) + '" permanently?')) return;
        deleteFile(path);
      });

      cell.appendChild(del);
      cell.appendChild(thumb);
      grid.appendChild(cell);
    });
  }

  function updateMultiCount() {
    var btn = document.getElementById('hk-picker-add-selected');
    if (!btn) return;
    var n = selected.length;
    btn.textContent = n > 0 ? 'Add ' + n + ' image' + (n !== 1 ? 's' : '') : 'Add Selected';
    btn.disabled = n === 0;
  }

  // ─── Single select ────────────────────────────────────────────────────────────
  function selectSingle(path) {
    if (!activeInput) return;
    activeInput.value = path;
    activeInput.dispatchEvent(new Event('input', { bubbles: true }));
    activeInput.dispatchEvent(new Event('change', { bubbles: true }));
    updatePreview(activeInput);
    closeDialog();
  }

  // ─── Multi select confirm ────────────────────────────────────────────────────
  function confirmMulti() {
    if (selected.length === 0) return;
    if (typeof multiCallback === 'function') multiCallback(selected.slice());
    closeDialog();
  }

  // ─── Preview helper ───────────────────────────────────────────────────────────
  function updatePreview(input) {
    if (!input) return;
    var wrap = input.closest('.media-picker');
    if (!wrap) return;
    var box = wrap.querySelector('.media-picker-preview');
    if (!box) return;
    var v = (input.value || '').trim();
    if (!v) { box.innerHTML = '<span class="picker-no-preview">No image selected</span>'; return; }
    var url = pathToPreviewUrl(v);
    box.innerHTML = '<img src="' + escAttr(url) + '" alt="" loading="lazy" style="max-height:100px;max-width:100%;border-radius:6px;object-fit:contain" />';
  }

  // ─── Delete ───────────────────────────────────────────────────────────────────
  function deleteFile(path) {
    var csrf = getCsrfToken();
    if (!csrf) { showError('Session token missing. Reload the page.'); return; }
    var fd = new FormData();
    fd.append('csrf', csrf);
    fd.append('action', 'delete');
    fd.append('path', path);
    fetch('media-api.php', { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data.ok) { showError(data.error || 'Delete failed.'); return; }
        if (data.images) images = data.images;
        // Clear selection if deleted
        var idx = selected.indexOf(path);
        if (idx !== -1) selected.splice(idx, 1);
        if (activeInput && activeInput.value === path) {
          activeInput.value = '';
          updatePreview(activeInput);
        }
        var f = document.getElementById('hk-picker-filter');
        renderGrid(f ? f.value : '');
        updateMultiCount();
      })
      .catch(function () { showError('Network error while deleting.'); });
  }

  // ─── Upload ────────────────────────────────────────────────────────────────────
  function uploadFile(file) {
    if (!file) return;
    var csrf = getCsrfToken();
    if (!csrf) { showError('Session token missing. Reload the page.'); return; }
    showError('');
    var fd = new FormData();
    fd.append('csrf', csrf);
    fd.append('action', 'upload');
    fd.append('file', file);
    fetch('media-api.php', { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data.ok) { showError(data.error || 'Upload failed.'); return; }
        if (data.images) images = data.images;
        var f = document.getElementById('hk-picker-filter');
        renderGrid(f ? f.value : '');
        // Auto-select uploaded file in single mode
        if (data.path && activeMode === 'single' && activeInput) {
          selectSingle(data.path);
        }
      })
      .catch(function () { showError('Network error while uploading.'); });
  }

  // ─── Open / Close ──────────────────────────────────────────────────────────────
  function openDialog(input, mode, callback) {
    activeInput   = input || null;
    activeMode    = mode || 'single';
    multiCallback = callback || null;
    selected      = [];

    var dlg = document.getElementById('hk-picker-dialog');
    if (!dlg || !dlg.showModal) return;
    showError('');

    var filterEl = document.getElementById('hk-picker-filter');
    if (filterEl) filterEl.value = '';

    var addBtn = document.getElementById('hk-picker-add-selected');
    if (addBtn) {
      addBtn.style.display = activeMode === 'multi' ? '' : 'none';
      addBtn.disabled = true;
      addBtn.textContent = 'Add Selected';
    }
    var title = document.getElementById('hk-picker-title');
    if (title) {
      var context = input && input.dataset ? input.dataset.pickerContext : '';
      var base = activeMode === 'multi' ? 'Choose Images' : 'Choose Image';
      title.textContent = context ? (base + ' for ' + context) : base;
    }

    renderGrid('');
    dlg.showModal();
    if (filterEl) setTimeout(function () { try { filterEl.focus(); } catch (e) {} }, 0);
  }

  function closeDialog() {
    var dlg = document.getElementById('hk-picker-dialog');
    if (dlg && dlg.open) dlg.close();
    activeInput = null;
    multiCallback = null;
    selected = [];
  }

  // ─── Load image list from server ──────────────────────────────────────────────
  function loadImages() {
    // Try inline JSON first (populated by PHP)
    var inlineImages = parseJsonEl('hk-media-data');
    if (inlineImages.length > 0) { images = inlineImages; return; }
    // Fallback: fetch from API
    fetch('media-api.php?action=list', { credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) { if (data.images) images = data.images; })
      .catch(function () {});
  }

  // ─── Event delegation ─────────────────────────────────────────────────────────
  document.body.addEventListener('click', function (e) {
    var btn = e.target.closest('.media-picker-open');
    if (!btn) return;
    e.preventDefault();
    var wrap  = btn.closest('.media-picker');
    var input = wrap && wrap.querySelector('.media-picker-input');
    if (!input) return;
    openDialog(input, 'single');
  });

  document.body.addEventListener('input', function (e) {
    if (e.target.classList && e.target.classList.contains('media-picker-input')) {
      updatePreview(e.target);
    }
  });

  // ─── Dialog wiring ─────────────────────────────────────────────────────────────
  (function wireDialog() {
    var dlg = document.getElementById('hk-picker-dialog');
    if (!dlg) return;

    dlg.addEventListener('close', function () { activeInput = null; multiCallback = null; });

    var cancel = document.getElementById('hk-picker-cancel');
    if (cancel) cancel.addEventListener('click', closeDialog);

    var filterEl = document.getElementById('hk-picker-filter');
    if (filterEl) filterEl.addEventListener('input', function () { renderGrid(filterEl.value); });

    var addBtn = document.getElementById('hk-picker-add-selected');
    if (addBtn) addBtn.addEventListener('click', confirmMulti);

    var uploadBtn   = document.getElementById('hk-picker-upload-btn');
    var uploadInput = document.getElementById('hk-picker-upload-input');
    if (uploadBtn && uploadInput) {
      uploadBtn.addEventListener('click', function () { uploadInput.click(); });
      uploadInput.addEventListener('change', function () {
        var f = uploadInput.files && uploadInput.files[0];
        uploadInput.value = '';
        if (f) uploadFile(f);
      });
    }
  })();

  // ─── Init previews ─────────────────────────────────────────────────────────────
  function initPreviews() {
    document.querySelectorAll('.media-picker-input').forEach(updatePreview);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () { loadImages(); initPreviews(); });
  } else {
    loadImages();
    initPreviews();
  }

  // ─── Public API ────────────────────────────────────────────────────────────────
  window.hkMediaPicker = {
    open: openDialog,
    close: closeDialog,
    updatePreview: updatePreview,
    syncPreviews: function (root) {
      (root || document).querySelectorAll('.media-picker-input').forEach(updatePreview);
    }
  };
})();

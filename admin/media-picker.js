/**
 * Shared modal picker for ./media images and PDFs (edit.php).
 * Upload/delete via media-api.php (syncs with server / Hostinger file manager).
 */
(function () {
  function parseJsonEl(id) {
    var el = document.getElementById(id);
    if (!el || !el.textContent) return [];
    try {
      return JSON.parse(el.textContent);
    } catch (e) {
      return [];
    }
  }

  var images = parseJsonEl('cms-media-data-images');
  var pdfs = parseJsonEl('cms-media-data-pdfs');

  function pathToPreviewUrl(p) {
    if (!p || p.indexOf('./') !== 0) return '';
    return '..' + p.substring(1);
  }

  function fileName(p) {
    var parts = String(p).replace(/\\/g, '/').split('/');
    return parts[parts.length - 1] || p;
  }

  function escHtml(s) {
    var d = document.createElement('div');
    d.textContent = s;
    return d.innerHTML;
  }

  function escAttr(s) {
    return String(s)
      .replace(/&/g, '&amp;')
      .replace(/"/g, '&quot;')
      .replace(/</g, '&lt;');
  }

  function getCsrfToken() {
    var el = document.querySelector('#cms-wizard-form input[name="csrf"]');
    return el && el.value ? el.value : '';
  }

  function showPickerError(msg) {
    var el = document.getElementById('cms-media-picker-error');
    if (!el) return;
    el.textContent = msg || '';
    el.classList.toggle('d-none', !msg);
  }

  function hidePickerError() {
    showPickerError('');
  }

  function cmsMediaUpdatePreview(input) {
    if (!input) return;
    var wrap = input.closest('.cms-media-picker');
    var v = (input.value || '').trim();
    if (!wrap) return;
    var mode = wrap.getAttribute('data-mode') || 'image';
    var box = wrap.querySelector('.cms-media-picker-preview');
    if (!box) return;

    if (v.indexOf('./') !== 0) {
      var emptyCls = wrap.closest('.cms-img-field--grid')
        ? 'cms-img-field__empty'
        : 'text-muted small';
      box.innerHTML = '<span class="' + emptyCls + '">No preview</span>';
      return;
    }
    var url = pathToPreviewUrl(v);
    if (mode === 'course' || mode === 'pdf') {
      if (/\.pdf$/i.test(v)) {
        box.innerHTML =
          '<div class="cms-media-picker-pdf d-flex align-items-center gap-2 p-2 border rounded" style="background:var(--cms-input-bg,#fff);color:var(--cms-input-text,#1f2329)">' +
          '<span class="badge rounded-pill" style="background:#c62828;color:#fff">PDF</span>' +
          '<span class="text-truncate small" title="' +
          escAttr(v) +
          '">' +
          escHtml(fileName(v)) +
          '</span></div>';
      } else if (mode === 'course') {
        box.innerHTML =
          '<img class="img-fluid rounded mw-100" alt="" src="' +
          escAttr(url) +
          '" style="max-height:96px;max-width:100%;object-fit:contain" loading="lazy" />';
      } else {
        box.innerHTML = '<span class="text-muted small">No PDF selected</span>';
      }
    } else {
      var imgStyle = wrap.closest('.cms-img-field--grid')
        ? 'max-width:100%;object-fit:contain'
        : 'max-height:120px;max-width:100%;object-fit:contain';
      box.innerHTML =
        '<img class="img-fluid rounded mw-100 cms-img-preview" alt="" src="' +
        escAttr(url) +
        '" style="' +
        imgStyle +
        '" loading="lazy" />';
    }
  }

  var activeInput = null;
  var activeMode = 'image';

  function itemsForMode(mode) {
    if (mode === 'image') return images.slice();
    if (mode === 'pdf') return pdfs.slice();
    if (mode === 'course') {
      var m = images.concat(pdfs);
      m.sort(function (a, b) {
        return fileName(a).localeCompare(fileName(b), undefined, { sensitivity: 'base' });
      });
      return m;
    }
    return images.slice();
  }

  function applyListsFromResponse(data) {
    if (data.images && Array.isArray(data.images)) images = data.images;
    if (data.pdfs && Array.isArray(data.pdfs)) pdfs = data.pdfs;
  }

  function selectPath(path) {
    if (!activeInput) return;
    activeInput.value = path;
    activeInput.dispatchEvent(new Event('input', { bubbles: true }));
    activeInput.dispatchEvent(new Event('change', { bubbles: true }));
    cmsMediaUpdatePreview(activeInput);
    closeDialog();
  }

  function renderGrid(filter) {
    var grid = document.getElementById('cms-media-picker-grid');
    if (!grid) return;
    var q = (filter || '').trim().toLowerCase();
    var list = itemsForMode(activeMode).filter(function (p) {
      if (!q) return true;
      return String(p).toLowerCase().indexOf(q) !== -1;
    });
    grid.innerHTML = '';
    if (!list.length) {
      grid.innerHTML = '<p class="text-muted small mb-0">No files match.</p>';
      return;
    }
    list.forEach(function (path) {
      var isPdf = /\.pdf$/i.test(path);
      var cell = document.createElement('div');
      cell.className = 'cms-media-picker-cell';
      cell.setAttribute('data-path', path);

      var delBtn = document.createElement('button');
      delBtn.type = 'button';
      delBtn.className = 'cms-media-picker-del';
      delBtn.setAttribute('aria-label', 'Delete file from server');
      delBtn.setAttribute('title', 'Delete from server');
      delBtn.innerHTML = '&times;';
      delBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        if (!confirm('Delete “' + fileName(path) + '” from the server? This removes the file from media/ (e.g. in Hostinger File Manager) and cannot be undone.')) {
          return;
        }
        deleteMediaPath(path);
      });

      var inner = document.createElement('button');
      inner.type = 'button';
      inner.className = 'cms-media-picker-cell-select';
      if (isPdf) {
        inner.innerHTML =
          '<span class="cms-media-picker-cell-icon" aria-hidden="true">PDF</span>' +
          '<span class="cms-media-picker-cell-name">' +
          escHtml(fileName(path)) +
          '</span>';
      } else {
        var u = pathToPreviewUrl(path);
        inner.innerHTML =
          '<span class="cms-media-picker-cell-thumb-wrap"><img src="' +
          escAttr(u) +
          '" alt="" loading="lazy" /></span>' +
          '<span class="cms-media-picker-cell-name">' +
          escHtml(fileName(path)) +
          '</span>';
      }
      inner.addEventListener('click', function (e) {
        e.stopPropagation();
        selectPath(path);
      });

      cell.appendChild(delBtn);
      cell.appendChild(inner);
      grid.appendChild(cell);
    });
  }

  function deleteMediaPath(path) {
    var csrf = getCsrfToken();
    if (!csrf) {
      showPickerError('Session token missing. Reload the page.');
      return;
    }
    showPickerError('');
    var fd = new FormData();
    fd.append('csrf', csrf);
    fd.append('action', 'delete');
    fd.append('path', path);
    fetch('media-api.php', { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(function (r) {
        return r.json().then(function (data) {
          return { ok: r.ok, data: data };
        });
      })
      .then(function (res) {
        if (!res.data || !res.data.ok) {
          showPickerError((res.data && res.data.error) || 'Delete failed.');
          return;
        }
        applyListsFromResponse(res.data);
        var f = document.getElementById('cms-media-picker-filter');
        renderGrid(f ? f.value : '');
        if (activeInput && (activeInput.value || '').trim() === path) {
          activeInput.value = '';
          activeInput.dispatchEvent(new Event('input', { bubbles: true }));
          cmsMediaUpdatePreview(activeInput);
        }
      })
      .catch(function () {
        showPickerError('Network error while deleting.');
      });
  }

  function setUploadAccept() {
    var uploadInput = document.getElementById('cms-media-upload-input');
    if (!uploadInput) return;
    if (activeMode === 'image') {
      uploadInput.accept = 'image/jpeg,image/png,image/gif,image/webp,image/svg+xml,.jpg,.jpeg,.png,.gif,.webp,.svg';
    } else if (activeMode === 'pdf') {
      uploadInput.accept = 'application/pdf,.pdf';
    } else {
      uploadInput.accept =
        'image/jpeg,image/png,image/gif,image/webp,image/svg+xml,application/pdf,.jpg,.jpeg,.png,.gif,.webp,.svg,.pdf';
    }
  }

  function uploadFile(file) {
    if (!file) return;
    var csrf = getCsrfToken();
    if (!csrf) {
      showPickerError('Session token missing. Reload the page.');
      return;
    }
    showPickerError('');
    var fd = new FormData();
    fd.append('csrf', csrf);
    fd.append('action', 'upload');
    fd.append('file', file);
    fetch('media-api.php', { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(function (r) {
        return r.json().then(function (data) {
          return { ok: r.ok, data: data };
        });
      })
      .then(function (res) {
        if (!res.data || !res.data.ok) {
          showPickerError((res.data && res.data.error) || 'Upload failed.');
          return;
        }
        applyListsFromResponse(res.data);
        var f = document.getElementById('cms-media-picker-filter');
        renderGrid(f ? f.value : '');
        if (res.data.path && activeInput) {
          activeInput.value = res.data.path;
          activeInput.dispatchEvent(new Event('input', { bubbles: true }));
          cmsMediaUpdatePreview(activeInput);
        }
      })
      .catch(function () {
        showPickerError('Network error while uploading.');
      });
  }

  function openDialog(input, mode) {
    activeInput = input;
    activeMode = mode || 'image';
    var dlg = document.getElementById('cms-media-picker-dialog');
    var filterEl = document.getElementById('cms-media-picker-filter');
    if (!dlg || !dlg.showModal) return;
    hidePickerError();
    setUploadAccept();
    if (filterEl) filterEl.value = '';
    renderGrid('');
    dlg.showModal();
    if (filterEl) {
      setTimeout(function () {
        try {
          filterEl.focus();
        } catch (e) {}
      }, 0);
    }
  }

  function closeDialog() {
    var dlg = document.getElementById('cms-media-picker-dialog');
    if (dlg && dlg.open) dlg.close();
    activeInput = null;
  }

  document.body.addEventListener('click', function (e) {
    var btn = e.target.closest('.cms-media-picker-open');
    if (!btn) return;
    e.preventDefault();
    var wrap = btn.closest('.cms-media-picker');
    var input = wrap && wrap.querySelector('.cms-media-picker-input');
    if (!input) return;
    openDialog(input, wrap.getAttribute('data-mode') || 'image');
  });

  document.body.addEventListener('input', function (e) {
    if (e.target.classList && e.target.classList.contains('cms-media-picker-input')) {
      cmsMediaUpdatePreview(e.target);
    }
  });

  function runInitialPreviews() {
    document.querySelectorAll('.cms-media-picker-input').forEach(cmsMediaUpdatePreview);
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runInitialPreviews);
  } else {
    runInitialPreviews();
  }

  (function bindDialog() {
    var dlg = document.getElementById('cms-media-picker-dialog');
    if (!dlg) return;
    dlg.addEventListener('close', function () {
      activeInput = null;
    });
    var cancel = document.getElementById('cms-media-picker-cancel');
    if (cancel) cancel.addEventListener('click', closeDialog);
    var filterEl = document.getElementById('cms-media-picker-filter');
    if (filterEl) {
      filterEl.addEventListener('input', function () {
        renderGrid(filterEl.value);
      });
    }
    var uploadBtn = document.getElementById('cms-media-upload-btn');
    var uploadInput = document.getElementById('cms-media-upload-input');
    if (uploadBtn && uploadInput) {
      uploadBtn.addEventListener('click', function () {
        setUploadAccept();
        uploadInput.click();
      });
      uploadInput.addEventListener('change', function () {
        var f = uploadInput.files && uploadInput.files[0];
        uploadInput.value = '';
        if (f) uploadFile(f);
      });
    }
  })();

  window.cmsMediaPickerSyncPreviews = function (root) {
    var scope = root || document;
    scope.querySelectorAll('.cms-media-picker-input').forEach(cmsMediaUpdatePreview);
  };
  window.cmsMediaUpdatePreview = cmsMediaUpdatePreview;
})();

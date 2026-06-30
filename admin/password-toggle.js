/**
 * Show/hide password toggles for [data-password-toggle] wrappers.
 */
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('[data-password-toggle]').forEach(function (wrap) {
		var inputId = wrap.getAttribute('data-password-toggle');
		var input = document.getElementById(inputId);
		var btn = wrap.querySelector('[data-password-toggle-btn]');
		if (!input || !btn) {
			return;
		}
		var eyeOpen = btn.querySelector('.password-toggle__icon-show');
		var eyeShut = btn.querySelector('.password-toggle__icon-hide');

		function sync() {
			var visible = input.type === 'text';
			btn.setAttribute('aria-pressed', visible ? 'true' : 'false');
			btn.setAttribute('aria-label', visible ? 'Hide password' : 'Show password');
			if (eyeOpen && eyeShut) {
				eyeOpen.classList.toggle('d-none', visible);
				eyeShut.classList.toggle('d-none', !visible);
			}
		}

		btn.addEventListener('click', function () {
			input.type = input.type === 'password' ? 'text' : 'password';
			sync();
		});
		sync();
	});
});

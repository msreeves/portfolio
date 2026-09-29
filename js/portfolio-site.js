/**
 * Portfolio site chrome — mobile nav, scroll reveal (Goal wave R apply).
 */
document.addEventListener('DOMContentLoaded', function () {
	var navCollapse = document.getElementById('navbarTogglerDemo01');
	var navToggler = document.querySelector('[data-bs-target="#navbarTogglerDemo01"]');
	var mobileQuery = window.matchMedia('(max-width: 991.98px)');

	if (navCollapse && window.bootstrap && bootstrap.Collapse) {
		navCollapse.querySelectorAll('a.nav-link').forEach(function (link) {
			link.addEventListener('click', function () {
				if (!mobileQuery.matches) {
					return;
				}
				var instance = bootstrap.Collapse.getInstance(navCollapse);
				if (instance) {
					instance.hide();
				}
			});
		});

		navCollapse.addEventListener('shown.bs.collapse', function () {
			if (navToggler) {
				navToggler.setAttribute('aria-expanded', 'true');
			}
		});

		navCollapse.addEventListener('hidden.bs.collapse', function () {
			if (navToggler) {
				navToggler.setAttribute('aria-expanded', 'false');
			}
		});

		document.addEventListener('keydown', function (event) {
			if (event.key !== 'Escape' || !mobileQuery.matches) {
				return;
			}
			if (!navCollapse.classList.contains('show')) {
				return;
			}
			event.preventDefault();
			var instance =
				bootstrap.Collapse.getInstance(navCollapse) ||
				new bootstrap.Collapse(navCollapse, { toggle: false });
			instance.hide();
			if (navToggler) {
				navToggler.focus();
			}
		});
	}

	var reduceMotion =
		window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (reduceMotion) {
		document.querySelectorAll('.msr-fade-in').forEach(function (el) {
			el.classList.add('is-visible');
		});
	} else if ('IntersectionObserver' in window) {
		var revealEls = document.querySelectorAll('.msr-fade-in');
		if (revealEls.length) {
			function revealIfInView(el) {
				var rect = el.getBoundingClientRect();
				var vh = window.innerHeight || document.documentElement.clientHeight;
				if (rect.top < vh * 0.92 && rect.bottom > vh * 0.04) {
					el.classList.add('is-visible');
					return true;
				}
				return false;
			}

			var revealObserver = new IntersectionObserver(
				function (entries, observer) {
					entries.forEach(function (entry) {
						if (!entry.isIntersecting) {
							return;
						}
						entry.target.classList.add('is-visible');
						observer.unobserve(entry.target);
					});
				},
				{ rootMargin: '0px 0px -4% 0px', threshold: 0.02 }
			);
			revealEls.forEach(function (el) {
				if (!revealIfInView(el)) {
					revealObserver.observe(el);
				}
			});
			window.addEventListener('load', function () {
				revealEls.forEach(function (el) {
					revealIfInView(el);
				});
			});
		}
	} else {
		document.querySelectorAll('.msr-fade-in').forEach(function (el) {
			el.classList.add('is-visible');
		});
	}
});

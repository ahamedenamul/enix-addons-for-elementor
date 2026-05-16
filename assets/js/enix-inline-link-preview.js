/* Enix Inline Link Preview – cursor follow + a11y */
(function () {
	'use strict';

	function initWrap(wrap) {
		if (wrap.dataset.enixInit === '1') return;
		wrap.dataset.enixInit = '1';

		var follow = wrap.getAttribute('data-follow') === '1';
		var containers = wrap.querySelectorAll('.enix-link-container');

		containers.forEach(function (c) {
			var popup = c.querySelector('.enix-preview-popup');
			var link  = c.querySelector('.enix-preview-link');
			if (!popup || !link) return;

			if (follow) {
				link.addEventListener('mousemove', function (e) {
					var rect = link.getBoundingClientRect();
					var rel  = (e.clientX - rect.left) / Math.max(rect.width, 1); // 0..1
					// Shift popup horizontally up to ±40% from center based on cursor X
					var offset = (rel - 0.5) * 80; // -40 .. +40 percent
					popup.style.setProperty('--enix-x', 'calc(-50% + ' + offset + 'px)');
				});
				link.addEventListener('mouseleave', function () {
					popup.style.setProperty('--enix-x', '-50%');
				});
			}

			// Keyboard a11y
			link.addEventListener('focus', function () { c.classList.add('is-active'); });
			link.addEventListener('blur',  function () { c.classList.remove('is-active'); });
		});
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('.enix-inline-preview-wrap').forEach(initWrap);
	}

	if (document.readyState !== 'loading') initAll();
	else document.addEventListener('DOMContentLoaded', function () { initAll(); });

	// Elementor frontend hook
	if (window.jQuery) {
		jQuery(window).on('elementor/frontend/init', function () {
			if (window.elementorFrontend && elementorFrontend.hooks) {
				elementorFrontend.hooks.addAction('frontend/element_ready/enix_inline_link_preview.default', function ($scope) {
					initAll($scope[0]);
				});
			}
		});
	}
})();

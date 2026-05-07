/**
 * Enix Timeline Steps — Frontend JavaScript
 * @package EnixAddons
 */
( function () {
	'use strict';

	/**
	 * Initialize scroll-reveal animations for all timeline widgets on the page.
	 * Uses IntersectionObserver; falls back gracefully when not supported.
	 */
	function enix_timeline_init_animations() {
		var cards = document.querySelectorAll( '.enix-timeline-card:not(.enix-show)' );

		if ( ! cards.length ) return;

		if ( ! ( 'IntersectionObserver' in window ) ) {
			// Fallback: show all cards immediately.
			cards.forEach( function ( card ) {
				card.classList.add( 'enix-show' );
			} );
			return;
		}

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						var delay = parseInt( entry.target.getAttribute( 'data-enix-delay' ), 10 ) || 0;
						var target = entry.target;
						setTimeout( function () {
							target.classList.add( 'enix-show' );
						}, delay );
						observer.unobserve( target );
					}
				} );
			},
			{ threshold: 0.15 }
		);

		cards.forEach( function ( card ) {
			observer.observe( card );
		} );
	}

	// ── Init on DOM ready ─────────────────────────────────────────────────────
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', enix_timeline_init_animations );
	} else {
		enix_timeline_init_animations();
	}

	// ── Elementor frontend hook (re-init on widget re-render in editor) ───────
	if ( window.elementorFrontend ) {
		window.elementorFrontend.hooks.addAction(
			'frontend/element_ready/enix_timeline_steps.default',
			enix_timeline_init_animations
		);
	}

	// Expose for external re-use (e.g. AJAX page loads).
	window.enix_timeline_init_animations = enix_timeline_init_animations;
}() );

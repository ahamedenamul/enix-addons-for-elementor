/**
 * Enix Addons – Advanced Accordion Interactive JS
 *
 * Plugin:  Enix Addons for Elementor
 * Author:  Enamul Islam  |  https://enamulislam.com
 * Version: 1.0.0
 *
 * Features:
 *  - Smooth jQuery slideDown / slideUp for accordion body
 *  - CSS opacity + translateY crossfade for image panel (via CSS Grid stacking)
 *  - Full keyboard navigation (Enter / Space)
 *  - ARIA attribute management
 *  - Multi-instance safe
 *  - Elementor editor live-preview support
 */
( function ( $ ) {
	'use strict';

	/** Slide speed (ms) – matches default CSS transition duration */
	var SLIDE_SPEED = 320;

	var EnixAccordion = {

		/**
		 * Initialise all accordion wrappers inside a given scope element.
		 *
		 * @param {jQuery} $scope
		 */
		init: function ( $scope ) {
			$scope.find( '.enix-accordion-wrapper' ).each( function () {
				EnixAccordion.bindWrapper( $( this ) );
			} );
		},

		/**
		 * Attach event listeners to one accordion wrapper.
		 *
		 * @param {jQuery} $wrapper
		 */
		bindWrapper: function ( $wrapper ) {

			// Prevent double-binding on repeated Elementor init calls.
			if ( $wrapper.data( 'enix-bound' ) ) {
				return;
			}
			$wrapper.data( 'enix-bound', true );

			var $items = $wrapper.find( '.enix-accordion-item' );

			// Show first item's description without animation on page load.
			$items.filter( '.enix-active' ).find( '.enix-accordion-desc' ).show();

			// ── Click / Keyboard handler ──────────────────────────────
			$items.on( 'click keydown', function ( e ) {

				// Keyboard: only fire on Enter (13) or Space (32).
				if ( 'keydown' === e.type ) {
					if ( 13 !== e.which && 32 !== e.which ) { return; }
					e.preventDefault();
				}

				var $item  = $( this );
				var index  = $item.data( 'index' );

				// Skip if this item is already open.
				if ( $item.hasClass( 'enix-active' ) ) { return; }

				// ── Close all open items ──────────────────────────────
				$items.each( function () {
					var $current = $( this );
					if ( $current.hasClass( 'enix-active' ) ) {
						$current.removeClass( 'enix-active' );
						$current.attr( { 'aria-selected': 'false', tabindex: '-1' } );
						// Smooth slide up.
						$current.find( '.enix-accordion-desc' ).slideUp( SLIDE_SPEED, 'swing' );
					}
				} );

				// ── Open clicked item ─────────────────────────────────
				$item
					.addClass( 'enix-active' )
					.attr( { 'aria-selected': 'true', tabindex: '0' } );

				// Smooth slide down.
				$item.find( '.enix-accordion-desc' ).slideDown( SLIDE_SPEED, 'swing' );

				// ── Crossfade image panel ─────────────────────────────
				var $imgs = $wrapper.find( '.enix-accordion-img' );

				// Fade out current active image.
				$imgs.filter( '.enix-img-active' )
					.removeClass( 'enix-img-active' )
					.attr( 'aria-hidden', 'true' );

				// Fade in target image (CSS transition handles the visual).
				$imgs.filter( '[data-index="' + index + '"]' )
					.addClass( 'enix-img-active' )
					.attr( 'aria-hidden', 'false' );

			} );
		},
	};

	// ── DOM ready ─────────────────────────────────────────────────────
	$( document ).ready( function () {
		EnixAccordion.init( $( document ) );
	} );

	// ── Elementor editor live-preview ─────────────────────────────────
	$( window ).on( 'elementor/frontend/init', function () {
		if ( 'undefined' === typeof elementorFrontend ) { return; }

		elementorFrontend.hooks.addAction(
			'frontend/element_ready/enix_advanced_accordion.default',
			function ( $scope ) {
				EnixAccordion.init( $scope );
			}
		);
	} );

} )( jQuery );

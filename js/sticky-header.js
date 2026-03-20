/**
 * Roadies — Sticky Header Scroll Handler
 *
 * Toggles the 'scrolled' class on the site header when user scrolls past 20px.
 * The 'scrolled' class triggers a CSS transition from transparent to solid black.
 */

( function() {
	'use strict';

	const header = document.querySelector( '.site-header' );

	if ( ! header ) {
		return; // Header not found — bail.
	}

	/**
	 * Handle the scroll event and toggle the 'scrolled' class.
	 * Uses passive event listener for better scroll performance.
	 */
	function handleScroll() {
		if ( window.scrollY > 20 ) {
			header.classList.add( 'scrolled' );
		} else {
			header.classList.remove( 'scrolled' );
		}
	}

	// Use passive flag for improved scroll performance (non-blocking).
	window.addEventListener( 'scroll', handleScroll, { passive: true } );

	// Call once on page load to set initial state.
	handleScroll();
} )();

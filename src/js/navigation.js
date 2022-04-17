/**
 * File navigation.js
 *
 * On menu button click, add/remove 'site-header--toggled' class to site and 'aria-expanded' boolean value on toggle click
 */
( function() {
	let navbar = document.querySelector( '.site-header' );
	if ( ! navbar ) return;

	let toggle = navbar.querySelector( '.site-nav__toggle' ),
		nav = navbar.querySelector( '.site-nav' ),
		navClasses = navbar.classList,
		openClass = 'site-header--expanded',
		openAtt = 'aria-expanded';

	if ( ! toggle || ! nav ) return;

	nav.setAttribute( openAtt, 'false' );

	function closeOnOutsideClick( e ) {
		if ( ! navbar.contains( e.target ) ) {
			navClasses.remove( openClass );
			toggle.setAttribute( openAtt, 'false' );
			nav.setAttribute( openAtt, 'false' );
		}
	}

	function toggleOpen() {
		if ( navClasses.contains( openClass ) ) {
			navClasses.remove( openClass );
			toggle.setAttribute( openAtt, 'false' );
			nav.setAttribute( openAtt, 'false' );
		} else {
			navClasses.add( openClass );
			toggle.setAttribute( openAtt, 'true' );
			nav.setAttribute( openAtt, 'true' );
		}
	}
	toggle.addEventListener( 'click', toggleOpen );
	document.addEventListener( 'click', closeOnOutsideClick );
} )();



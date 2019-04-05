( function() {

	var container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	// edit max-width to your navigation breakpoint
	var breakpoint = '(max-width: 991px)';

	/**
	 * Toggles `clicked` class to allow submenu access on tablets.
	 */
	function clickMenu() {

		var container,
		clickFn,
		i,
		parentLink;

		container = document.getElementById( 'site-navigation' );
		if ( ! container ) {
			return;
		}

		parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'onclick' in window ) {
			clickFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'clicked' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'clicked' );
					}
					menuItem.classList.add( 'clicked' );
				} else {
					menuItem.classList.remove( 'clicked' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'click', clickFn, false );
			}
		}
	}

	if ( typeof window.ontouchstart !== 'undefined' ) {
		clickMenu();
	}

	if ( typeof window.matchMedia != 'undefined' || typeof window.msMatchMedia != 'undefined' ) {

		var mql = window.matchMedia( breakpoint );

		if ( mql.matches ) {
			clickMenu();
		}

		function screenTest( e ) {
			if ( e.matches ) {
				clickMenu();
			}
		}

		mql.addListener(screenTest);
	}

} )();

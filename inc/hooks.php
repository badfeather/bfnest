<?php
/**
 * Adds custom classes to the array of body classes.
 */
function bfnest_body_classes( $classes ) {

	global $is_IE;

	if ( $is_IE ) {
		$classes[] = 'ie';
	}

	if ( is_page() ) {
		$classes[] = 'page-' . basename( get_permalink() );
	}

	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( wp_is_mobile() ) {
		$classes[] = 'mobile';
	}

	$classes[] = 'no-js';

	return $classes;
}
add_filter( 'body_class', 'bfnest_body_classes' );

/**
 * Add ARIA labels to wp_nav_menu items with children
 * Found here - https://www.kevinleary.net/accessible-dropdown-menus-for-wordpress/
 * See https://www.w3.org/WAI/tutorials/menus/flyout/
 */
function bfnest_wcag_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

    // Add [aria-haspopup] and [aria-expanded] to menu items that have children
    $item_has_children = in_array( 'menu-item-has-children', $item->classes );
    if ( $item_has_children ) {
        $atts['aria-haspopup'] = "true";
        $atts['aria-expanded'] = "false";
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'bfnest_wcag_nav_menu_link_attributes', 10, 4 );

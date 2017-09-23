<?php
/**
 * Adds custom classes to the array of body classes.
 */
function nest_body_classes( $classes ) {

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
add_filter( 'body_class', 'nest_body_classes' );

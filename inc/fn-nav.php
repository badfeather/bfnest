<?php

/**
 * Postnav single
 */
function bfnest_postnav_single( $in_same_term = false, $excluded_terms = array(), $taxonomy = 'category', $newer_title = null, $older_title = null ) {
	if ( ! is_single() ) {
		return false;
	}

	if ( null === $newer_title ) {
		$newer_title = __( '&larr; %title', 'bfnest' );
	}

	if ( null === $older_title ) {
		$older_title = __( '%title &rarr;', 'bfnest' );
	}

	$newer = get_next_post_link( '<div class="postnav__link postnav__link--newer">%link</div>', $newer_title, $in_same_term, $excluded_terms, $taxonomy );
	$older = get_previous_post_link( '<div class="postnav__link postnav__link--older">%link</div>', $older_title, $in_same_term, $excluded_terms, $taxonomy );
	$postnav = array();

	if ( $newer ) {
		$postnav[] = $newer;
	}

	if ( $older ) {
		$postnav[] = $older;
	}

	if ( ! empty( $postnav ) ) {
		echo '<nav class="postnav doc--single__postnav">' . "\n" . implode( '', $postnav ) . '</nav>';
	}
}

/**
 * Postnav archives
 */
function bfnest_postnav_archive( $newer_title = null, $older_title = null ) {
	if ( ! is_archive() ) {
		return false;
	}

	if ( null === $newer_title ) {
		$newer_title = __( '&larr; Newer Entries', 'bfnest' );
	}

	if ( null === $older_title ) {
		$older_title =	__( 'Older Entries &rarr;', 'bfnest' );
	}

	$newer = get_previous_posts_link( $newer_title );
	$older = get_next_posts_link( $older_title );
	$postnav = array();

	if ( $newer ) {
		$postnav[] = '<div class="postnav__link postnav__link--newer">' . $newer . '</div>' . "\n";
	}

	if ( $older ) {
		$postnav[] = '<div class="postnav__link postnav__link--older">' . $older . '</div>' . "\n";
	}

	if ( ! empty( $postnav ) ) {
		echo '<nav class="postnav doc--archive__postnav">' . "\n" . implode( '', $postnav ) . '</nav>';
	}
}

/**
 * WP_nav_menu separate submenu output.
 *
 * Optional $args contents:
 *
 * string theme_location - The menu that is desired.  Accepts (matching in order) id, slug, name. Defaults to blank.
 * string xpath - Optional. xPath syntax.
 * string before - Optional. Text before the menu tree.
 * string after - Optional. Text after the menu tree.
 * bool echo - Optional, default is TRUE. Whether to echo the menu or return it.
 *
 * @param array $args Arguments
 * @return String If $echo value is set to FALSE.
 * https://www.isitwp.com/wp_nav_menu-separate-submenu-output/
 */
function bfnest_the_submenu( $args = array() ) {
	$defaults = array(
		'theme_location' => '',
		'xpath' => "./li[contains(@class,'current-menu-item') or contains(@class,'current-menu-ancestor')]/ul",
		'before' => '',
		'after' => '',
		'echo' => true
	);
	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;
	$output = array();
	$menu_tree = wp_nav_menu( array( 'theme_location' => $args->theme_location, 'container' => '', 'echo' => false ) );
	$menu_tree_XML = new SimpleXMLElement( $menu_tree );
	$path = $menu_tree_XML->xpath( $args->xpath );
	$output[] = $args->before;
	if ( ! empty( $path ) ) {
		$output[] = $path[0]->asXML();
	}
	$output[] = $args->after;
	$html = join( '', $output );
	if ( $args->echo ) {
		echo $html;
		return;
	}
	return $html;
}

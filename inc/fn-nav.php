<?php

/**
 * Postnav single
 */
function bfnest_postnav_single( $in_same_term = false, $excluded_terms = [], $taxonomy = 'category', $newer_title = null, $older_title = null ) {
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
	$postnav = [];

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
	if ( ! ( is_archive() || is_home() ) ) {
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
	$postnav = [];

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
 * Add button to toggle color scheme
 */
function bfnest_color_scheme_button() {
	echo '<button class="btn btn--color-scheme" data-toggle-color-scheme>Toggle color scheme</button>';
}

/**
 * Sets $menu_item->current_item_ancestor to true for post type archive menu item if viewing single post of that type
 * Also adds 'current-menu-ancestor' class to $menu_item->classes
 */
function bfnest_wp_nav_menu_objects_current_post_type_archive_for_single( $sorted_menu_items, $args ) {
	if ( ! is_single() ) return $sorted_menu_items;
	$post_type = get_post_type();
	// find a post type archive menu item matching the post's post type
	foreach ( $sorted_menu_items as $menu_item ) {
		if ( ! isset( $menu_item->type ) || $menu_item->type !== 'post_type_archive' ) continue;
		if ( isset( $menu_item->object ) && $menu_item->object === $post_type ) {
			$menu_item->current_item_ancestor = 1;
			$root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
			// add 'current-menu-ancestor' class to menu item
			if ( ! in_array( 'current-menu-ancestor', $menu_item->classes ) ) $menu_item->classes[] = 'current-menu-ancestor';
			break;
		}
	}
	return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'bfnest_wp_nav_menu_objects_current_post_type_archive_for_single', 10, 2 );

/**
 * Add Sub Menu hook to wp_nav_menu to display sub menus on sub pages
 * @see https://gist.github.com/levymetal/5547605#file-functions-php
 * In addition to standard wp_nav_menu $args (@see https://developer.wordpress.org/reference/functions/wp_nav_menu/),
 * the following args are added:
 * 	@type bool $sub_menu Whether to display a sub_menu
 *	@type bool $show_parent Whether to display the parent list item when outputting submenus
 *
 * Example usage:
 *	wp_nav_menu( [
 *		'theme_location' => 'primary',
 *		'sub_menu' => true,
 *		'show_parent' => true,
 *		'fallback_cb' => false,
 *	] );
 */
// filter_hook function to react on sub_menu flag
function bfnest_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
	if ( empty( $args->sub_menu ) ) return $sorted_menu_items;
	$root_id = 0;

	// bfnest_pretty_print( $sorted_menu_items );
	// find the current menu item
	foreach ( $sorted_menu_items as $menu_item ) {
		// if ( ! empty( $menu_item->current ) ) {
		// checking also for menu_item->current_item_ancestor
		// needed for outputting sub menus on single posts
		// requires 'bfnest_wp_nav_menu_objects_current_post_type_archive_for_single' hook
		if ( ! empty( $menu_item->current ) || ! empty( $menu_item->current_item_ancestor ) ) {
			// set the root id based on whether the current menu item has a parent or not
			$root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
			break;
		}
	}

	// find the top level parent
	if ( ! isset( $args->direct_parent ) ) {
		$prev_root_id = $root_id;
		while ( $prev_root_id != 0 ) {
			foreach ( $sorted_menu_items as $menu_item ) {
				if ( $menu_item->ID == $prev_root_id ) {
					$prev_root_id = $menu_item->menu_item_parent;
					// don't set the root_id to 0 if we've reached the top of the menu
					if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
					break;
				}
			}
		}
	}

	$menu_item_parents = [];
	foreach ( $sorted_menu_items as $key => $item ) {
		// init menu_item_parents
		if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;

		if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
			// part of sub-tree: keep!
			$menu_item_parents[] = $item->ID;
		} else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
			// not part of sub-tree: away with it!
			unset( $sorted_menu_items[$key] );
		}
	}

	return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'bfnest_wp_nav_menu_objects_sub_menu', 10, 2 );



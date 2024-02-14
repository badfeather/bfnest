<?php
/**
 * Adds custom classes to the array of body classes.
 */
add_filter( 'body_class', 'bfnest_body_classes' );
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

	if ( is_singular() && has_blocks() ) {
		$classes[] = 'has-blocks';
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

/**
 * Modify archive prefixes
 * Defaults commented out - to modify, uncomment and modify
 */
//add_filter( 'get_the_archive_title_prefix', 'bfnest_archive_title_prefix' );
function bfnest_archive_title_prefix( $prefix ) {
//    if ( is_category() ) {
//        $prefix = _x( 'Category:', 'category archive title prefix' );
//
//    } elseif ( is_tag() ) {
//        $prefix = _x( 'Tag:', 'tag archive title prefix' );
//
//    } elseif ( is_author() ) {
//        $prefix = _x( 'Author:', 'author archive title prefix' );
//
//    } elseif ( is_year() ) {
//        $prefix = _x( 'Year:', 'date archive title prefix' );
//
//    } elseif ( is_month() ) {
//        $prefix = _x( 'Month:', 'date archive title prefix' );
//
//    } elseif ( is_day() ) {
//        $prefix = _x( 'Day:', 'date archive title prefix' );
//
//    } elseif ( is_post_type_archive() ) {
//        $prefix = _x( 'Archives:', 'post type archive title prefix' );
//
//    } elseif ( is_tax() ) {
//        $queried_object = get_queried_object();
//        if ( $queried_object ) {
//            $tax = get_taxonomy( $queried_object->taxonomy );
//            $prefix = sprintf(
//                /* translators: %s: Taxonomy singular name. */
//                _x( '%s:', 'taxonomy term archive title prefix' ),
//                $tax->labels->singular_name
//            );
//        }
//    }
    return $prefix;
}

/**
 * Add ARIA labels to wp_nav_menu items with children
 * Found here - https://www.kevinleary.net/accessible-dropdown-menus-for-wordpress/
 * See https://www.w3.org/WAI/tutorials/menus/flyout/
 */
add_filter( 'nav_menu_link_attributes', 'bfnest_wcag_nav_menu_link_attributes', 10, 4 );
function bfnest_wcag_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    // Add [aria-haspopup] and [aria-expanded] to menu items that have children
    $item_has_children = in_array( 'menu-item-has-children', $item->classes );
    if ( $item_has_children ) {
        $atts['aria-haspopup'] = "true";
        $atts['aria-expanded'] = "false";
    }

    return $atts;
}


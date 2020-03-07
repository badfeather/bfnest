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
 * Filter markup of get_the_archive_title()
 * Use for changing language of title, e.g. removing 'Category: ' prefix
 */
function bfnest_get_the_archive_title( $title ) {

    if ( is_category() ) {
        /* translators: Category archive title. %s: Category name. */
        //$title = sprintf( __( 'Category: %s' ), single_cat_title( '', false ) );
        $title = sprintf( __( '%s' ), single_cat_title( '', false ) );
    }
//    elseif ( is_tag() ) {
//        /* translators: Tag archive title. %s: Tag name. */
//        $title = sprintf( __( 'Tag: %s' ), single_tag_title( '', false ) );
//    } elseif ( is_author() ) {
//        /* translators: Author archive title. %s: Author name. */
//        $title = sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
//    } elseif ( is_year() ) {
//        /* translators: Yearly archive title. %s: Year. */
//        $title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
//    } elseif ( is_month() ) {
//        /* translators: Monthly archive title. %s: Month name and year. */
//        $title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
//    } elseif ( is_day() ) {
//        /* translators: Daily archive title. %s: Date. */
//        $title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
//    } elseif ( is_tax( 'post_format' ) ) {
//        if ( is_tax( 'post_format', 'post-format-aside' ) ) {
//            $title = _x( 'Asides', 'post format archive title' );
//        } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
//            $title = _x( 'Galleries', 'post format archive title' );
//        } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
//            $title = _x( 'Images', 'post format archive title' );
//        } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
//            $title = _x( 'Videos', 'post format archive title' );
//        } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
//            $title = _x( 'Quotes', 'post format archive title' );
//        } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
//            $title = _x( 'Links', 'post format archive title' );
//        } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
//            $title = _x( 'Statuses', 'post format archive title' );
//        } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
//            $title = _x( 'Audio', 'post format archive title' );
//        } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
//            $title = _x( 'Chats', 'post format archive title' );
//        }
//    } elseif ( is_post_type_archive() ) {
//        /* translators: Post type archive title. %s: Post type name. */
//        $title = sprintf( __( 'Archives: %s' ), post_type_archive_title( '', false ) );
//    } elseif ( is_tax() ) {
//        $queried_object = get_queried_object();
//        if ( $queried_object ) {
//            $tax = get_taxonomy( $queried_object->taxonomy );
//            /* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term. */
//            $title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
//        }
//    }

    return $title;
}
add_filter( 'get_the_archive_title', 'bfnest_get_the_archive_title' );

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

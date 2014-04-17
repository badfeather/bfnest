<?php
/**
 * Initial setup and constants
 */
function bfn_setup() {

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'bfn' ),
		'secondary' => __( 'Secondary Navigation', 'bfn' ),
		'social' => __( 'Social Navigation', 'bfn' )
	) );

	if ( ! isset( $content_width ) ) {
		$content_width = 1050;
	}

	add_theme_support('post-thumbnails');
	// set_post_thumbnail_size( 150, 150, false );
	// add_image_size( 'category-thumb', 300, 9999 ); // 300px wide (and unlimited height)

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	// Tell the TinyMCE editor to use a custom stylesheet
	//add_editor_style( '/assets/css/editor-style.css' );

	add_theme_support( 'automatic-feed-links' );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array(
		'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption'
	) );
}

add_action( 'after_setup_theme', 'bfn_setup' );

/**
 * Remove recent comments CSS from head
 */
add_action( 'widgets_init', 'bfn_remove_recent_comments_style' );

function bfn_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

/**
 * Clean up wp_title
 */
function bfn_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'bfn' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'bfn_wp_title', 10, 2 );

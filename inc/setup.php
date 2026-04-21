<?php
/**
 * Initial setup and constants
 */
add_action( 'after_setup_theme', 'bfnest_setup' );
function bfnest_setup() {
	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus( [
		'primary' => __( 'Primary Navigation', 'bfnest' ),
		'secondary' => __( 'Secondary Navigation', 'bfnest' ),
		'social' => __( 'Social Navigation', 'bfnest' ),
	] );

	// load_theme_textdomain( 'bfnest', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	// add_theme_support( 'post-formats', [ 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ] );

	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	// gutenberg/editor styles and options
	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor-style.css' );
}

/**
 * Set environment to 'development' if one isn't set in wp-config.php
 */
if ( ! defined( 'WP_ENVIRONMENT' ) ) {
    define( 'WP_ENVIRONMENT', 'development' );
}

/**
 * Set default theme options on theme switch
 */
add_action( 'after_switch_theme', 'bfnest_reading_options' );
function bfnest_reading_options() {
	update_option( 'posts_per_page', 12 );
	update_option( 'posts_per_rss', 12 );
}


/**
 * Disable comments
 * @see https://themesdna.com/blog/disable-comments-wordpress/
 */

// Close comments on the front-end
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

// Hide existing comments
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

// Function to disable comments throughout the site
//add_action( 'admin_init', 'bfnest_disable_comments_admin_init' );
function bfnest_disable_comments_admin_init() {
	// Redirect any user trying to access comments page
	global $pagenow;

	if ( $pagenow === 'edit-comments.php' ) {
		wp_redirect( admin_url() );
		exit;
	}

	// Remove comments metabox from dashboard
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

	// Disable support for comments and trackbacks in post types
	foreach ( get_post_types() as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}

// Remove comments page in menu
//add_action( 'admin_menu', 'bfnest_disable_comments_menu_page' );
function bfnest_disable_comments_menu_page() {
	remove_menu_page( 'edit-comments.php' );
}

// Function to remove comments links from admin bar
//add_action( 'init', 'bfnest_disable_comments_admin_bar' );
function bfnest_disable_comments_admin_bar() {
	if ( is_admin_bar_showing() ) {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
	}
}

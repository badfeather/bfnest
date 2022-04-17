<?php
/**
 * Initial setup and constants
 */
function bfnest_setup() {
	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'bfnest' ),
		'secondary' => __( 'Secondary Navigation', 'bfnest' ),
		'social' => __( 'Social Navigation', 'bfnest' ),
	) );

	// load_theme_textdomain( 'bfnest', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style'
	) );

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	// gutenberg/editor styles and options
	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor-style.css' );
}
add_action( 'after_setup_theme', 'bfnest_setup' );

/**
 * Set environment to 'development' if one isn't set in wp-config.php
 */
if ( ! defined( 'WP_ENVIRONMENT' ) ) {
    define( 'WP_ENVIRONMENT', 'development' );
}

/**
 * Set default theme options on theme switch
 */
function bfnest_reading_options() {
	update_option( 'posts_per_page', 12 );
	update_option( 'posts_per_rss', 12 );
}
add_action( 'after_switch_theme', 'bfnest_reading_options' );

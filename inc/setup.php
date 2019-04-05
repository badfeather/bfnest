<?php
/**
 * Initial setup and constants
 */
function bfnest_setup() {

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'bfnest' ),
		'follow' => __( 'Follow Navigation', 'bfnest' )
	) );

	load_theme_textdomain( 'bfnest', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	// gutenberg/editor styles and options
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	
	add_theme_support('disable-custom-font-sizes');
	
	// set custom palette to empty first, so it's removed for buttons as well
	add_theme_support( 'editor-color-palette', array() );
	add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'bfnest_setup' );

/**
 * Set default theme options on theme switch
 */
function bfnest_reading_options() {
	update_option( 'posts_per_page', 12 );
	update_option( 'posts_per_rss', 12 );
}
add_action( 'after_switch_theme', 'bfnest_reading_options' );

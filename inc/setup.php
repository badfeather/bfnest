<?php
/**
 * Initial setup and constants
 */
function nest_setup() {

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'nest' ),
		'follow' => __( 'Follow Navigation', 'nest' )
	) );

	load_theme_textdomain( 'nest', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	// Tell the TinyMCE editor to use a custom stylesheet
	// add_editor_style( '/assets/css/editor-style.css' );

}
add_action( 'after_setup_theme', 'nest_setup' );

/**
 * Set default theme options on theme switch
 */
function nest_reading_options() {
	update_option( 'posts_per_page', 12 );
	update_option( 'posts_per_rss', 12 );
}
add_action( 'after_switch_theme', 'nest_reading_options' );

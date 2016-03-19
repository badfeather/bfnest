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

	// let wordpress handle the title tag instead of hardcoding it in the header
	add_theme_support( 'title-tag' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	// add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Custom image sizes. Use the following format:
	// add_image_size( 'size-name', width [int], height [int], true/false [hard crop or not - defaults to false]);

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

/**
 * Remove recent comments style block from head
 */
function nest_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'nest_remove_recent_comments_style' );

/**
 * remove Emoji css and js calls from head
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

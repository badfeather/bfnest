<?php
/**
 * Initial setup and constants
 */
function nest_setup() {

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'nest' ),
	) );

	if ( ! isset( $content_width ) ) {
		$content_width = 690;
	}

  load_theme_textdomain( 'nest', get_template_directory() . '/languages' );

	// let wordpress handle the title tag instead of hardcoding it in the header
  add_theme_support( 'title-tag' );

  add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

  add_theme_support('post-thumbnails');

  // set default image sizes

	// add_image_size( 'category-thumb', 300, 9999 ); // 300px wide (and unlimited height)

  // set default image insertion options
	update_option( 'image_default_align', 'none' );
	update_option( 'image_default_link_type', 'none' );
	update_option( 'image_default_size', 'large' );

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	// Tell the TinyMCE editor to use a custom stylesheet
	//add_editor_style( '/assets/css/editor-style.css' );

}

add_action( 'after_setup_theme', 'nest_setup' );

/**
 * Remove recent comments CSS from head
 */
add_action( 'widgets_init', 'nest_remove_recent_comments_style' );

function nest_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

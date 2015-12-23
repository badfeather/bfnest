<?php
/**
 * Initial setup and constants
 */
function nest_setup() {

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'nest' ),
	) );

  load_theme_textdomain( 'nest', get_template_directory() . '/languages' );

	// let wordpress handle the title tag instead of hardcoding it in the header
  add_theme_support( 'title-tag' );

  add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

  add_theme_support('post-thumbnails');

  // set default image sizes

	// add_image_size( 'custom-size-name', 300, 9999 ); //  arguments are( 'size-name', width (int), height (int), true/false - hard crop or not, defaults to true )

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

	// Tell the TinyMCE editor to use a custom stylesheet
	//add_editor_style( '/assets/css/editor-style.css' );

}

add_action( 'after_setup_theme', 'nest_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function nest_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nest_content_width', 690 );
}
add_action( 'after_setup_theme', 'nest_content_width', 0 );

/**
 * Set default theme options on theme switch
 */
function nest_default_options() {
  update_option( 'thumbnail_size_w', 330 );
  update_option( 'thumbnail_size_h', 330 );
  update_option( 'thumbnail_crop', true );

  update_option( 'medium_size_w', 330 );
  update_option( 'medium_size_h', 800 );

	update_option( 'large_size_w', 690 );
	update_option( 'large_size_h', 1140 );

	update_option( 'embed_size_w', 690 );

	update_option( 'image_default_align', 'none' );
	update_option( 'image_default_link_type', 'none' ); // can be 'file', 'attachment'
	update_option( 'image_default_size', 'large' );

	update_option( 'posts_per_page', 12 );
	update_option( 'posts_per_rss', 12 );
}
add_action( 'after_switch_theme', 'nest_default_options' );

/**
 * Show custom image sizes in editor when inserting images
 * http://pippinsplugins.com/add-custom-image-sizes-to-media-uploader/
 */
function nest_show_custom_image_sizes( $sizes ) {
	$sizes['custom size name'] = __( 'Custom Size', 'nest' ); // add more like these as needed
  return $sizes;
}
// add_filter( 'image_size_names_choose', 'bf_show_custom_image_sizes' );

/**
 * Set gallery shortcode default options
 */
function nest_shortcode_atts_gallery( $out, $pairs, $atts ) {
    $atts = shortcode_atts( array(
    	'link' => 'file'
    ), $atts );
    $out['link'] = $atts['link'];
    return $out;
}
add_filter( 'shortcode_atts_gallery', 'nest_shortcode_atts_gallery', 10, 3 );

/**
 * Remove recent comments CSS from head
 */
function nest_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'nest_remove_recent_comments_style' );

/**
 * Disable default widgets
 */
function nest_unregister_default_wp_widgets() {
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Text' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
}
add_action( 'widgets_init', 'nest_unregister_default_wp_widgets', 1 );

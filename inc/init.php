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
	add_theme_support('html5', array(
		'search-form', 'comment-form', 'comment-list',
	));
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

/**
 * Swap <p> tags for <figure> tags when inserting images.
 * If it has a caption, this will be wrapped in <figcaption> tags
 */
function bfn_html5_image_send_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt ) {

	$wp_caption_class = '';
	if ( $caption ) {
		$wp_caption_class = ' wp-caption';
	}

	if ( $alt ) {
		$alt_text = $alt;
	} else {
		$alt_text = $title;
	}

	$img_tag = get_image_tag( $id, $alt_text, '', '', $size );

	if ( $url ) {
		$img_tag = '<a href="' . esc_attr( $url ) . '">' . $img_tag . '</a>';
	}

	$html5 = '<figure id="post-' . $id . ' media-' . $id . '" class="align' . $align . $wpcaption . ' size-' . $size . '">';
    $html5 .= $img_tag;
    if ( $caption ) {
    	$html5 .= '<figcaption class="caption wp-caption-text">' . $caption . '</figcaption>';
    }
    $html5 .= '</figure>';
    return $html5;
}
add_filter( 'image_send_to_editor', 'bfn_html5_image_send_to_editor', 10, 9 );

/**
 * Clean up wp_caption and make it html5
 * Replaced with above function
 */
/*
function bfn_caption( $output, $attr, $content ) {
  if ( is_feed() ) {
    return $output;
  }

  $defaults = array(
    'id'      => '',
    'align'   => 'alignnone',
    'width'   => '',
    'caption' => ''
  );

  $attr = shortcode_atts( $defaults, $attr );

  // If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
  if ( $attr['width'] < 1 || empty($attr['caption'] ) ) {
    return $content;
  }

  // Set up the attributes for the caption <figure>
  $attributes  = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
  $attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
  $attributes .= ' style="width: ' . (esc_attr($attr['width'])) . 'px"';

  $output  = '<figure' . $attributes .'>';
  $output .= do_shortcode($content);
  $output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
  $output .= '</figure>';

  return $output;
}
add_filter( 'bfn_caption_shortcode', 'roots_caption', 10, 3 );
*/


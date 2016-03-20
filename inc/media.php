<?php
/**
 * Add theme support for post thumbnails and add custom image sizes
 */
function nest_media_setup() {

	add_theme_support( 'post-thumbnails' );

	// Add custom image sizes - add_image_size( 'size-name', width [int], height [int], true/false [hard crop - defaults to false]);

	// Set image size 'post-thumbnail'. - set_post_thumbnail_size( width [int], height[int], true/false [hard crop - defaults to false] );
	set_post_thumbnail_size( 330, 9999, false );
}
add_action( 'after_setup_theme', 'nest_media_setup' );

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
 * Set default image sizes on theme switch
 */
function nest_media_options() {
	update_option( 'thumbnail_size_w', 330 );
	update_option( 'thumbnail_size_h', 9999 );
	update_option( 'thumbnail_crop', false );
	update_option( 'medium_size_w', 330 );
	update_option( 'medium_size_h', 9999 );
	update_option( 'medium_large_w', 690 );
	update_option( 'large_size_w', 1050 );
	update_option( 'large_size_h', 9999 );
}
add_action( 'after_switch_theme', 'nest_media_options' );

/**
 * Show custom image sizes in media uploader
 * Add custom sizes to $custom sizes array: 'sizename' => __( 'Size Name', 'nest' )
 */
function nest_image_size_names_choose( $sizes ) {
	$custom_sizes = array(
		'medium_large' => __( 'Medium Large', 'nest' ),
	);
	return array_merge( $sizes, $custom_sizes );
}
add_filter( 'image_size_names_choose', 'nest_image_size_names_choose' );

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
 * Wrap the inserted image html with <figure> or <div> element with additional size classes for styling purposes
 * Additional classes are 'entry__figure entry__figure--size-[sizename]'
 */
function nest_image_send_to_editor_with_figure( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
	if ( current_theme_supports( 'html5' )  && ! $caption ) {
	}
	if ( ! $caption ) {
		$el = 'div';

		if ( current_theme_supports( 'html5' ) ) {
			$el = 'figure';
		}

		$html = sprintf( '<%1$s class="entry__figure entry__figure--size-%2$s align%3$s">%4$s</%1$s>', $el, $size, $align, $html );
	}
	return $html;
}
add_filter( 'image_send_to_editor', 'nest_image_send_to_editor_with_figure', 10, 8 );


/**
 * Modified caption shortcode, adding size classes to wrapper element for styling purposes
 * Additional classes are 'entry__figure entry__figure--size-[sizename]'
 */
function nest_img_caption_shortcode( $na, $attr, $content ) {

	extract( shortcode_atts( array(
		'id'	  => '',
		'align'	  => 'alignnone',
		'width'	  => '',
		'caption' => '',
		'class'   => '',
	), $attr ) );

	if ( $width < 1 || empty( $caption ) ) {
		return $content;
	}

	if ( ! empty( $id ) ) {
		$id = 'id="' . esc_attr( sanitize_html_class( $id ) ) . '" ';
	}

	$add_classes = ' entry__figure';
	if ( preg_match( '/(size-[^\s]+)/', $content, $matches ) ) {
		$add_classes .= ' entry__figure--' . $matches[1];
	}

	$size = $matches[1];

	$class = trim( 'wp-caption ' . $align . ' ' . $class . $add_classes );

	$html5 = current_theme_supports( 'html5', 'caption' );

	$el = 'div';
	$caption_el = 'p';

	if ( $html5 ) {
		$el = 'figure';
		$caption_el = 'figcaption';
	}

	$html = '<' . $el . ' ' . $id . ' class="' . esc_attr( $class ) . '">'
		. do_shortcode( $content ) . '<' . $caption_el . ' class="wp-caption-text">' . $caption . '</' . $caption_el . '></' . $el . '>';

	return $html;
}
add_filter('img_caption_shortcode', 'nest_img_caption_shortcode', 10, 3 );


/**
 * Increase the max srcset limit - default is 1600
 */
function nest_max_srcset_image_width( $max_width, $size_array ) {
	$width = $size_array[0];

	if ( $width > 768 ) {
		$max_width = 2100;
	}

	return $max_width;
}
add_filter( 'max_srcset_image_width', 'nest_max_srcset_image_width', 10, 2 );

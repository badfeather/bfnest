<?php
/**
 * Add theme support for post thumbnails and add custom image sizes
 */
function bfnest_media_setup() {

	add_theme_support( 'post-thumbnails' );

	// Add custom image sizes - add_image_size( 'size-name', width [int], height [int], true/false [hard crop - defaults to false]);
	//add_image_size( 'thumbnail--lg', 356, 356, true );

	// Set image size 'post-thumbnail'. - set_post_thumbnail_size( width [int], height[int], true/false [hard crop - defaults to false] );
	set_post_thumbnail_size( 738, 492, true );
}
add_action( 'after_setup_theme', 'bfnest_media_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bfnest_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bfnest_content_width', 712 );
}
add_action( 'after_setup_theme', 'bfnest_content_width', 0 );

/**
 * Set default image sizes on theme switch
 */
function bfnest_media_options() {
	update_option( 'thumbnail_size_w', 258 );
	update_option( 'thumbnail_size_h', 172 );
	update_option( 'thumbnail_crop', true );
	update_option( 'medium_size_w', 354 );
	update_option( 'medium_size_h', 9999 );
	update_option( 'medium_large_w', 546 );
	update_option( 'large_size_w', 738 );
	update_option( 'large_size_h', 9999 );

	update_option( 'image_default_align', 'none' );
	update_option( 'image_default_link_type', 'file' );
	update_option( 'image_default_size', 'large' );
}
add_action( 'after_switch_theme', 'bfnest_media_options' );

/**
 * Show custom image sizes in media uploader
 * Add custom sizes to $custom sizes array: 'sizename' => __( 'Size Name', 'bfnest' )
 */
function bfnest_image_size_names_choose( $sizes ) {
	$custom_sizes = array(
		//'medium_large' => __( 'Medium Large', 'bfnest' ),
	);
	return array_merge( $sizes, $custom_sizes );
}
add_filter( 'image_size_names_choose', 'bfnest_image_size_names_choose' );

/**
 * Set gallery shortcode default options
 */
function bfnest_shortcode_atts_gallery( $out, $pairs, $atts ) {
		$atts = shortcode_atts( array(
			'link' => 'file'
		), $atts );
		$out['link'] = $atts['link'];
		return $out;
}
add_filter( 'shortcode_atts_gallery', 'bfnest_shortcode_atts_gallery', 10, 3 );

/**
 * Wrap the inserted image html with <figure> or <div> element with additional size classes for styling purposes
 * Additional classes are 'entry-figure entry-figure--size-[sizename]'
 */
function bfnest_image_send_to_editor_with_figure( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
	if ( ! $caption ) {
		$el = current_theme_supports( 'html5' ) ? 'figure' : 'div';

		$img_src = wp_get_attachment_image_src( $id, $size );
		$width = $img_src ? $img_src[1] : '';

		// to omit the inline style, return zero
		$figure_width = apply_filters( 'img_figure_width', $width );

		$style = $figure_width ? ' style="width: ' . esc_attr( $figure_width ) . 'px;"' : '';

		$html = sprintf( '<%1$s class="entry-figure entry-figure--size-%2$s align%3$s"%4$s>%5$s</%1$s>', $el, $size, $align, $style, $html );
	}
	return $html;
}
add_filter( 'image_send_to_editor', 'bfnest_image_send_to_editor_with_figure', 10, 8 );

/**
 * Modified caption shortcode, adding size classes to wrapper element for styling purposes
 * Additional classes are 'entry-figure entry-figure--size-[sizename]'
 */
function bfnest_img_caption_shortcode( $na, $attr, $content) {
	$atts = shortcode_atts(
		array(
			'id' => '',
			'caption_id' => '',
			'align' => 'alignnone',
			'width' => '',
			'caption' => '',
			'class' => '',
		),
		$attr,
		'caption'
	);

	$atts['width'] = (int) $atts['width'];
	if ( $atts['width'] < 1 || empty( $atts['caption'] ) ) {
		return $content;
	}

	$id = $caption_id = $describedby = '';

	if ( $atts['id'] ) {
		$atts['id'] = sanitize_html_class( $atts['id'] );
		$id = 'id="' . esc_attr( $atts['id'] ) . '" ';
	}

	if ( $atts['caption_id'] ) {
		$atts['caption_id'] = sanitize_html_class( $atts['caption_id'] );

	} elseif ( $atts['id'] ) {
		$atts['caption_id'] = 'caption-' . str_replace( '_', '-', $atts['id'] );
	}

	if ( $atts['caption_id'] ) {
		$caption_id  = 'id="' . esc_attr( $atts['caption_id'] ) . '" ';
		$describedby = 'aria-describedby="' . esc_attr( $atts['caption_id'] ) . '" ';
	}

	$classes = array( 'wp-caption', 'entry-figure', $atts['align'], $atts['class'] );

	if ( preg_match( '/(size-[^\s]+)/', $content, $matches ) ) {
		$classes[] = 'entry-figure--' . $matches[1];
	}

	$class = join( ' ', $classes );

	$html5 = current_theme_supports( 'html5', 'caption' );
	// HTML5 captions never added the extra 10px to the image width
	$width = $html5 ? $atts['width'] : ( 10 + $atts['width'] );

	/**
	 * Filters the width of an image's caption.
	 *
	 * By default, the caption is 10 pixels greater than the width of the image,
	 * to prevent post content from running up against a floated image.
	 *
	 * @since 3.7.0
	 *
	 * @see img_caption_shortcode()
	 *
	 * @param int	$width	Width of the caption in pixels. To remove this inline style,
	 *						 return zero.
	 * @param array  $atts	 Attributes of the caption shortcode.
	 * @param string $content  The image element, possibly wrapped in a hyperlink.
	 */
	$caption_width = apply_filters( 'img_caption_shortcode_width', $width, $atts, $content );

	$style = '';
	if ( $caption_width ) {
		$style = 'style="width: ' . (int) $caption_width . 'px" ';
	}

	if ( $html5 ) {
		$html = sprintf(
			'<figure %s%s%sclass="%s">%s%s</figure>',
			$id,
			$describedby,
			$style,
			esc_attr( $class ),
			do_shortcode( $content ),
			sprintf(
				'<figcaption %sclass="wp-caption-text">%s</figcaption>',
				$caption_id,
				$atts['caption']
			)
		);
	} else {
		$html = sprintf(
			'<div %s%sclass="%s">%s%s</div>',
			$id,
			$style,
			esc_attr( $class ),
			str_replace( '<img ', '<img ' . $describedby, do_shortcode( $content ) ),
			sprintf(
				'<p %sclass="wp-caption-text">%s</p>',
				$caption_id,
				$atts['caption']
			)
		);
	}

	return $html;
}
add_filter( 'img_caption_shortcode', 'bfnest_img_caption_shortcode', 10, 3 );

/**
 * Increase the max srcset limit - default is 1600
 */
function bfnest_max_srcset_image_width( $max_width, $size_array ) {
	$width = $size_array[0];

	if ( $width > 768 ) {
		$max_width = 2100;
	}

	return $max_width;
}
add_filter( 'max_srcset_image_width', 'bfnest_max_srcset_image_width', 10, 2 );

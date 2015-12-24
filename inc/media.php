<?php
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
 * Wrap the inserted image html with <figure>
 * if the theme supports html5 and the current image has no caption.
 */
function nest_insert_images_with_figure( $html, $id, $caption, $title, $align, $url, $size, $alt ) {

	if ( current_theme_supports( 'html5' ) ) {
		$wrapper = 'figure';
		$caption_wrapper = 'figcaption';

	} else {
		$wrapper = 'div';
		$caption_wrapper = 'div';
	}

	$id_att = '';
	if ( ! empty( $id ) ) {
		$id_att = 'id="' . esc_attr( sanitize_html_class( $id ) ) . '" ';
	}

	$caption_att = '';
	$caption_class = '';

	if ( $caption ) {
		$caption_att = '<' . $caption_wrapper . ' class="wp-caption-text">' . $caption . '</' . $caption_wrapper . '>';
		$caption_class = ' wp-caption';
	}

	$class_att = trim( 'align' . $align . $caption_class . ' entry__figure entry__figure--' . $size );

  $html = sprintf( '<%1$s %2$sclass="%3$s">%4$s%5$s</%1$s>',
  	$wrapper,
  	$id_att,
  	esc_attr( $class_att ),
  	$html,
  	$caption_att
  );

  return $html;
}
//add_filter( 'image_send_to_editor', 'nest_insert_images_with_figure', 10, 8 );

// Disable caption shortcode
//add_filter( 'disable_captions', create_function( '$a', 'return true;' ) );

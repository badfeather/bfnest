<?php
/**
 * Return SVG markup.
 *
 * @param  array  $args {
 *     Parameters needed to display an SVG.
 *
 *     @param string $icon Required. Use the icon filename, e.g. "facebook-square".
 *     @param string $title Optional. SVG title, e.g. "Facebook".
 *     @param string $desc Optional. SVG description, e.g. "Share this post on Facebook".
 * }
 * @return string SVG markup.
 */
function nest_get_svg( $args = array() ) {

	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', '_s' );
	}

	// YUNO define an icon?
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', '_s' );
	}

	// Set defaults.
	$defaults = array(
		'icon'  => '',
		'title' => '',
		'desc'  => ''
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Begin SVG markup
	$svg = '<svg class="icon icon-' . esc_html( $args['icon'] ) . '" aria-hidden="true">';

		// If there is a title, display it.
		if ( $args['title'] ) {
			$svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
		}

		// If there is a description, display it.
		if ( $args['desc'] ) {
			$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
		}

	$svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
	$svg .= '</svg>';

	return $svg;
}

/**
 * Display an SVG.
 *
 * @param  array  $args  Parameters needed to display an SVG.
 */
function nest_the_svg( $args = array() ) {
	echo nest_get_svg( $args );
}

/**
 * Get the first image from a post
 * Must be used within the loop
 * Use nest_get_first_image( $atts ) in template, much like get_the_post_thumbnail()
 * 'size' defaults to 'thumbnail'
 * Atts array defailts to:
 * 'output' => 'img' // can be either 'img' or 'url'
 * 'link' => false // if true, will link to full version of itself
 */
function nest_get_first_image( $size = 'thumbnail', $post_id = null, $atts = array() ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$defaults = array(
		'output' => 'img', // accepts either 'img' or 'url'
		'link' => false // ignored if output is set to url
	);

	$atts = wp_parse_args( $atts, $defaults );
	extract( $atts, EXTR_SKIP );

	$images = get_attached_media( 'image' );

	if ( count( $images ) > 0 ) {
		$image = array_shift( $images );
		$image_id = $image->ID;
		$img = wp_get_attachment_image( $image_id, $size );
		$img_src = wp_get_attachment_image_src( $image_id, $size );
		$img_url = $img_src[0];
		$img_full_url = wp_get_attachment_url( $image_id );
		$img_link = get_permalink( $image->post_parent );
		$img_title = $image->post_title;
		$img_caption = $image->post_excerpt;
		$img_desc = $image->post_content;

		if ( 'img' == $output ) {

			if ( $link ) {
				return '<a href="' . $img_full_url . '>">' . $img . '</a>';

			} else {
				return $img;

			} // endif $link

		} elseif ( 'url' == $output ) {
				return $img_url;
		} // endif $output - 'img'

	}

}

/**
 * Echoes the first image from a post using arguments from nest_get_first_image() function
 * Much like the_post_thumbnail
 */
function nest_first_image( $size = 'thumbnail', $post_id = null, $atts = array() ) {
	echo nest_get_first_image( $size, $post_id, $atts );
}

/**
 * Echoes the first image from a post using arguments from nest_get_first_image() function
 * Much like the_post_thumbnail
 */
function nest_get_first_image_url( $size = 'thumbnail', $post_id = null ) {
	return nest_get_first_image( $size, $post_id, $atts = array( 'output' => 'url' ) );
}

/**
 * Get featured or first image
 * must be used within the loop
 */
function nest_get_featured_or_first_image( $size = 'thumbnail', $post_id = null ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail( $post_id, $size );

	} else {
		return nest_get_first_image( $size, $post_id, $atts = array( 'output' => 'img' ) );
	}
}

/**
 * Featured or first image
 * must be used within the loop
 */
function nest_featured_or_first_image( $size = 'thumbnail',	 $post_id = null ) {
	echo nest_get_featured_or_first_image( $size, $post_id );
}

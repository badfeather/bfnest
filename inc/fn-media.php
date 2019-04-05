<?php

/**
 * Get the first image from a post
 * Must be used within the loop
 * Use bfnest_get_first_image( $atts ) in template, much like get_the_post_thumbnail()
 * 'size' defaults to 'thumbnail'
 * Atts array defailts to:
 * 'output' => 'img' // can be either 'img' or 'url'
 * 'link' => false // if true, will link to full version of itself
 */
function bfnest_get_first_image( $size = 'thumbnail', $post_id = null, $atts = array() ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$defaults = array(
		'output' => 'img', // accepts either 'img' or 'url'
		'link' => false // ignored if output is set to url
	);

	$atts = wp_parse_args( $atts, $defaults );
	extract( $atts, EXTR_SKIP );

	$images = get_attached_media( 'image' );

	if ( empty( $images ) || is_wp_error( $images ) ) {
		return false;

	} else {

		$image = array_shift( $images );
		$image_id = $image->ID;
		$img = wp_get_attachment_image( $image_id, $size );
		$img_src = wp_get_attachment_image_src( $image_id, $size );
		$img_url = $img_src[0];
		$img_full_url = wp_get_attachment_url( $image_id );
		//$img_link = get_permalink( $image->post_parent );
		//$img_title = $image->post_title;
		//$img_caption = $image->post_excerpt;
		//$img_desc = $image->post_content;

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

	return false;

}

/**
 * Echoes the first image from a post using arguments from bfnest_get_first_image() function
 * Much like the_post_thumbnail
 */
function bfnest_first_image( $size = 'thumbnail', $post_id = null, $atts = array() ) {
	echo bfnest_get_first_image( $size, $post_id, $atts );
}

/**
 * Echoes the first image from a post using arguments from bfnest_get_first_image() function
 * Much like the_post_thumbnail
 */
function bfnest_get_first_image_url( $size = 'thumbnail', $post_id = null ) {
	return bfnest_get_first_image( $size, $post_id, $atts = array( 'output' => 'url' ) );
}

/**
 * Get featured or first image
 * must be used within the loop
 */
function bfnest_get_featured_or_first_image( $size = 'thumbnail', $post_id = null ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail( $post_id, $size );

	} else {
		return bfnest_get_first_image( $size, $post_id, $atts = array( 'output' => 'img' ) );
	}
}

/**
 * Featured or first image
 * must be used within the loop
 */
function bfnest_featured_or_first_image( $size = 'thumbnail', $post_id = null ) {
	echo bfnest_get_featured_or_first_image( $size, $post_id );
}

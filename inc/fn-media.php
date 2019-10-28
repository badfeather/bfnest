<?php
/**
 * Get ID of first image from post
 * If no $post_id argument is supplied, must be used within the loop
 */
function bfnest_get_first_image_id( $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$images = get_attached_media( 'image', $post_id );

	if ( empty( $images ) || is_wp_error( $images ) ) {
		return false;
	}

	$image = array_shift( $images );
	return $image->ID;
}

/**
 * Get first image as <img ... /> tag
 * If no $post_id argument is supplied, must be used within the loop
 */
// Get function
function bfnest_get_first_image( $size = 'thumbnail', $post_id = null ) {
	$image_id = bfnest_get_first_image_id( $post_id );

	if ( ! $image_id ) {
		return false;
	}

	return wp_get_attachment_image( $image_id, $size );
}

// Echo function
function bfnest_first_image( $size = 'thumbnail', $post_id = null ) {
	echo bfnest_get_first_image( $size, $post_id );
}

/**
 * Get first image url
 * If no $post_id argument is supplied, must be used within the loop
 */
// Get function
function bfnest_get_first_image_url( $size = 'thumbnail', $post_id = null ) {
	$image_id = bfnest_get_first_image_id( $post_id );

	if ( ! $image_id ) {
		return false;
	}

	return wp_get_attachment_image_url( $image_id, $size );
}

// Echo function
function bfnest_first_image_url( $size = 'thumbnail', $post_id = null ) {
	echo bfnest_get_first_image_url( $size, $post_id );
}

/**
 * Get first image, linked to full image
 * If no $post_id argument is supplied, must be used within the loop
 */
// Get function
function bfnest_get_first_image_link( $size = 'thumbnail', $post_id = null ) {
	$image_id = bfnest_get_first_image_id( $post_id );

	if ( ! $image_id ) {
		return false;
	}

	return wp_get_attachment_link( $image_id, $size );
}

// Echo function
function bfnest_first_image_link( $size = 'thumbnail', $post_id = null ) {
	echo bfnest_get_first_image_link( $size, $post_id );
}

/**
 * Get id of featured or first image in post
 * If no $post_id argument is supplied, must be used within the loop
 */
function bfnest_get_featured_or_first_image_id( $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	return get_post_thumbnail_id( $post_id ) ? get_post_thumbnail_id( $post_id ) : bfnest_get_first_image_id( $post_id );
}

/**
 * Get featured or first image in post  as <img.. /> tag
 * If no $post_id argument is supplied, must be used within the loop
 */
// Get function
function bfnest_get_featured_or_first_image( $size = 'thumbnail', $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$image_id = bfnest_get_featured_or_first_image_id( $post_id );

	return $image_id ? wp_get_attachment_image( $image_id, $size ) : false;
}

// Echo function
function bfnest_featured_or_first_image( $size = 'thumbnail', $post_id = null ) {
	echo bfnest_get_featured_or_first_image( $size, $post_id );
}

/**
 * Get featured or first image in post  as <img.. /> tag
 * If no $post_id argument is supplied, must be used within the loop
 */
// Get function
function bfnest_get_featured_or_first_image_url( $size = 'thumbnail', $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$image_id = bfnest_get_featured_or_first_image_id( $post_id );

	return $image_id ? wp_get_attachment_image_url( $image_id, $size ) : false;
}

// Echo function
function bfnest_featured_or_first_image_url( $size = 'thumbnail', $post_id = null ) {
	echo bfnest_get_featured_or_first_image_url( $size, $post_id );
}

/**
 * Get featured or first image in post, linking to full image
 * If no $post_id argument is supplied, must be used within the loop
 */
// Get function
function bfnest_get_featured_or_first_image_link( $size = 'thumbnail', $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$image_id = bfnest_get_featured_or_first_image_id( $post_id );

	return $image_id ? wp_get_attachment_link( $image_id, $size ) : false;
}

// Echo function
function bfnest_featured_or_first_image_link( $size = 'thumbnail', $post_id = null ) {
	echo bfnest_get_featured_or_first_image_link( $size, $post_id );
}

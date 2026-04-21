<?php
/**
 * Add theme support for post thumbnails and add custom image sizes
 */
add_action( 'after_setup_theme', 'bfnest_media_setup' );
function bfnest_media_setup() {
	add_theme_support( 'post-thumbnails' );

	// Add custom image sizes - add_image_size( 'size-name', width [int], height [int], true/false [hard crop - defaults to false]);
	add_image_size( 'wide', 1410, 0, false );
	add_image_size( 'container', 1230, 0, false );

	// Set image size 'post-thumbnail'. - set_post_thumbnail_size( width [int], height[int], true/false [hard crop - defaults to false] );
	set_post_thumbnail_size( 450, 0, false );
}

/**
 * Set default image sizes on theme switch
 */
add_action( 'after_switch_theme', 'bfnest_media_options' );
function bfnest_media_options() {
	update_option( 'thumbnail_size_w', 450 );
	update_option( 'thumbnail_size_h', 0 );
	update_option( 'thumbnail_crop', false );
	update_option( 'medium_size_w', 680 );
	update_option( 'medium_size_h', 0 );
	update_option( 'medium_large_w', 930 );
	update_option( 'large_size_w', 1410 );
	update_option( 'large_size_h', 0 );

	//update_option( 'image_default_size', 'large' );
}

/**
 * Show custom image sizes in media uploader
 * Add custom sizes to $custom sizes array: 'sizename' => __( 'Size Name', 'bfnest' )
 */
add_filter( 'image_size_names_choose', 'bfnest_image_size_names_choose' );
function bfnest_image_size_names_choose( $sizes ) {
	$custom_sizes = [
		//'medium_large' => __( 'Medium Large', 'bfnest' ),
		'wide-uc' => __( 'Wide', 'bfnest' ),
		'container-uc' => __( 'Container', 'bfnest' ),
	];
	return array_merge( $sizes, $custom_sizes );
}


/**
 * Set gallery shortcode default options
 */
add_filter( 'shortcode_atts_gallery', 'bfnest_shortcode_atts_gallery', 10, 3 );
function bfnest_shortcode_atts_gallery( $out, $pairs, $atts ) {
		$atts = shortcode_atts( [
			'link' => 'file'
		], $atts );
		$out['link'] = $atts['link'];
		return $out;
}


/**
 * completely disable image size threshold
 */
// add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * increase the image size threshold from 2560 to specified number
 */
// add_filter( 'big_image_size_threshold', 'fg_big_image_size_threshold', 999, 1 );
function fg_big_image_size_threshold( $threshold ) {
	return 4000; // new threshold
}

/**
 * Disable threshold
 */
//add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * Increase the max srcset limit - default is 1600
 */
//add_filter( 'max_srcset_image_width', 'bfnest_max_srcset_image_width', 10, 2 );
function bfnest_max_srcset_image_width( $max_width, $size_array ) {
	$width = $size_array[0];

	if ( $width > 768 ) {
		$max_width = 2100;
	}

	return $max_width;
}


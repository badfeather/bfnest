<?php
function bfnest_gutenberg_setup() {
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'editor-font-sizes', array(
//	    array(
//	        'name' => __( 'Small', 'bfnest' ),
//	        'size' => 12,
//	        'slug' => 'small'
//	    ),
	    array(
	        'name' => __( 'Normal', 'bfnest' ),
	        'size' => 16,
	        'slug' => 'normal'
	    ),
//	    array(
//	        'name' => __( 'Large', 'bfnest' ),
//	        'size' => 36,
//	        'slug' => 'large'
//	    ),
//	    array(
//	        'name' => __( 'Huge', 'bfnest' ),
//	        'size' => 50,
//	        'slug' => 'huge'
//	    )
	) );

	// set custom palette to empty first, so it's removed for buttons as well
	add_theme_support( 'editor-color-palette', array() );
	add_theme_support( 'editor-color-palette' );
	add_theme_support( 'disable-custom-colors' );

	// Disable custom gradients.
	add_theme_support( 'editor-gradient-presets', array() );
	add_theme_support( 'disable-custom-gradients' );
}
add_action( 'after_setup_theme', 'bfnest_gutenberg_setup' );

/**
* Dequeue default block styles styles for Gutenberg
*/
add_action( 'enqueue_block_assets', function() {
	// Overwrite Core block styles with empty styles.
	wp_deregister_style( 'wp-block-library' );
	wp_register_style( 'wp-block-library', '' );

	// Overwrite Core theme styles with empty styles.
	wp_deregister_style( 'wp-block-library-theme' );
	wp_register_style( 'wp-block-library-theme', '' );
}, 10 );

/**
 * Enqueue editor assets
 */
function bfnest_gutenberg_scripts() {
	$template_directory = get_template_directory_uri();
	$version = fg_get_theme_version();

	wp_enqueue_script( 'fg-block-filters', $template_directory . '/assets/dist/js/block-filters.js', array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ), $version, true );
}
add_action( 'enqueue_block_editor_assets', 'bfnest_gutenberg_scripts' );

/**
 * Add block categories
 */
function bfnest_block_categories( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'bfnest-blocks',
				'title' => __( 'Bad Feather Nest Blocks', 'bfnest' ),
			),
		)
	);
}
add_filter( 'block_categories', 'bfnest_block_categories', 10, 2 );

/**
 * Register Blocks
 * @ see https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */
function bfnest_register_acf_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$supports = array(
	    'align'  => array( 'wide', 'full' ),
	    'anchor' => true,
	);

//	acf_register_block_type( array(
//		'name' => 'name', // unique identifier
//		'title' => __( 'Name', 'bfnest' ),
//		//'description' => __( 'Description', 'bfnest' ), // (optional)
//		'category' => 'bfnest-blocks', // options: 'common", 'formatting', 'layout', 'widgets', 'embed'
//		'icon' => 'book-alt', // use dashicons (https://developer.wordpress.org/resource/dashicons/) or custom svg
//		'post_types' => array( 'page' ),
//		'keywords' => array( 'testimonial', 'quote', 'mention', 'cite' ),
//		'mode' => 'preview', // options: 'preview' (default), 'auto', 'edit'
//		'align' => '', // options: '' (default), 'left', 'center', 'right', 'wide', 'full'
//		'supports' => $supports,
//		'render_callback' => 'bfnest_acf_block_render_callback',
//	) );

	acf_register_block_type( array(
		'name' => 'style-tester',
		'title' => __( 'Style Tester', 'bfnest' ),
		'description' => __( 'Displays various headline, type, form, and table styles for testing purposes.', 'bfnest' ),
		'category' => 'bfnest-blocks',
		'icon' => 'book-alt',
		'post_types' => array( 'page', 'post' ),
		'keywords' => array( 'starter' ),
		'mode' => 'preview',
		'align' => 'wide',
		'supports' => $supports,
		'render_callback' => 'bfnest_acf_block_render_callback',
	) );
}
add_action('acf/init', 'bfnest_register_acf_blocks' );

/**
 * Our callback function – this looks for the block based on its given name.
 * Name accordingly to the file name!
 */
function bfnest_acf_block_render_callback( $block ) {
	$block_slug = str_replace( 'acf/', '', $block['name'] );

	if ( file_exists( get_theme_file_path( '/partials/block-' . $block_slug . '.php' ) ) ) {
		include get_theme_file_path( '/partials/block-' . $block_slug . '.php' );
	}
}


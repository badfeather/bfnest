<?php
/**
 * Enable/disable features
 */
function bfnest_blocks_setup() {
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'editor-color-palette', [] );

	add_theme_support( 'disable-custom-gradients' );
	add_theme_support( 'editor-gradient-presets', [] );

	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'editor-font-sizes', [] );

	remove_theme_support( 'block-templates' );
	remove_theme_support( 'core-block-patterns' );

	add_theme_support( 'custom-units', [] );
}
add_action( 'after_setup_theme', 'bfnest_blocks_setup' );

/**
 * Dequeue default block styles
 */
// remove them on the back-end
function bfnest_block_assets() {
	wp_deregister_style( 'wp-block-library' );
	wp_register_style( 'wp-block-library', '' );
}
add_action( 'enqueue_block_assets', 'bfnest_block_assets' );

// remove them on the front-end
function bfnest_block_scripts() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'bfnest_block_scripts' );

/**
 * Enqueue editor assets
 */
function bfnest_block_editor_assets() {
	$template_directory = get_template_directory_uri();
	$version = bfnest_get_theme_version();

	wp_enqueue_script( 'fg-block-filters', $template_directory . '/js/blockfilters.js', array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ), $version, true );
}
add_action( 'enqueue_block_editor_assets', 'bfnest_block_editor_assets' );

/**
 * Modify block editor settings
 * @see https://developer.wordpress.org/reference/hooks/block_editor_settings_all/
 */
function bfnest_block_editor_settings( $editor_settings, $editor_context ) {
	$editor_settings['__experimentalFeatures']['color']['background'] = false;
	$editor_settings['__experimentalFeatures']['color']['customDuotone'] = false;
	$editor_settings['__experimentalFeatures']['color']['duotone'] = [];
	$editor_settings['__experimentalFeatures']['color']['gradients'] = [];
	$editor_settings['__experimentalFeatures']['color']['palette'] = [];
	$editor_settings['__experimentalFeatures']['color']['text'] = [];
    $editor_settings['__experimentalFeatures']['typography']['dropCap'] = false;
	$editor_settings['__experimentalFeatures']['typography']['fontSizes'] = [];
	$editor_settings['__experimentalFeatures']['typography']['fontStyle'] = false;
	$editor_settings['__experimentalFeatures']['typography']['fontWeight'] = false;
	$editor_settings['__experimentalFeatures']['typography']['letterSpacing'] = false;
	$editor_settings['__experimentalFeatures']['typography']['textDecoration'] = false;
	$editor_settings['__experimentalFeatures']['typography']['textTransform'] = false;
	$editor_settings['__experimentalFeatures']['blocks']['core/button']['border']['radius'] = false;
	$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border']['color'] = false;
	$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border']['radius'] = false;
	$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border']['style'] = false;
	$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border']['width'] = false;

	// nuclear option
	// $editor_settings['__experimentalFeatures'] = [];

	// debugging
	// bfnest_pretty_print($editor_settings);

	return $editor_settings;
}
add_filter( 'block_editor_settings_all', 'bfnest_block_editor_settings', 10, 2 );

// disable duotone support
remove_filter( 'render_block', 'wp_render_duotone_support', 10, 2 );

// remove inline .wp-container-xyz styles
remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );

// remove global svg filters
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

// remove global styles
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

// remove_action( 'enqueue_block_editor_assets', 'enqueue_editor_block_styles_assets' );
// remove_action( 'enqueue_block_editor_assets', 'enqueue_editor_block_styles_assets' );
// remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
// remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_global_styles_css_custom_properties' );

// remove global styles custom properties and svg filters from the back-end
remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );

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
add_filter( 'block_categories_all', 'bfnest_block_categories', 10, 2 );

/**
 * Register Blocks
 * @ see https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */
function bfnest_register_acf_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

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
		'align' => '',
		'supports' => array(
			'align' => array( 'wide', 'full' ),
			'anchor' => true
		),
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


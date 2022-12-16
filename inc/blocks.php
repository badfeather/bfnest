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

	add_theme_support( 'disable-layout-styles' );
	add_theme_support( 'custom-units', [] );

	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'bfnest_blocks_setup' );

/**
 * Dequeue default block styles
 */
// remove them on the back-end
function bfnest_block_assets() {
	wp_deregister_style( 'wp-block-library' );
	wp_register_style( 'wp-block-library', '' );
	// wp_deregister_style( 'wp-edit-blocks' );
	// wp_register_style( 'wp-edit-blocks', '' );
}
add_action( 'enqueue_block_assets', 'bfnest_block_assets' );

// remove them on the front-end
function bfnest_block_scripts() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'bfnest_block_scripts', 100 );

/**
 * Enqueue editor assets
 */
function bfnest_block_editor_assets() {
	$template_directory = get_template_directory_uri();
	$version = bfnest_get_theme_version();

	wp_enqueue_script( 'bfnest-block-filters', $template_directory . '/js/block-filters.js', [ 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ], $version, true );
}
add_action( 'enqueue_block_editor_assets', 'bfnest_block_editor_assets' );

/**
 * Modify block editor settings
 * @see https://developer.wordpress.org/reference/hooks/block_editor_settings_all/
 */
function bfnest_block_editor_settings( $editor_settings, $editor_context ) {
	// debugging - useful to see what features are enabled
	// bfnest_pretty_print($editor_settings);

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

	return $editor_settings;
}
// add_filter( 'block_editor_settings_all', 'bfnest_block_editor_settings', 10, 2 );

// disable duotone support
remove_filter( 'render_block', 'wp_render_duotone_support', 10, 2 );

// remove inline .wp-container-xyz styles
remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );

// remove link styles
remove_filter( 'render_block', 'wp_render_elements_support', 10, 2 );
remove_filter( 'render_block', 'gutenberg_render_elements_support', 10, 2 );

// remove global svg filters
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );

// remove global styles
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

/**
 * Add block categories
 */
function bfnest_block_categories( $categories, $post ) {
	return array_merge(
		$categories,
		[
			[
				'slug' => 'bfnest-blocks',
				'title' => __( 'Bad Feather Nest Blocks', 'bfnest' ),
			],
		]
	);
}
add_filter( 'block_categories_all', 'bfnest_block_categories', 10, 2 );

/**
 * Register Blocks
 */
function bfnest_register_acf_blocks() {
	foreach ( glob( get_stylesheet_directory() . "/blocks/*/block.json" ) as $file ) {
    	register_block_type( $file );
	}
}
add_action( 'init', 'bfnest_register_acf_blocks' );

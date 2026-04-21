<?php
/**
 * Enable/disable features
 */
add_action( 'after_setup_theme', 'bfnest_blocks_setup' );
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


/**
 * Dequeue default block styles
 */
// remove them on the back-end
//add_action( 'enqueue_block_assets', 'bfnest_block_assets' );
function bfnest_block_assets() {
	wp_deregister_style( 'wp-block-library' );
	wp_register_style( 'wp-block-library', '' );
	// wp_deregister_style( 'wp-edit-blocks' );
	// wp_register_style( 'wp-edit-blocks', '' );
}

// remove them on the front-end
add_action( 'wp_enqueue_scripts', 'bfnest_block_scripts', 100 );
function bfnest_block_scripts() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
}

/**
 * Enqueue editor assets
 */
add_action( 'enqueue_block_editor_assets', 'bfnest_block_editor_assets' );
function bfnest_block_editor_assets() {
	$template_directory = get_template_directory_uri();
	$version = bfnest_get_theme_version();

	wp_enqueue_script( 'bfnest-block-filters', $template_directory . '/js/block-filters.js', [ 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ], $version, true );
}


//----
// from https://www.cabgfx.com/disable-gutenberg-block-styles/
//remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
//remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
//remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
//
//add_action( 'wp_enqueue_scripts', function() {
//	// https://github.com/WordPress/gutenberg/issues/36834
//	wp_dequeue_style( 'wp-block-library' );
//	wp_dequeue_style( 'wp-block-library-theme' );
//
//	// https://stackoverflow.com/a/74341697/278272
//	wp_dequeue_style( 'classic-theme-styles' );
//
//	// Or, go deep: https://fullsiteediting.com/lessons/how-to-remove-default-block-styles
//} );


// disable duotone support
// remove_filter( 'render_block', 'wp_render_duotone_support', 10, 2 );

// remove inline .wp-container-xyz styles
// remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
// remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );

// remove link styles
// remove_filter( 'render_block', 'wp_render_elements_support', 10, 2 );
// remove_filter( 'render_block', 'gutenberg_render_elements_support', 10, 2 );

// remove global svg filters
// remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
// remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );

// remove global styles
 remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
 remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

// To test which global styles are being set on a page/post, use the following on a single template
// bfnest_pretty_print( wp_get_global_settings() );
// bfnest_pretty_print( wp_get_global_styles() );

/**
 * Add block categories
 */
add_filter( 'block_categories_all', 'bfnest_block_categories', 10, 2 );
function bfnest_block_categories( $categories, $post ) {
	return array_merge(
		[
			[
				'slug' => 'bfnest',
				'title' => __( 'BF Nest Blocks', 'bfnest' ),
			],
		],
		$categories
	);
}

/**
 * Register Blocks
 */
add_action( 'init', 'bfnest_register_blocks' );
function bfnest_register_blocks() {
	foreach ( glob( get_stylesheet_directory() . "/blocks/*/block.json" ) as $file ) {
		register_block_type( $file );
	}
}

/**
 * Forces separate loading of all block stylesheets.
 * https://developer.wordpress.org/reference/hooks/should_load_separate_core_block_assets/
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

/**
 * Enqueue and/or override block CSS from files in '/css/blocks/'.
 * Subfolders are used for the namespace, e.g. '/core/[block-name]' or '/acf/[block-name]'
 * @return void
 */
add_filter( 'init', 'bfnest_enqueue_block_stylesheets', 10, 1 );
function bfnest_enqueue_block_stylesheets() {
	$dir = get_stylesheet_directory() . '/css/blocks/';
	$version = bfnest_get_theme_version();
	$is_debug = bfnest_is_debug();
	$pattern = $is_debug ? '**/*[!.min].css' : '**/*.min.css';
	$suffix = $is_debug ? '.css' : '.min.css';
	foreach ( glob( $dir . $pattern, GLOB_MARK ) as $file ) {
		$block_name = str_replace( $dir, '', $file );
		// skip if core block
		//if ( str_contains( $block_name, 'core/' ) ) continue;
		$block_name = str_replace( $suffix, '', $block_name );
		$args = [
			'handle' => 'bfnest-' . basename( $block_name ),
			'src' => str_replace( get_stylesheet_directory(), get_stylesheet_directory_uri(), $file ),
			'path' => $file,
			'version' => $version,
		];
		wp_enqueue_block_style( $block_name, $args );
	}
}

/**
 * Replace core block stylesheets with theme stylesheets in the /css/block/core/ directory
 */
// front-end
add_action( 'wp_enqueue_scripts', 'bfnest_replace_core_block_stylesheets' );
// editor
add_action( 'enqueue_block_editor_assets', 'bfnest_replace_core_block_stylesheets' );
function bfnest_replace_core_block_stylesheets() {
	$dir = get_stylesheet_directory() . '/css/blocks/core/';
	$version = bfnest_get_theme_version();
	$is_debug = bfnest_is_debug();
	$pattern = $is_debug ? '*[!.min].css' : '*.min.css';
	$suffix = $is_debug ? '.css' : '.min.css';
	foreach ( glob( $dir . $pattern, GLOB_MARK ) as $file ) {
		$block_name = str_replace( $dir, '', $file );
		$block_name = str_replace( $suffix, '', $block_name );
		$block_name = 'wp-block-' . $block_name;
		wp_deregister_style( $block_name );
		wp_register_style( $block_name, str_replace( get_stylesheet_directory(), get_stylesheet_directory_uri(), $file ), [], $version );
		wp_style_add_data( $block_name, 'path', $file );
	}
}


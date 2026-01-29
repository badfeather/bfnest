<?php
/**
 * Get all include files for the theme
 */
function bfnest_get_theme_requires() {
	$requires = [
		'setup.php',
		'scripts.php',
		'widgets.php',
		'custom-content.php',
		'blocks.php',
		'media.php',
		'hooks.php',
		'fn-comments.php',
		'fn-media.php',
		'fn-meta.php',
		'fn-nav.php',
		'fn-post.php',
		'fn-shortcodes.php',
		'svg-icons.php',
		'fn-custom.php',
	];

	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		$requires[] = 'woocommerce.php';
	}

	if ( is_plugin_active( 'jetpack/jetpack.php' ) ) {
		$requires[] = 'jetpack.php';
	}

	if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
		$requires[] = 'yoast.php';
	}

	return $requires;
}

foreach ( bfnest_get_theme_requires() as $require ) {
	require trailingslashit( get_template_directory() . '/inc/' ) . $require;
}

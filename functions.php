<?php
/**
 * Get all include files for the theme
 */
function bfnest_get_theme_requires() {
	$requires = [
		'/inc/setup.php',
		'/inc/scripts.php',
		'/inc/widgets.php',
		'/inc/custom-content.php',
		'/inc/blocks.php',
		'/inc/media.php',
		'/inc/hooks.php',
		'/inc/fn-comments.php',
		'/inc/fn-media.php',
		'/inc/fn-meta.php',
		'/inc/fn-nav.php',
		'/inc/fn-post.php',
		'/inc/fn-shortcodes.php',
		'/inc/svg-icons.php',
		'/inc/fn-custom.php',
	];

	if ( class_exists( 'woocommerce' ) ) {
		$requires[] = '/inc/woocommerce.php';
	}
	return $requires;
}

foreach ( bfnest_get_theme_requires() as $require ) {
	require trailingslashit( get_template_directory() ) . $require;
}

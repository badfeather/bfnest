<?php
/**
 * Enqueue/dequeue block assets
 */
function bfnest_enqueue_block_assets() {
	wp_enqueue_script(
		'bfnest-block-filters',
		get_template_directory_uri() . '/assets/dist/js/block-filters.js',
		['wp-blocks']
	);

	// Overwrite Core block styles with empty styles.
	wp_deregister_style( 'wp-block-library' );
	wp_register_style( 'wp-block-library', '' );

	// Overwrite Core theme styles with empty styles.
	wp_deregister_style( 'wp-block-library-theme' );
	wp_register_style( 'wp-block-library-theme', '' );
}
add_action( 'enqueue_block_assets', 'bfnest_enqueue_block_assets' );

/**
 * Turn on/off core block types
 */
function bfnest_allowed_block_types( $allowed_blocks, $post ) {

	$allowed_blocks = array(
		// common
		'core/paragraph',
		'core/image',
		'core/heading',
		'core/gallery',
		'core/list',
		'core/quote',
		'core/audio',
		'core/cover',
		'core/file',
		'core/video',
		// formatting
		'core/table',
		'core/verse',
		'core/code',
		'core/freeform', // classic
		'core/html',
		'core/preformatted',
		'core/pullquote',
		// layout
		'core/button',
		'core/text-columns',
		'core/media-text',
		'core/more',
		'core/next-page',
		'core/separator',
		'core/spacer',
		//widgets
		'core/shortcode',
//		'core/archives',
//		'core/categories',
//		'core/latest-posts',
//		'core/calendar',
//		'core/rss',
		'core/search',
//		'core/tag-cloud',
		// embeds
		'core/core-embed',
		// see all embed options to turn on/off individually

	);

//	if( $post->post_type === 'page' ) {
//		$allowed_blocks[] = 'core/shortcode';
//	}

	return $allowed_blocks;

}
add_filter( 'allowed_block_types', 'bfnest_allowed_block_types', 10, 2 );


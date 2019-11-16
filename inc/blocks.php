<?php
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
//		'render_template' => 'partials/block-name.php', // path to template
//	) );
}
//add_action('acf/init', 'bfnest_register_acf_blocks' );


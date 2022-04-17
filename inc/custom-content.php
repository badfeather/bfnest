<?php
/**
 * Register Custom Post Types and Taxonomies
 */
function bfnest_custom_init() {

	// CUSTOM TAXOMONIES
	// register_taxonomy(
	// 	'bfnest-tax',
	// 	array( 'bfnest-type' ),
	// 	array(
	// 		'label' => __( 'Taxes', 'bfnest' ),
	// 		'labels' => array(
	// 			'singular_name' => __( 'Tax', 'bfnest' ),
	// 			'search_items' => __( 'Search Taxes', 'bfnest' ),
	// 			'all_items' => __( 'All Taxes', 'bfnest' ),
	// 			'parent_item_colon' => __( 'Parent Tax:', 'bfnest' ),
	// 			'edit_item' => __( 'Edit Tax', 'bfnest' ),
	// 			'view_item' => __( 'View Tax', 'bfnest' ),
	// 			'update_item' => __( 'Update Tax', 'bfnest' ),
	// 			'add_new_item' => __( 'Add New Tax', 'bfnest' ),
	// 			'new_item_name' => __( 'New Tax Name', 'bfnest' ),
	// 			'not_found' => __( 'No Taxes Found', 'bfnest' ),
	// 			'no_terms' => __( 'No Taxes', 'bfnest' ),
	// 		),
	// 		'show_in_rest' => true, // Defaults to false
	// 		'public' => true,
	// 		'hierarchical' => true,
	// 		'show_admin_column' => true, // (bool) Defaults to false
	// 		'rewrite' => array(
	// 			'slug' => 'types/tax',
	// 			'hierarchical' => true,
	// 		),
	// 	)
	// );

	// CUSTOM POST TYPES
	// register_post_type(
	// 	'bfnest-type',
	// 	array(
	// 		'label' => __( 'Types', 'bfnest' ),
	// 		'labels' => array(
	// 			'singular_name' => __( 'Type', 'bfnest' ),
	// 			'add_new_item' => __( 'Add New Type', 'bfnest' ),
	// 			'edit_item' => __( 'Edit Type', 'bfnest' ),
	// 			'new_item' => __( 'New Type', 'bfnest' ),
	// 			'view_item' => __( 'View Type', 'bfnest' ),
	// 			'search_items' => __( 'Search Types', 'bfnest' ),
	// 			'not_found' => __( 'No Types Found', 'bfnest' ),
	// 			'not_found_in_trash' => __( 'No Types Found in Trash', 'bfnest' ),
	// 			'parent_item_colon' => __( 'Parent Type:', 'bfnest' ),
	// 			'all_items' => __( 'All Types', 'bfnest' ),
	// 		),
	// 		'show_in_rest' => true,
	// 		'public' => true,
	// 		'hierarchical' => false,
	// 		'supports' => array(
	// 			'title',
	// 			'editor',
	// 			// 'comments',
	// 			// 'revisions',
	// 			// 'trackbacks',
	// 			// 'author',
	// 			// 'excerpt',
	// 			// 'page-attributes',
	// 			// 'thumbnail',
	// 			// 'custom-fields',
	// 			// 'post-formats'
	// 		),
	// 		'taxonomies' => array(),
	// 		'has_archive' => true,
	// 		'rewrite' => array(
	// 			'slug' => 'types'
	// 		),
	// 	)
	// );
}
// add_action( 'init', 'bfnest_custom_init' );

/**
 * Flush rewrite rules on activation
 */
function bfnest_rewrite_flush() {
	bfnest_custom_init();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'bfnest_rewrite_flush' );

/**
 * Set default terms for custom post types on save
 */
function bfnest_set_default_object_terms( $post_id, $post ) {
	if ( 'publish' === $post->post_status ) {
		// change `tax` to custom taxonomy key and term slug to whatever you want it to be
		// add additional taxonomies to array as you see fit
		$defaults = array(
			'tax' => array( 'uncategorized' ),
			//'another-tax' => array( 'term-1', 'term-2' ),
		);
		$taxonomies = get_object_taxonomies( $post->post_type );
		foreach ( (array) $taxonomies as $taxonomy ) {
			$terms = wp_get_post_terms( $post_id, $taxonomy );
			if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
				wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
			}
		}
	}
}
// add_action( 'save_post', 'bfnest_set_default_object_terms', 100, 2 );


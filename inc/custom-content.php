<?php
/**
 * Register Custom Post Types and Taxonomies
 */
function bfnest_custom_init() {

	// CUSTOM TAXOMONIES
	// register_taxonomy(
	// 	'bfnest-term',
	// 	[ 'bfnest-type' ],
	// 	[
	// 		'label' => __( 'Terms', 'bfnest' ),
	// 		'labels' => [
	// 			'singular_name' => __( 'Term', 'bfnest' ),
	// 			'search_items' => __( 'Search Terms', 'bfnest' ),
	// 			'all_items' => __( 'All Terms', 'bfnest' ),
	// 			'parent_item_colon' => __( 'Parent Term:', 'bfnest' ),
	// 			'edit_item' => __( 'Edit Term', 'bfnest' ),
	// 			'view_item' => __( 'View Term', 'bfnest' ),
	// 			'update_item' => __( 'Update Term', 'bfnest' ),
	// 			'add_new_item' => __( 'Add New Term', 'bfnest' ),
	// 			'new_item_name' => __( 'New Term Name', 'bfnest' ),
	// 			'not_found' => __( 'No Terms Found', 'bfnest' ),
	// 			'no_terms' => __( 'No Terms', 'bfnest' ),
	// 		],
	// 		'show_in_rest' => true, // Defaults to false
	// 		'public' => true,
	// 		'hierarchical' => true,
	// 		'show_admin_column' => true, // (bool) Defaults to false
	// 		'rewrite' => [
	// 			'slug' => 'types/term',
	// 			'hierarchical' => true,
	// 		],
	// 	]
	// );

	// CUSTOM POST TYPES
	// register_post_type(
	// 	'bfnest-type',
	// 	[
	// 		'label' => __( 'Types', 'bfnest' ),
	// 		'labels' => [
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
	// 		],
	// 		'show_in_rest' => true,
	// 		'public' => true,
	// 		'hierarchical' => false,
	// 		'supports' => [
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
	// 		],
	// 		'taxonomies' => [],
	// 		'has_archive' => true,
	// 		'rewrite' => [
	// 			'slug' => 'types'
	// 		],
	// 	]
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
 * Modify main queries
 */
function bfnest_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
}
// add_action( 'pre_get_posts', 'bfnest_pre_get_posts', 1 );

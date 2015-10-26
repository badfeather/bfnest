<?php
/**
 * Register Custom Post Types and Taxonomies
 */
add_action( 'init', 'nest_custom_init' );

function nest_custom_init() {

  // CUSTOM TAXOMONIES
  register_taxonomy(
		'nest-tax', // Taxonomy key - namespaced
		array( 'nest-type' ),
		array(
			'label' => __( 'Taxes', 'nest' ),
			'labels' => array(
			  'singular_name' => __( 'Tax', 'nest' ),
			  'search_items' => __( 'Search Taxes', 'nest' ),
			  // 'popular_items' => __( 'Popular Tags', 'nest' ), // This string isn’t used on hierarchical taxonomies.
			  'all_items' => __( 'All Taxes', 'nest' ),
			  'parent_item' => __( 'Parent Tax', 'nest' ), // This string isn’t used on non-hierarchical taxonomies.
			  'parent_item_colon' => __( 'Parent Tax:', 'nest' ),
			  'edit_item' => __( 'Edit Tax', 'nest' ),
			  'view_item' => __( 'View Tax', 'nest' ),
			  'update_item' => __( 'Update Tax', 'nest' ),
			  'add_new_item' => __( 'Add New Tax', 'nest' ),
			  'new_item_name' => __( 'New Tax Name', 'nest' ),
			  // 'separate_items_with_commas' => __( 'Separate taxes with commas', 'nest' ), // This string isn’t used on hierarchical taxonomies.
			  // 'add_or_remove_items' => __( 'Add or remove taxes', 'nest' ), // This string isn’t used on hierarchical taxonomies.
			  // 'choose_from_most_used' => __( 'Choose from the most used taxes', 'nest' ), // This string isn’t used on hierarchical taxonomies.
			  'not_found' => __( 'No taxes found', 'nest' ),
			  'no_terms' => __( 'No taxes', 'nest' ),
			),
			'public' => true, // Defaults to true
			'hierarchical' => true, // (bool) Defaults to false.
			'show_admin_column' => true, // (bool) Defaults to false.
			'rewrite' => array(
				'slug' => 'types/tax'
			),
		)
	);

	// CUSTOM POST TYPES
	register_post_type(
		'nest-type', // Post type key - namespaced
		array(
	    'label' => __( 'Types', 'nest' ),
	    'labels' => array(
				'singular_name' => __( 'Type', 'nest' ),
				'add_new_item' => __( 'Add New Type', 'nest' ),
				'edit_item' => __( 'Edit Type', 'nest' ),
				'new_item' => __( 'New Type', 'nest' ),
				'view_item' => __( 'View Type', 'nest' ),
				'search_items' => __( 'Search Types', 'nest' ),
				'not_found' => __( 'No types found', 'nest' ),
				'not_found_in_trash' => __( 'No types found in Trash', 'nest' ),
				// 'parent_item_colon' => __( 'Parent Type', 'nest' ), //This string isn’t used on non-hierarchical types.
				'all_items' => __( 'All Types', 'nest' ),
	    ),
	    'public' => true,
	    'hierarchical' => false, // (bool) Default false.
	    'exclude_from_search' => false, // (bool) Default is the opposite value of $public.
	    'menu_position' => null, // (int) Default null (at the bottom).
	    'supports' => array(
				'title', // default
				'editor', // default
				// 'comments',
				// 'revisions',
				// 'trackbacks',
				// 'author',
				// 'excerpt',
				// 'page-attributes',
				// 'thumbnail',
				// 'custom-fields',
				// 'post-formats'
	    ),
	    'taxonomies' => array(),
	    'has_archive' => false, // (bool) Default is false.
	    'rewrite' => array(
		    'slug' => 'types'
	    ),
		)
	);

}

/**
 * Flush rewrite rules on activation
 */
function nest_rewrite_flush() {
    nest_custom_init();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'nest_rewrite_flush' );
<?php
/*
Template Name: Redirect To First Child
*/

global $post;
$page_children = get_pages( array(
	'child_of' => $post->ID,
	'sort_column' => 'menu_order'
) );
$first_child = $page_children[0];

wp_redirect( get_permalink( $first_child->ID ) );
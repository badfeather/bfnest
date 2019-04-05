<?php
/*
Template Name: Redirect To First Child
*/

$page_children = get_pages( array(
	'child_of' => get_the_ID(),
	'sort_column' => 'menu_order'
) );
$first_child = $page_children[0];

wp_redirect( get_permalink( $first_child->ID ) );
<?php

/**
 * Register widgetized area and update sidebar with default widgets
 */
function nest_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Global', 'nest' ),
		'id' => 'global',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">' . "\n\t",
		'after_widget' => '</aside>' . "\n",
		'before_title' => '<h2 class="widget__title">',
		'after_title' => '</h2>' . "\n",
	) );

	register_sidebar( array(
		'name' => __( 'Page', 'nest' ),
		'id' => 'page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">' . "\n\t",
		'after_widget' => '</aside>' . "\n",
		'before_title' => '<h2 class="widget__title">',
		'after_title' => '</h2>' . "\n",
	) );

	register_sidebar( array(
		'name' => __( 'Single', 'nest' ),
		'id' => 'single',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">' . "\n\t",
		'after_widget' => '</aside>' . "\n",
		'before_title' => '<h2 class="widget__title">',
		'after_title' => '</h2>' . "\n",
	) );

	register_sidebar( array(
		'name' => __( 'Archive', 'nest' ),
		'id' => 'archive',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">' . "\n\t",
		'after_widget' => '</aside>' . "\n",
		'before_title' => '<h2 class="widget__title">',
		'after_title' => '</h2>' . "\n",
	) );

}
add_action( 'widgets_init', 'nest_widgets_init' );

/**
 * Register custom widgets
 */
function nest_register_widgets() {
	register_widget( 'nest_widget_pages_subnav' );
	register_widget( 'nest_widget_taxonomy_subnav' );
}
add_action( 'widgets_init', 'nest_register_widgets', 1 );

/**
 * Disable default widgets
 * Can be useful for unregistering default widgets
 * Comment/uncomment as necessary
 */
function nest_unregister_widgets() {
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Text' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
}
//add_action( 'widgets_init', 'nest_unregister_widgets', 1 );

/**
 * Remove recent comments widget inline style block from head
 */
function nest_remove_recent_comments_widget_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'nest_remove_recent_comments_widget_style' );

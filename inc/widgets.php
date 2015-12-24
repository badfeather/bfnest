<?php

/**
 * Register widgetized area and update sidebar with default widgets
 */
function nest_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Global', 'nest' ),
		'id'            => 'global',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">' . "\n\t",
		'after_widget'  => '</aside>' . "\n",
		'before_title'  => '<h1 class="widget__title">',
		'after_title'   => '</h1>' . "\n",
	) );

	register_sidebar( array(
		'name'          => __( 'Page', 'nest' ),
		'id'            => 'page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">' . "\n\t",
		'after_widget'  => '</aside>' . "\n",
		'before_title'  => '<h1 class="widget__title">',
		'after_title'   => '</h1>' . "\n",
	) );

	register_sidebar( array(
		'name'          => __( 'Single', 'nest' ),
		'id'            => 'single',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">' . "\n\t",
		'after_widget'  => '</aside>' . "\n",
		'before_title'  => '<h1 class="widget__title">',
		'after_title'   => '</h1>' . "\n",
	) );

	register_sidebar( array(
		'name'          => __( 'Archive', 'nest' ),
		'id'            => 'archive',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">' . "\n\t",
		'after_widget'  => '</aside>' . "\n",
		'before_title'  => '<h1 class="widget__title">',
		'after_title'   => '</h1>' . "\n",
	) );

}
add_action( 'widgets_init', 'nest_widgets_init' );

/**
 * Disable default widgets
 */
function nest_unregister_default_wp_widgets() {
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
add_action( 'widgets_init', 'nest_unregister_default_wp_widgets', 1 );

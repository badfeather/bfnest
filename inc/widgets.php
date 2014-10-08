<?php

/**
 * Register widgetized area and update sidebar with default widgets
 */
function nest_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Global', 'nest' ),
		'id'            => 'global',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Page', 'nest' ),
		'id'            => 'page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Archive', 'nest' ),
		'id'            => 'archive',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'nest' ),
		'id'            => 'footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Header', 'nest' ),
		'id'            => 'header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

}
add_action( 'widgets_init', 'nest_widgets_init' );

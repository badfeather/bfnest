<?php

/**
 * Register widgetized area and update sidebar with default widgets
 */
function bfn_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Global', 'bfn' ),
		'id'            => 'global',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Page', 'bfn' ),
		'id'            => 'page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Archive', 'bfn' ),
		'id'            => 'archive',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'bfn' ),
		'id'            => 'footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Header', 'bfn' ),
		'id'            => 'header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- /.widget-content -->' . "\n" . '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n" . '<div class="widget-content">',
	) );

}
add_action( 'widgets_init', 'bfn_widgets_init' );

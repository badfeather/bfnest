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
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>' . "\n",
	) );

}
add_action( 'widgets_init', 'nest_widgets_init' );

<?php

/**
 * Initial setup includes
 */

// initial setup
require get_template_directory() . ( '/inc/init.php' );

// scripts and stylesheets
require get_template_directory() . ( '/inc/scripts.php' );

// widgets
require get_template_directory() . ( '/inc/widgets.php' );

// comments
require get_template_directory() . ( '/inc/comments.php' );

// template tags
require get_template_directory() . ( '/inc/template-tags.php' );

// theme custom functions
require get_template_directory() . ( '/inc/custom.php' );

/**
 * plugin-specific configs
 */

// woocommerce - uncomment
// require get_template_directory() . ( '/inc/woocommerce.php' );

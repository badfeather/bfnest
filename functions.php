<?php

/**
 * Initial setup includes
 */
$template_directory = get_template_directory();

// initial setup
require $template_directory . ( '/inc/setup.php' );

// scripts and stylesheets
require $template_directory . ( '/inc/scripts.php' );

// widgets
require $template_directory . ( '/inc/widgets.php' );

// media
require $template_directory . ( '/inc/media.php' );

// hooks
require $template_directory . ( '/inc/hooks.php' );

// Theme functions
require $template_directory . ( '/inc/fn-comments.php' );
require $template_directory . ( '/inc/fn-media.php' );
require $template_directory . ( '/inc/fn-meta.php' );
require $template_directory . ( '/inc/fn-nav.php' );
require $template_directory . ( '/inc/fn-post.php' );
require $template_directory . ( '/inc/fn-shortcodes.php' );
require $template_directory . ( '/inc/svg-icons.php' );

// register any custom theme functions in this file
require $template_directory . ( '/inc/fn-custom.php' );

// register custom post types and taxonomies
// require get_template_directory() . ( '/inc/custom-content.php' );

// Gutenberg
require $template_directory . ( '/inc/blocks.php' );

// Custom widgets
require $template_directory . ( '/inc/widgets/class-widget-page-subnav.php' );
require $template_directory . ( '/inc/widgets/class-widget-taxonomy-subnav.php' );

/**
 * plugin-specific configs
 */
// jetpack
// require $template_directory . ( '/inc/jetpack.php' );


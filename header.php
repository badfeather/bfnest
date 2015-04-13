<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>

  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">
</head>

<body <?php body_class(); ?>>
<div class="hfeed site">

	<header class="site-header" role="banner">

		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

	    <?php
	      $site_description = get_bloginfo( 'description' );
	      if ( !empty( $site_description ) ) {
	        echo '<div class="site-description">' . $site_description . '</div>' . "\n";
	      }
	    ?>

		<nav class="site-nav" role="navigation">
			<h1 class="nav-title site-nav-title" id="site-nav-toggle"><a class="menu-toggle" href="javascript:void(0)"><?php _e( 'Menu', 'nest' ); ?></a></h1>
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => false,
				'menu_class' => 'menu site-nav-menu'
			) ); ?>
		</nav><?php // /.site-nav ?>

	</header><?php // /.site-header ?>

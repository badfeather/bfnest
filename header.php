<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>

  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">
</head>

<body <?php body_class(); ?>>
<div class="hfeed site">

	<header class="site-header" role="banner">

		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

		<div class="site-description"><?php bloginfo( 'description' ); ?></div>

		<nav class="nav-primary" role="navigation">
			<h1 class="nav-title menu-toggle"><?php _e( 'Menu', 'bfn' ); ?></h1>

			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => false
			) ); ?>
		</nav><!-- /.nav-primary -->

		<?php dynamic_sidebar( 'header' ); ?>

	</header><!-- /.site-header -->

	<div class="doc site-main" role="document">
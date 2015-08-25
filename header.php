<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="hfeed site">

	<header class="site__header" role="banner">

		<h1 class="site__title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="masthead__logo"><?php bloginfo( 'name' ); ?></a></h1>

    <?php
      $site_description = get_bloginfo( 'description' );
      if ( ! empty( $site_description ) ) {
        echo '<div class="site__description">' . $site_description . '</div>' . "\n";
      }
    ?>

		<nav class="nav nav--primary site__nav" role="navigation">
			<h1 class="nav__title nav--primary__title"><a class="nav__toggle nav__toggle--primary" id="nav__toggle--primary" href="javascript:void(0)"><?php _e( 'Menu', 'nest' ); ?></a></h1>
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => false,
				'menu_class' => 'menu menu--primary'
			) ); ?>
		</nav><?php // /.masthead__nav ?>

	</header><?php // /.site__header.masthead ?>

	<section class="doc site__main">
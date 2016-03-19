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
<div id="page" class="hfeed site">

	<header class="site-header masthead">

		<?php
			if ( ( is_front_page() && is_home() ) ) {
				$title_tag = 'h1';
			} else {
				$title_tag = 'div';
			}

			echo '<' . $title_tag . ' class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="site__logo">' . get_bloginfo( 'name' ) . '</a></' . $title_tag . '>';
		?>

    <?php
      $site_description = get_bloginfo( 'description' );
      if ( ! empty( $site_description ) ) {
        echo '<div class="site-description">' . $site_description . '</div>' . "\n";
      }
    ?>

		<nav class="nav nav--primary site-nav">
			<button class="nav__toggle nav--primary__toggle"><?php _e( 'Menu', 'nest' ); ?></button>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container' => false,
					'menu_class' => 'menu menu--primary'
				) );
			?>
		</nav><?php // /.nav.nav--primary.site-nav ?>

	</header><?php // /.site-header.masthead ?>

	<div class="doc site-main">
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="<?php echo esc_url( 'http://gmpg.org/xfn/11' ); ?>">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class( array( 'hfeed', 'site' ) ); ?>>
<?php do_action( 'body-before-scripts' ); ?>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bfnest' ); ?></a>

	<header id="site-header" class="site-header" role="banner">
		<?php
			if ( ( is_front_page() && is_home() ) ) {
				$title_tag = 'h1';
			} else {
				$title_tag = 'div';
			}
			echo '<' . $title_tag . ' class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="site-logo site-header__site-logo">' . get_bloginfo( 'name' ) . '</a></' . $title_tag . '>' . "\n";
		?>

		<?php
			$site_description = get_bloginfo( 'description' );
			if ( ! empty( $site_description ) ) {
				echo '<div class="site-description">' . $site_description . '</div>' . "\n";
			}
		?>

		<nav id="site-navigation" class="site-nav nav nav-primary" role="navigation" aria-label="<?php _e( 'Main', 'bfnest' ); ?>">
			<button class="site-nav__toggle"><?php _e( 'Menu', 'psmeats' ); ?></button>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container' => false,
					'menu_class' => 'menu menu--primary site-nav__menu'
				) );
			?>
		</nav>
	</header>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-color-scheme="light">
	<?php wp_body_open(); ?>

	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#doc-main"><?php esc_html_e( 'Skip to content', 'bfnest' ); ?></a>

		<header id="site-header" class="site-header container" data-expander>
			<?php
			$title_tag = is_front_page() && is_home() ? 'h1' : 'div';
			echo '<' . $title_tag . ' class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="site-logo site-header__site-logo">' . get_bloginfo( 'name' ) . '</a></' . $title_tag . '>' . "\n";
			?>

			<?php
			$site_description = get_bloginfo( 'description' );
			if ( ! empty( $site_description ) ) {
				echo '<div class="site-description">' . $site_description . '</div>' . "\n";
			}
			?>

			<button class="btn--unstyled site-nav-toggle" data-expand="site-navigation"><span class="sr-only"><?php _e( 'Menu', 'bfnest' ); ?></span></button>

			<nav id="site-navigation" class="site-nav nav nav-primary" aria-label="<?php _e( 'Main Navigation', 'bfnest' ); ?>">
				<?php
				wp_nav_menu( [
					'theme_location' => 'primary',
					'container' => false,
					'menu_class' => 'menu menu--primary site-menu',
					'menu_id' => 'primary-menu'
				] );
				?>
			</nav>
		</header>

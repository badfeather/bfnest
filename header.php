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
		<button class="site-nav__toggle button button--trans button--icon"><?php
			$ui_icons_path = get_template_directory_uri() . '/assets/dist/img/ui-icons/';
			$menu_svg = bfnest_get_svg( esc_url( $ui_icons_path . 'menu.svg' ) );
			$close_svg = bfnest_get_svg( esc_url( $ui_icons_path . 'close.svg' ) );
			$before = $after = '';
			if ( $menu_svg ) {
				$before .= '<span class="toggle-icon toggle-icon--menu" aria-hidden="true">' . $menu_svg . '</span>';
				$before .= $close_svg ? '<span class="toggle-icon toggle-icon--close" aria-hidden="true">' . $close_svg . '</span>' : '';
				$before .= '<span class="sr-only">';
				$after .= '</span>';
			}
			echo $before . __( 'Menu', 'bfnest' ) . $after;
		?></button>
		<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => false,
				'menu_class' => 'menu menu--primary site-nav__menu'
			) );
		?>
	</nav>
</header>


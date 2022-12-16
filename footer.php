<?php
$secondary_nav = wp_nav_menu( [
	'theme_location' => 'secondary',
	'container' => false,
	'menu_class' => 'menu menu--secondary',
	'echo' => false,
	'fallback_cb' => '__return_false'
] );

$social_nav = wp_nav_menu( [
	'theme_location' => 'social',
	'container' => false,
	'menu_class' => 'menu menu--social',
	'echo' => false,
	'fallback_cb' => '__return_false',
	'link_before' => '<span>',
	'link_after' => '</span>'
] );
?>
		<footer class="site-footer" role="contentinfo">
			<?php if ( $secondary_nav ) { ?>
				<nav id="secondary-navigation" class="nav nav-secondary" role="navigation" aria-label="<?php _e( 'Secondary', 'bfnest' ); ?>">
					<?php echo $secondary_nav; ?>
				</nav>
			<?php } // endif ?>

			<?php if ( $social_nav ) { ?>
				<nav id="social-navigation" class="nav nav-social" role="navigation" aria-label="<?php _e( 'Social', 'bfnest' ); ?>">
					<h2 class="nav-title">Follow <?php echo get_bloginfo( 'name' ); ?></h2>
					<?php echo $social_nav; ?>
				</nav>
			<?php } //endif ?>

			<div class="search-area">
				<?php get_search_form(); ?>
			</div>

			<div class="site-info">
				<div class="site-copyright">
					&copy; <?php echo date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . "\n"; ?>
				</div>

				<div class="site-credits">
					<?php
					printf( __( 'Site by %1$s %2$s Powered by %3$s', 'bfnest' ),
					'<a href="' . esc_url( 'https://www.badfeather.com/' ) . '" target="_blank" rel="noopener noreferrer">Bad Feather</a>',
					'<span class="sep"> | </span>',
					'<a href="' . esc_url( 'https://wordpress.org/' ) . '" target="_blank" rel="noopener noreferrer">WordPress</a>' );
					?>
				</div>
			</div>
		</footer>
	</div>

	<?php wp_footer(); ?>
</body>
</html>

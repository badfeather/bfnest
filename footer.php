<footer class="site-footer" role="contentinfo">
	<div class="container">
		<div class="site-copyright">
			&copy; <?php echo date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . "\n"; ?>
		</div>

		<div class="site-credits">
			<?php
				printf( __( 'Site by %1$s %2$s Powered by %3$s', 'bfnest' ),
				'<a href="' . esc_url( 'https://www.badfeather.com/' ) . '" target="_blank">Bad Feather</a>',
				'<span class="sep"> | </span>',
				'<a href="' . esc_url( 'https://wordpress.org/' ) . '" target="_blank">WordPress</a>' );
			?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

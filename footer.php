	<footer class="site-footer content-info" role="contentinfo">

		<?php dynamic_sidebar( 'footer' ); ?>

		<div class="copyright">
			&copy; <?php echo date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . "\n"; ?>
		</div><!-- /.copyright -->

		<div class="credits">
		  <?php
		    printf( __( 'Site by %1$s %2$s Powered by %3$s', 'nest' ),
		    '<a href="' . esc_url( 'http://badfeather.com' ) . '" target="_blank">Bad Feather</a>',
		    '<span class="sep"> | </span>',
		    '<a href="' . esc_url( 'http://wordpress.org' ) . '" target="_blank">WordPress</a>' );
		  ?>
		</div><!-- /.credits -->

	</footer><!-- /.site-footer.content-info -->

</div><!-- /.site -->

<?php wp_footer(); ?>

</body>
</html>
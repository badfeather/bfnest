	</div><?php // /.doc.site-main ?>

	<footer class="site-footer content-info">

		<div class="site-copyright">
			&copy; <?php echo date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . "\n"; ?>
		</div><?php // /.site-copyright ?>

		<div class="site-credits">
		  <?php
		    printf( __( 'Site by %1$s %2$s Powered by %3$s', 'nest' ),
		    '<a href="' . esc_url( 'http://badfeather.com' ) . '" target="_blank">Bad Feather</a>',
		    '<span class="sep"> | </span>',
		    '<a href="' . esc_url( 'http://wordpress.org' ) . '" target="_blank">WordPress</a>' );
		  ?>
		</div><?php // /.site-credits ?>

	</footer><?php // /.site-footer.content-info ?>

</div><?php // /#page.site ?>

<?php wp_footer(); ?>

</body>
</html>

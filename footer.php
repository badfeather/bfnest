	</section><?php // /.doc.site__main ?>

	<footer class="site__footer content-info">

		<div class="copyright">
			&copy; <?php echo date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . "\n"; ?>
		</div><?php // /.copyright ?>

		<div class="credits">
		  <?php
		    printf( __( 'Site by %1$s %2$s Powered by %3$s', 'nest' ),
		    '<a href="' . esc_url( 'http://badfeather.com' ) . '" target="_blank">Bad Feather</a>',
		    '<span class="sep"> | </span>',
		    '<a href="' . esc_url( 'http://wordpress.org' ) . '" target="_blank">WordPress</a>' );
		  ?>
		</div><?php // /.credits ?>

	</footer><?php // /.site__footer.content-info ?>

</div><?php // /.site ?>

<?php wp_footer(); ?>

</body>
</html>

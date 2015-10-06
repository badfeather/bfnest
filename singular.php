<?php get_header(); ?>

		<?php
			while ( have_posts() ) {
				the_post();
				$post_type = get_post_type();
		?>
	    <main class="doc__main doc__main--singular doc__main--single">

				<?php get_template_part( 'content-singular', $post_type ); ?>

	    </main><?php // /.doc__main.doc__main--singular.doc__main--single ?>

			<?php get_sidebar( $post_type ); ?>

		<?php } // endwhile have_posts() ?>

<?php get_footer(); ?>

<?php get_header(); ?>

		<?php
			while ( have_posts() ) {
				the_post();
		?>
			<main class="doc__main doc__main--singular doc__main--page">

				<?php get_template_part( 'content-page', basename( get_permalink() ) ); ?>

			</main><?php // /.doc__main.doc__main--singular.doc__main--page ?>

			<?php get_sidebar( 'page' ); ?>

		<?php } // endwhile have_posts() ?>

<?php get_footer(); ?>

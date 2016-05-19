<?php get_header(); ?>

		<div class="inner doc__inner">
			<?php
				while ( have_posts() ) {
					the_post();
					$post_type = get_post_type();
			?>
				<main class="doc__main doc__main--singular doc__main--single">

					<?php get_template_part( 'content-single', $post_type ); ?>

				</main><?php // /.doc__main.doc__main--singular.doc__main--single ?>

				<?php get_sidebar( 'single', $post_type ); ?>

			<?php } // endwhile have_posts() ?>
		</div><?php // /.inner.doc__inner ?>

<?php get_footer(); ?>

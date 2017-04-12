<?php get_header(); ?>

		<div class="doc doc--singular doc--single site__main">
			<div class="inner doc__inner">
				<?php
					while ( have_posts() ) {
						the_post();
						$post_type = get_post_type();
				?>
					<main class="doc__main">

						<?php get_template_part( 'content-single', $post_type ); ?>

					</main><?php // /.doc__main ?>

					<?php get_sidebar( 'single', $post_type ); ?>

				<?php } // endwhile have_posts() ?>
			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--single.doc--singular.site__main ?>

<?php get_footer(); ?>

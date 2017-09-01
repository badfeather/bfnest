<?php get_header(); ?>

		<div id="content" class="doc doc--singular doc--single site-main">
			<div class="inner doc__inner">
				<?php
					while ( have_posts() ) {
						the_post();
						$post_type = get_post_type();
				?>
					<main class="doc-main">

						<?php get_template_part( 'content-single', $post_type ); ?>

					</main><?php // /.doc-main ?>

					<?php get_sidebar( 'single', $post_type ); ?>

				<?php } // endwhile have_posts() ?>
			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--single.doc--singular.site-main ?>

<?php get_footer(); ?>

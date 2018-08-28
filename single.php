<?php get_header(); ?>

		<div id="content" class="doc doc--singular doc--single site-main">
			<div class="inner doc__inner">

				<?php
					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content-single', get_post_type() );
					}
				?>

			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--single.doc--singular.site-main ?>

<?php get_footer(); ?>

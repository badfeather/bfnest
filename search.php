<?php get_header(); ?>

		<div id="content" class="doc doc--archive doc--search site-main">
			<div class="inner doc__inner">

				<?php
					if ( have_posts() ) {
						get_template_part( 'template-parts/content-search' );

					} else {
						get_template_part( 'template-parts/content-no-results' );
					}
				?>

			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--archive.doc--search.site-main ?>

<?php get_footer(); ?>

<?php get_header(); ?>

		<div id="content" class="doc doc--archive doc--taxonomy site-main">
			<div class="inner doc__inner">

				<?php
					if ( have_posts() ) {
						$term = get_queried_object();
						$term_template = 'template-parts/content-taxonomy-' . $term->taxonomy . '-' . $term->slug;

						if ( locate_template( $term_template ) ) {
							get_template_part( $term_template );

						} else {
							get_template_part( 'template-parts/content-taxonomy', $term->taxonomy );
						}

					} else {
						get_template_part( 'template-parts/content-no-results' );
					}
				?>

			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--archive.site-main ?>

<?php get_footer(); ?>

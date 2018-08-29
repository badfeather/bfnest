<?php get_header(); ?>

		<div class="inner doc__inner">
			<main class="doc-main doc-main--archive">
				<?php
					if ( have_posts() ) {
						get_template_part(  'template-parts/loop-archive' );

					} else {
						get_template_part( 'template-parts/content-no-results' );
					}
				?>
			</main><?php // /.doc-main.doc-main--archive ?>

			<?php get_template_part( 'template-parts/sidebar-archive' ); ?>

		</div><?php // /.inner.doc__inner ?>

<?php get_footer(); ?>

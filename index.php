<?php get_header(); ?>

		<div class="inner doc__inner">

			<?php if ( have_posts() ) { ?>

				<main class="doc-main doc-main--archive">

					<?php get_template_part( 'template-parts/loop-archive' ); ?>

				</main><?php // /.doc-main.doc-main--archive ?>

				<?php get_template_part( 'template-parts/sidebar-archive' ); ?>

			<?php
				} else {
					get_template_part( 'content', 'no-results' );
				} // endif
			?>

		</div><?php // /.inner.doc__inner ?>

<?php get_footer(); ?>

<?php get_header(); ?>

		<div id="content" class="doc doc--singular doc--page site-main">
			<div class="inner doc__inner">
				<?php
					while ( have_posts() ) {
						the_post();
						$slug = basename( get_permalink() );
				?>
				<main class="doc-main">
					<?php get_template_part( 'template-parts/content-page', $slug ); ?>
				</main>

				<?php get_template_part( 'template-parts/sidebar-page', $slug ); ?>

				<?php } // endwhile ?>
			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--singular.doc--page.site-main ?>

<?php get_footer(); ?>

<?php get_header(); ?>

		<div id="content" class="doc doc--404 site-main">
			<div class="inner doc__inner">

				<main class="doc-main" role="main">
					<?php get_template_part( 'content', 'no-results' ); ?>
				</main><?php // /.doc-main ?>

				<?php get_sidebar(); ?>

			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--404.site-main ?>

<?php get_footer(); ?>

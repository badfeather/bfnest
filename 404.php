<?php get_header(); ?>

		<div class="doc doc--404 site__main">
			<div class="inner doc__inner">

				<main class="doc__main" role="main">
					<?php get_template_part( 'content', 'no-results' ); ?>
				</main><?php // /.doc__main ?>

				<?php get_sidebar(); ?>

			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--404.site__main ?>

<?php get_footer(); ?>

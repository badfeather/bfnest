<?php get_header(); ?>

		<div id="content" class="doc doc--archive site-main">
			<div class="container doc-container">
				<div class="row doc-row">
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
				</div><?php // /.row.doc-container ?>
			</div><?php // /.container.doc-row ?>
	</div><?php // /.doc.doc--archive.site-main ?>

<?php get_footer(); ?>

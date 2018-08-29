<?php get_header(); ?>

		<div id="content" class="doc doc--archive doc--search site-main">
			<div class="container doc-container">
				<div class="row doc-row">

					<main class="doc-main">
						<?php
							if ( have_posts() ) {
								get_template_part( 'template-parts/content-archive-search' );

							} else {
								get_template_part( 'template-parts/content-no-results' );
							}
						?>
					</main>

					<?php get_template_part( 'template-parts/sidebar-archive', 'search' ); ?>

				</div><?php // /.row.doc-container ?>
			</div><?php // /.container.doc-row ?>
		</div><?php // /.doc.doc--archive.doc--search.site-main ?>

<?php get_footer(); ?>

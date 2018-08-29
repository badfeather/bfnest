<?php get_header(); ?>

		<div id="content" class="doc doc--404 site-main">
			<div class="container doc-container">
				<div class="row doc-row">

					<main class="doc-main" role="main">
						<?php get_template_part( 'template-parts/content-no-results' ); ?>
					</main><?php // /.doc-main ?>

					<?php get_template_part( 'template-parts/sidebar-archive' ); ?>

				</div><?php // /.row.doc-container ?>
			</div><?php // /.container.doc-row ?>
		</div><?php // /.doc.doc--404.site-main ?>

<?php get_footer(); ?>

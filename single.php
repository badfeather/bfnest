<?php get_header(); ?>

		<div id="content" class="doc doc--singular doc--single site-main">
			<div class="container doc-container">
				<div class="row doc-row">
					<?php
						while ( have_posts() ) {
							the_post();
							$post_type = get_post_type();
					?>
						<main class="doc-main">
							<?php get_template_part( 'template-parts/content-single', $post_type ); ?>
						</main><?php // /.doc-main ?>

						<?php get_template_part( 'template-parts/sidebar-single', $post_type ); ?>
					<? } // endwhile ?>
				</div><?php // /.row.doc-container ?>
			</div><?php // /.container.doc-row ?>
		</div><?php // /.doc.doc--single.doc--singular.site-main ?>

<?php get_footer(); ?>

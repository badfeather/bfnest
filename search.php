<?php get_header(); ?>

	  <section class="doc site-main" role="document">

			<main class="doc-main doc-main--archive" role="main">

				<?php
					if ( have_posts() ) {
				?>

					<header class="doc-header">
						<h1 class="doc-title"><?php printf( __( 'Search Results for %s', 'nest' ), get_search_query() ); ?></h1>
					</header>

					<div class="doc-content">

						<?php
							while ( have_posts() ) {
								the_post();
								get_template_part( 'content', get_post_type() );
							} // endwhile

							nest_postnav_archive();
						?>

					</div><?php // /.doc-content ?>

				<?php
					} else {
						get_template_part( 'content', 'no-results' );
					} // endif
				?>
			</main><?php // /.doc-main.doc-main--archive ?>

			<?php get_sidebar(); ?>

		</section><?php // /.doc.site-main ?>

<?php get_footer(); ?>

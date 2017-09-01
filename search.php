<?php get_header(); ?>

		<div id="content" class="doc doc--archive doc--search site-main">
			<div class="inner doc__inner">
				<main class="doc-main">

					<?php if ( have_posts() ) { ?>

						<header class="doc-header">
							<h1 class="doc-title"><?php printf( __( 'Search Results for %s', 'nest' ), get_search_query() ); ?></h1>
						</header>

						<div id="content" class="doc-content entries">

							<?php
								while ( have_posts() ) {
									the_post();
									get_template_part( 'content', get_post_type() );
								} // endwhile

								nest_postnav_archive();
							?>

						</div><?php // /#content.doc-content.entries ?>

					<?php
						} else {
							get_template_part( 'content', 'no-results' );
						} // endif
					?>
				</main><?php // /.doc-main ?>

				<?php get_sidebar(); ?>
			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--archive.doc--search.site-main ?>

<?php get_footer(); ?>

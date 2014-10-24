<?php get_header(); ?>

		<div class="doc site-main content" role="document">
		  <main class="doc-main" role="main">
  			<?php
  				if ( have_posts() ) {
  			?>

					<div class="doc-content">
						<?php
							while ( have_posts() ) {
								the_post();
								get_template_part( 'content', get_post_type() );
							}

							nest_archive_pager();
						?>
					</div><!-- /.doc-content -->
  			<?php
  				} else {
  					get_template_part( 'content', 'no-results' );
  				} // endif
  			?>
      </main><!-- /.doc-main -->

			<?php get_sidebar(); ?>

		</div><!-- /.doc.site-main-content -->

<?php get_footer(); ?>

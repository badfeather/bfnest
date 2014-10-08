<?php get_header(); ?>

		<section class="doc site-main content" role="document">
		  <main class="doc-main" role="main">
  			<?php
  				if ( have_posts() ) {
  			?>
					<header class="doc-header">
						<h1 class="doc-title"><?php _e( 'Latest Posts', 'nest' ); ?></h1>
					</header><!-- /.doc-header -->

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

		</section><!-- /.doc.site-main-content -->

<?php get_footer(); ?>

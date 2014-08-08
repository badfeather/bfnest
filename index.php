<?php get_header(); ?>

		<section class="content">

			<?php
				if ( have_posts() ) {
			?>

				<main class="doc-main" role="main">
					<header class="doc-header">
						<h1 class="doc-title"><?php _e( 'Latest Posts', 'bfn' ); ?></h1>
					</header><!-- /.doc-header -->

					<div class="doc-content">
						<?php
							while ( have_posts() ) {
								the_post();
								get_template_part( 'content', get_post_type() );
							}

							bfn_archive_pager();
						?>
					</div><!-- /.doc-content -->
				</main><!-- /.doc-main -->

			<?php
				} else {
					get_template_part( 'content', 'no-results' );
				} // endif
			?>

			<?php get_sidebar(); ?>

		</section><!-- /.content -->

<?php get_footer(); ?>

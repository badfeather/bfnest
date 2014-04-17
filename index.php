<?php get_header(); ?>

		<section class="content">

			<?php
				if ( have_posts() ) {
			?>

				<main class="main" role="main">
					<header class="doc-header">
						<h1 class="doc-title"><?php _e( 'Latest Posts', 'bfn' ); ?></h1>
					</header><!-- /.doc-header -->

					<div class="doc-main">
						<?php
							while ( have_posts() ) {
								the_post();
								get_template_part( 'part/content', get_post_type() );
							}

							bfn_archive_pager();
						?>
					</div><!-- /.doc-main -->
				</main>

				<?php get_template_part( 'part/sidebar' ); ?>

			<?php
				} else {
					get_template_part( 'part/content', 'no-results' );
				} // endif
			?>

		</section><!-- /.content -->

<?php get_footer(); ?>

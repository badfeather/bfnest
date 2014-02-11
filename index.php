<?php get_header(); ?>

		<section class="content">

			<main class="main" role="main">

				<?php
					if ( have_posts() ) {
				?>

					<header class="doc-header">
						<h1 class="doc-title"><?php _e( 'Latest Posts', 'bfn' ); ?></h1>
					</header><!-- /.doc-header -->

					<div class="doc-main">
						<?php
							if ( have_posts() ) {
								while ( have_posts() ) {
									the_post();
									get_template_part( 'part/content', get_post_type() );
								}
							}

							bfn_archive_pager();
						?>
					</div><!-- /.doc-main -->

				<?php
					} else {
						get_template_part( 'part/content', 'no-results' );
					} // endif
				?>

			</main>

			<?php get_template_part( 'part/sidebar', get_post_type() ); ?>

		</section><!-- /.content -->

<?php get_footer(); ?>
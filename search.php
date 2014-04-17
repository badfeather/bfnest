<?php get_header(); ?>

		<section class="content">

			<?php
				if ( have_posts() ) {
			?>
				<main class="main" role="main">

					<header class="doc-header">
						<h1 class="doc-title"><?php printf( __( 'Search Results for: %s', 'bfn' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- /.doc-header -->

					<div class="doc-main doc-main-archive">
						<?php
								while ( have_posts() ) {
									the_post();
									get_template_part( 'part/content-excerpt', get_post_type() );
								} // endwhile

								bfn_archive_pager();

						?>
					</div><!-- /.doc-main.doc-main-archive -->

				</main>

				<?php get_template_part( 'part/sidebar' ); ?>

			<?php
				} else {
					get_template_part( 'part/content', 'no-results' );
				} // endif
			?>

		</section><!-- /.content -->

<?php get_footer(); ?>

<?php get_header(); ?>

		<section class="content">

			<main class="main" role="main">

				<?php
					if ( have_posts() ) {
				?>

					<header class="doc-header">
						<h1 class="doc-title"><?php printf( __( 'Search Results for: %s', 'bfn' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- /.doc-header -->

					<div class="doc-main doc-main-archive">
						<?php
							if ( have_posts() ) {

								while ( have_posts() ) {
									the_post();
									get_template_part( 'part/content-excerpt', get_post_type() );
								} // endwhile

								bfn_archive_pager();

							} else {
								get_template_part( 'part/content', 'no-results' );
							} // endif
						?>
					</div><!-- /.doc-main.doc-main-archive -->

				<?php
					} else {
						get_template_part( 'part/content', 'no-results' );
					} // endif
				?>

			</main>

			<?php get_template_part( 'part/widget-area' ); ?>

		</section><!-- /.content -->

<?php get_footer(); ?>
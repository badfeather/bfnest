<?php get_header(); ?>

		<section class="content">

			<main class="main" role="main">
				<?php
					while ( have_posts() ) {
						the_post();
						get_template_part( 'part/content', 'page' );
					}
				?>
			</main>

			<?php get_template_part( 'part/sidebar', 'page' ); ?>

		</section><!-- /.content -->

<?php get_footer(); ?>
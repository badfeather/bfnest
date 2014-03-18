<?php get_header(); ?>

		<section class="content">

			<main class="main" role="main">
				<?php
					while ( have_posts() ) {
						the_post();
						get_template_part( 'part/content-single', get_post_type() );
					}
				?>
			</main>

			<?php get_template_part( 'part/sidebar', get_post_type() ); ?>

		</section><!-- /.content -->

<?php get_footer(); ?>
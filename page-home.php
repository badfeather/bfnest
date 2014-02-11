<?php
/*
Template Name: Home
*/
?>
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

			<?php get_template_part( 'part/widget-area', 'page' ); ?>

		</section><!-- /.content -->

<?php get_footer(); ?>
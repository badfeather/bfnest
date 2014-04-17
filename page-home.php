<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>

		<section class="content">

			<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'part/content-page', 'home' );
				}
			?>

		</section><!-- /.content -->

<?php get_footer(); ?>

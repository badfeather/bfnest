<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>

		<div class="content">

			<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'part/content-page', 'home' );
				}
			?>

		</div><!-- /.content -->

<?php get_footer(); ?>

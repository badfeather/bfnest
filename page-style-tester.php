<?php
/*
Template Name: Style Tester
*/
?>
<?php get_header(); ?>

<div class="site-content doc doc--page doc--page-style-tester">
	<main id="content" class="doc__main">
	<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'partials/content-page', 'style-tester' );
		} // endwhile 
	?>
	</main>
	
	<?php get_template_part( 'partials/sidebar', 'page' ); ?>
</div>

<?php get_footer(); ?>

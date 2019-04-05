<?php get_header(); ?>

<div class="doc doc--page">
	<main id="content" class="doc__main">
		<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'partials/content-page' );
			} // endwhile 
		?>
	</main>
	
	<?php get_template_part( 'partials/sidebar', 'page' ); ?>
</div>

<?php get_footer(); ?>

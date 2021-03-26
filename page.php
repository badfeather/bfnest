<?php get_header(); ?>

<div class="site-content doc doc--page">
	<main id="content" class="doc-main">
		<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'partials/single-page' );
			} // endwhile
		?>
	</main>

	<?php get_template_part( 'partials/sidebar', 'page' ); ?>
</div>

<?php get_footer(); ?>

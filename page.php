<?php get_header(); ?>

<?php
$slug = get_post_field( 'post_name' );
?>
<div id="site-content" class="site-content doc doc--singular doc--singular-page">
	<main id="doc-main" class="doc-main">
		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'partials/entry-singular-page', $slug );
		}
		?>
	</main>

	<?php get_template_part( 'partials/sidebar-singular-page', $slug ); ?>
</div>

<?php get_footer(); ?>

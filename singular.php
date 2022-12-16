<?php get_header(); ?>

<?php
	$post_type = get_post_type();
?>
<div class="site-content doc doc--singular doc--singular-<?php echo esc_attr( $post_type ); ?>">
	<main id="content" class="doc-main">
		<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'partials/entry-singular', $post_type );
			}
		?>
	</main>

	<?php get_template_part( 'partials/sidebar-singular', $post_type ); ?>
</div>

<?php get_footer(); ?>

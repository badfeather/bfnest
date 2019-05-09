<?php get_header(); ?>

<?php
	$post_type = get_post_type();
?>
<div class="site-content doc doc--single doc--single-<?php echo esc_attr( $post_type ); ?>">
	<main id="content" class="doc-main">
		<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'partials/content-single', $post_type );
			} // endwhile
		?>
	</main>

	<?php get_template_part( 'partials/sidebar-single', $post_type ); ?>
</div>

<?php get_footer(); ?>

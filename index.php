<?php get_header(); ?>

<?php
if ( have_posts() ) {
	$post_type = bfnest_get_archive_post_type();
?>
	<div id="site-content" class="site-content doc doc--archive doc--archive-index">
		<main id="doc-main" class="doc-main">
			<?php get_template_part(  'partials/loop-archive', $post_type ); ?>
		</main>

		<?php get_template_part( 'partials/sidebar-archive', $post_type ); ?>
	</div>
<?php
} else {
	get_template_part( 'partials/no-results' );
}
?>

<?php get_footer(); ?>

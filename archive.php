<?php get_header(); ?>

<?php
	if ( have_posts() ) {
		$post_type = ( is_post_type_archive() ? get_query_var( 'post_type' ) : '' );
?>
	<div class="site-content doc doc--archive">
		<div class="container">
			<main id="content" class="doc-main">
				<header class="doc-header">
					<h1 class="doc-title"><?php the_archive_title(); ?></h1>

					<?php the_archive_description( '<div class="doc-description">', '</div>' ); ?>
				</header>

				<?php get_template_part( 'partials/loop-archive' ); ?>
			</main>

			<?php get_template_part( 'partials/sidebar-archive', $post_type ); ?>
		</div>
	</div>
<?php
	} else {
		get_template_part( 'partials/no-results' );
	}
?>

<?php get_footer(); ?>

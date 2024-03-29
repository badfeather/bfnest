<?php get_header(); ?>

<?php if ( have_posts() ) { ?>
	<div id="site-content" class="site-content doc doc--archive doc--search">
		<main id="doc-main" class="doc-main">
			<header id="doc-header"  class="doc-header">
				<h1 class="doc-title"><?php printf( __( 'Search Results for %s', 'bfnest' ), get_search_query() ); ?></h1>
			</header>

			<?php get_template_part( 'partials/loop-archive' ); ?>
		</main>

		<?php get_template_part( 'partials/sidebar-archive', 'search' ); ?>
	</div>

<?php
} else {
	get_template_part( 'partials/content-no-results' );
}
?>
<?php get_footer(); ?>

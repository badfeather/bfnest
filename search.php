<?php get_header(); ?>

<?php if ( have_posts() ) { ?>
	<div class="site-content doc doc--archive doc--search">
		<main id="content" class="doc__main">
			<header class="doc__header">
				<h1 class="doc__title"><?php printf( __( 'Search Results for %s', 'bfnest' ), get_search_query() ); ?></h1>
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

<?php get_header(); ?>
			
<?php if ( have_posts() ) { ?>
	<main id="content" class="site-main">
		
		<div class="doc doc--archive doc--archive-search">
			<header class="doc__header">
				<h1 class="doc__title"><?php printf( __( 'Search Results for %s', 'bfnest' ), get_search_query() ); ?></h1>
			</header>
			
			<?php get_template_part( 'partials/loop-archive' ); ?>			
		</div>
		
	</main>
	
	<?php get_template_part( 'partials/sidebar-archive', 'search' ); ?>
	
<?php		
	} else {
		get_template_part( 'partials/content-no-results' );
	}
?>

<?php get_footer(); ?>

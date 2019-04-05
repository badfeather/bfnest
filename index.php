<?php get_header(); ?>

<?php if ( have_posts() ) { ?>	
	<div class="doc doc--archive doc--archive-index">
		<main id="content" class="site-main">
			<div class="doc doc--archive doc--archive-index">
				<?php get_template_part(  'partials/loop-archive' ); ?>
			</div>
		</main>
		
		<?php get_template_part( 'partials/sidebar', 'archive' ); ?>
	</div>		
<?php
	} else {
		get_template_part( 'partials/content-no-results' );
	}
?>	

<?php get_footer(); ?>

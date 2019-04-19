<?php get_header(); ?>

<?php if ( have_posts() ) { ?>
	<div class="site-content doc doc--archive doc--archive-index">
		<main id="content" class="doc__main">
			<?php get_template_part(  'partials/loop-archive' ); ?>
		</main>

		<?php get_template_part( 'partials/sidebar', 'archive' ); ?>
	</div>
<?php
	} else {
		get_template_part( 'partials/content-no-results' );
	}
?>

<?php get_footer(); ?>

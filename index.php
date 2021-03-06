<?php get_header(); ?>

<?php if ( have_posts() ) { ?>
	<div class="site-content doc doc--archive doc--archive-index">
		<div class="container">
			<main id="content" class="doc-main">
				<?php get_template_part(  'partials/loop-archive' ); ?>
			</main>

			<?php get_template_part( 'partials/sidebar', 'archive' ); ?>
		</div>
	</div>
<?php
	} else {
		get_template_part( 'partials/content-no-results' );
	}
?>

<?php get_footer(); ?>

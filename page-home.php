<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>

		<div class="doc doc--singular doc--page site__main">
			<div class="inner doc__inner">
				<main class="doc__main">

					<?php
						while ( have_posts() ) {
							the_post();
							get_template_part( 'content-page', 'home' );
						}
					?>

				</main><?php // /.doc__main ?>

				<?php get_sidebar( 'page' ); ?>
			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--singular.doc--page.site__main ?>

<?php get_footer(); ?>

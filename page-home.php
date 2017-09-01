<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>

		<div id="content" class="doc doc--singular doc--page site-main">
			<div class="inner doc__inner">
				<main class="doc-main">

					<?php
						while ( have_posts() ) {
							the_post();
							get_template_part( 'content-page', 'home' );
						}
					?>

				</main><?php // /.doc-main ?>

				<?php get_sidebar( 'page' ); ?>
			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--singular.doc--page.site-main ?>

<?php get_footer(); ?>

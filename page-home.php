<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>

	<div class="inner doc__inner">
		<main class="doc__main doc__main--singular doc__main--page">

			<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content-page', 'home' );
				}
			?>

		</main><?php // /.doc__main.doc__main--singular.doc__main--page ?>

		<?php get_sidebar( 'page' ); ?>
	</div><?php // /.inner.doc__inner ?>

<?php get_footer(); ?>

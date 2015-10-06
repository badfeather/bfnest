<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>

    <main class="doc__main doc__main--singular doc__main--page">

			<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content-singular', 'page-home' );
				}
			?>

    </main><?php // /.doc__main.doc__main--singular.doc__main--page ?>

		<?php get_sidebar( 'page' ); ?>


<?php get_footer(); ?>

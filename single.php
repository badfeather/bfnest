<?php get_header(); ?>

    <main class="doc__main doc__main--singular doc__main--single" role="main">

			<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content-single', get_post_type() );
				}
			?>

    </main><?php // /.doc__main.doc__main--singular.doc__main--single ?>

		<?php get_sidebar( 'single' ); ?>

<?php get_footer(); ?>

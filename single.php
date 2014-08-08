<?php get_header(); ?>

		<div class="content">

			<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content-single', get_post_type() );
				}
			?>

			<?php get_sidebar( get_post_type() ); ?>

		</div><!-- /.content -->

<?php get_footer(); ?>

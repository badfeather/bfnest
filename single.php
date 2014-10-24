<?php get_header(); ?>

	  <div class="doc site-main" role="document">

      <main class="doc-main" role="main">

  			<?php
  				while ( have_posts() ) {
  					the_post();
  					get_template_part( 'content-single', get_post_type() );
  				}
  			?>

      </main><!-- /.doc-main -->

			<?php get_sidebar( 'single' ); ?>

		</div><!-- /.doc.site-main -->

<?php get_footer(); ?>

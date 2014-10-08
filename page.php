<?php get_header(); ?>

	  <div class="doc site-main" role="document">
      <main class="doc-main" role="main">

  			<?php
  				while ( have_posts() ) {
  					the_post();
  					get_template_part( 'content-page', basename( get_permalink() ) );
  				}
  			?>

      </main><!-- /.doc-main -->

			<?php get_sidebar( 'page' ); ?>

		</div><!-- /.doc.site-main -->

<?php get_footer(); ?>

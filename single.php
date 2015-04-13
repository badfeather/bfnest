<?php get_header(); ?>

	  <div class="doc site-main" role="document">

      <main class="doc-main doc-main--single" role="main">

  			<?php
  				while ( have_posts() ) {
  					the_post();
  					get_template_part( 'content-single', get_post_type() );
  				}
  			?>

      </main><?php // /.doc-main.doc-main--single ?>

			<?php get_sidebar( 'single' ); ?>

		</div><?php // /.doc.site-main ?>

<?php get_footer(); ?>

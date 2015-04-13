<?php get_header(); ?>

	  <div class="doc site-main" role="document">
      <main class="doc-main doc-main--single doc-main--page" role="main">

  			<?php
  				while ( have_posts() ) {
  					the_post();
  					get_template_part( 'content-page', basename( get_permalink() ) );
  				}
  			?>

      </main><?php // /.doc-main.doc-main--single.doc-main--page ?>

			<?php get_sidebar( 'page' ); ?>

		</div><?php // /.doc.site-main ?>

<?php get_footer(); ?>

<?php get_header(); ?>

	  <main class="doc__main doc__main--archive" role="main">

			<?php if ( have_posts() ) { ?>

	      <div class="doc__content entries">
	      	<?php
	      		while ( have_posts() ) {
	      			the_post();
	      			get_template_part( 'content', get_post_type() );
	      		}

	      		nest_postnav_archive();
	      	?>
	      </div><?php // /.doc__content.entries ?>

			<?php
				} else {
					get_template_part( 'content', 'no-results' );
				} // endif
			?>

	  </main><?php // /.doc__main.doc__main--archive ?>

		<?php get_sidebar(); ?>

<?php get_footer(); ?>

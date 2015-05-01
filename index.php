<?php get_header(); ?>


	<div class="doc site-main content" role="document">
	  <main class="doc-main doc-main--archive" role="main">
			<?php if ( have_posts() ) { ?>
        <div class="doc-content">
        	<?php
        		while ( have_posts() ) {
        			the_post();
        			get_template_part( 'content', get_post_type() );
        		}

        		nest_postnav_archive();
        	?>
        </div><?php // /.doc-content ?>
			<?php
				} else {
					get_template_part( 'content', 'no-results' );
				} // endif
			?>
    </main><?php // /.doc-main.doc-main--archive ?>

		<?php get_sidebar(); ?>

	</div><?php // /.doc.site-main-content ?>

<?php get_footer(); ?>

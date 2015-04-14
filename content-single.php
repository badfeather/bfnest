<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header">
	  <?php get_template_part( 'meta-above', $post_type ); ?>
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
	</header><?php // /.doc-header ?>

	<div class="doc-content">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'nest' ),
					'after'  => '</div>',
				) );
			?>
		</div><?php // /.entry-content ?>

		<footer class="doc-footer">
			<?php get_template_part( 'meta-below', $post_type ); ?>
			<?php nest_scriptless_social_share(); ?>
		</footer>

	    <?php
	      if ( comments_open() || '0' != get_comments_number() ) {
	      	comments_template();
	      } // endif

	      get_template_part( 'postnav', 'single' );
	    ?>

	</div><?php // /.doc-content ?>

</article><?php // /#post-## ?>

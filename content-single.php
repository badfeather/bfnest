<?php
  $post_type = get_post_type();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header doc-header">
	  <?php get_template_part( 'meta-above', $post_type ); ?>
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
	</header>

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

		<footer class="entry-footer doc-footer">
			<?php get_template_part( 'meta-below', $post_type ); ?>
			<?php nest_scriptless_social_share(); ?>
		</footer>

	    <?php
	      if ( comments_open() || '0' != get_comments_number() ) {
	      	comments_template();
	      } // endif

	      nest_postnav_single();
	    ?>

	</div><?php // /.doc-content ?>

</article><?php // /#post-## ?>

<?php
	$post_id = $post->ID;
	$post_type = $post->post_type;
  $post_permalink = esc_url( get_permalink() );
?>
<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>

	<header class="doc__header">
	  <?php get_template_part( 'meta-above', $post_type ); ?>
		<h1 class="entry-title doc__title"><?php echo $post->post_title; ?></h1>
	</header>

	<div class="doc__content">

		<div class="entry-content entry__content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'nest' ),
					'after'  => '</div>',
				) );
			?>
		</div><?php // /.entry-content.entry__content ?>

		<footer class="doc__footer">
			<?php get_template_part( 'meta-below', $post_type ); ?>
			<?php nest_scriptless_social_share(); ?>
		</footer>

    <?php
      if ( comments_open() || '0' != get_comments_number() ) {
      	comments_template();
      } // endif

      nest_postnav_single();
    ?>

	</div><?php // /.doc__content ?>

</article><?php // /#post-## ?>

<?php
	$post_id = $post->ID;
	$post_type = $post->post_type;
  $post_permalink = esc_url( get_permalink() );
?>
<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>

	<header class="doc__header">
		<h1 class="entry-title doc__title"><?php echo $post->post_title; ?></h1>
		<?php
			nest_meta( array(
				nest_get_meta_pubdate(),
				nest_get_meta_author(),
			) );
		?>
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
			<?php
				nest_meta( array(
					nest_get_meta_categories(),
					nest_get_meta_tags(),
					nest_get_meta_comments_link(),
					nest_get_meta_edit_link(),
				) );
			?>
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

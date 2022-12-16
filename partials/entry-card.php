<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'entry', 'card', 'card--' . get_post_type() ] ); ?>>
	<?php bfnest_figure('medium'); ?>

	<header class="entry-header">
		<?php bfnest_content_flag( 'category' ); ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php
		bfnest_meta( array(
			bfnest_get_meta_pubdate(),
			bfnest_get_meta_author(),
			bfnest_get_meta_edit_link()
		) );
		?>
	</header>

	<?php bfnest_excerpt(); ?>
</article>

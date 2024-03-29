<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'entry', 'article', 'article--' . get_post_type() ] ); ?>>
	<header class="entry-header">
		<?php bfnest_content_flag( 'category' ); ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php
		bfnest_meta( [
			bfnest_get_meta_pubdate(),
			bfnest_get_meta_author(),
			bfnest_get_meta_edit_link()
		] );
		?>
	</header>

	<div class="entry-content">
		<?php the_content( __( 'Continue reading &rarr;', 'bfnest' ) ); ?>
	</div>

	<footer class="entry-footer">
		<?php
		bfnest_meta( [
			bfnest_get_meta_categories(),
			bfnest_get_meta_tags(),
			bfnest_get_meta_comments_link()
		] );
		?>
	</footer>
</article>

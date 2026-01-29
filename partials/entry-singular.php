<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'entry', 'singular', 'singular--' . get_post_type() ] ); ?>>
	<header id="doc-header" class="entry-header doc-header">
		<?php bfnest_content_flag( 'category' ); ?>
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
		<?php
		bfnest_meta( [
			bfnest_get_meta_pubdate(),
			bfnest_get_meta_author(),
			bfnest_get_meta_edit_link(),
		] );
		?>
	</header>

	<div id="doc-content" class="doc-content">
		<div class="entry-content blocks is-layout-flow">
			<?php the_content(); ?>
			<?php
			wp_link_pages( [
				'before' => '<div class="page-links">' . __( 'Pages:', 'bfnest' ),
				'after'	=> '</div>',
			] );
			?>
		</div>

		<footer class="entry-footer doc-footer">
			<?php
			bfnest_meta( [
				bfnest_get_meta_categories(),
				bfnest_get_meta_tags()
			] );

			bfnest_meta( [
				bfnest_get_meta_share()
			] );
			?>
		</footer>

		<?php
		if ( comments_open() || '0' != get_comments_number() ) {
			comments_template();
		}

		bfnest_postnav_single();
		?>
	</div>
</article>




<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'entry', 'singular', 'singular--' . get_post_type() ) ); ?>>
	<header class="entry-header doc-header">
		<?php bfnest_content_flag( 'category' ); ?>
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
		<?php
			bfnest_meta( array(
				bfnest_get_meta_pubdate(),
				bfnest_get_meta_author(),
				bfnest_get_meta_edit_link(),
			) );
		?>
		<?php echo '<h2>Is block theme: ' . wp_is_block_theme() . '</h2>'; ?>
	</header>

	<div class="doc-content entry-content-wrap">
		<div class="entry-content blocks is-root-container">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'bfnest' ),
					'after'	=> '</div>',
				) );
			?>
		</div>

		<footer class="entry-footer">
			<?php
				bfnest_meta( array(
					bfnest_get_meta_categories(),
					bfnest_get_meta_tags()
				) );

				bfnest_meta( array(
					bfnest_get_meta_share()
				) );
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




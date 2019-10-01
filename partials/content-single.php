<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'entry', 'entry--single', 'entry--single-' . get_post_type() ) ); ?>>
	<header class="doc-header">
		<h1 class="doc-title entry-title"><?php the_title(); ?></h1>
		<?php
			bfnest_meta( array(
				bfnest_get_meta_pubdate(),
				bfnest_get_meta_author(),
			) );
		?>
	</header>

	<div class="doc-content">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'bfnest' ),
					'after'	=> '</div>',
				) );
			?>
		</div>

		<footer class="doc-footer">
			<?php
				bfnest_meta( array(
					bfnest_get_meta_categories(),
					bfnest_get_meta_tags(),
					bfnest_get_meta_edit_link()
				) );

				bfnest_meta( array(
					bfnest_get_meta_share()
				) );
			?>
		</footer>

		<?php
			if ( comments_open() || '0' != get_comments_number() ) {
				comments_template();
			} // endif

			bfnest_postnav_single();
		?>

	</div>
</article>




<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'entry', 'singular', 'singular--' . get_post_type() ] ); ?>>
	<header class="entry-header doc-header">
		<h1 class="entry-title doc-title"><?php bfnest_title(); ?></h1>

		<?php
		bfnest_meta( array(
			bfnest_get_meta_edit_link(),
		) );
		?>
	</header>

	<div class="doc-content entry-content-wrap">
		<div class="entry-content blocks">
			<?php // bfnest_pretty_print( wp_get_global_settings() ); ?>
			<?php // bfnest_pretty_print( wp_get_global_styles() ); ?>

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



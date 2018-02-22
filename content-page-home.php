<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header">
		<h2 class="entry-title doc-title"><?php the_title(); ?></h2>
	</header>

	<div class="doc-content">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'nest' ),
					'after'	=> '</div>',
				) );
			?>
		</div><?php // /.entry-content ?>

		<footer class="doc-footer">
			<?php
				nest_meta( array(
					nest_get_meta_edit_link()
				) );

				nest_meta( array(
					nest_get_meta_share()
				) );
			?>
		</footer>

	</div><?php // /.doc-content ?>

</article><?php // /#post-## ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc__header">
		<h1 class="entry-title doc__title"><?php the_title(); ?></h1>
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
					nest_get_meta_edit_link()
				) );

				nest_meta( array(
					nest_get_meta_share()
				) );
			?>
		</footer>

	</div><?php // /.doc__content ?>

</article><?php // /#post-## ?>

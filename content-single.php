<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header">
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
		<?php
			nest_meta( array(
				nest_get_meta_pubdate(),
				nest_get_meta_author(),
			) );
		?>
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
					nest_get_meta_categories(),
					nest_get_meta_tags(),
					nest_get_meta_edit_link()
				) );

				nest_meta( array(
					nest_get_meta_share()
				) );
			?>
		</footer>

		<?php
			if ( comments_open() || '0' != get_comments_number() ) {
				comments_template();
			} // endif

			nest_postnav_single();
		?>

	</div><?php // /.doc-content ?>

</article><?php // /#post-## ?>

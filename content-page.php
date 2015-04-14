<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header">
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
	</header><?php // /.doc-header ?>

	<div class="doc-content">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'nest' ),
					'after'  => '</div>',
				) );
			?>
		</div><?php // /.entry-content ?>

		<?php edit_post_link( __( 'Edit', 'nest' ), '<footer class="entry-footer"><div class="entry-meta"><span class="meta meta-edit-link">', '</span></div></footer>' ); ?>

	</div><?php // /.doc-content ?>

</article><?php // /#post-## ?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc__header">
		<h1 class="entry-title doc__title"><?php the_title(); ?></h1>
	</header>

	<div class="doc__content">

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

	</div><?php // /.doc__content ?>

</article><?php // /#post-## ?>


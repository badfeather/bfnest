<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header">
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
	</header><!-- /.doc-header -->

	<div class="doc-main doc-main-page">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'bfn' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- /.entry-content -->

		<?php edit_post_link( __( 'Edit', 'bfn' ), '<footer class="entry-meta entry-footer"><span class="meta meta-edit">', '</span></footer>' ); ?>

	</div><!-- /.doc-main.doc-main-page -->

</article><!-- #post-## -->
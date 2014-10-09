<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header">
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
	</header><!-- /.doc-header -->

	<div class="doc-content doc-content-page">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'nest' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- /.entry-content -->

		<?php nest_meta_below(); ?>

	</div><!-- /.doc-content.doc-content-page -->

</article><!-- #post-## -->


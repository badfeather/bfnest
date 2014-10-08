<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header">
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
		<?php get_template_part( 'meta-above' ); ?>
	</header><!-- /.doc-header -->

	<div class="doc-content doc-content-single">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'nest' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- /.entry-content -->

		<?php get_template_part( 'meta-below' ); ?>

    <?php
      if ( comments_open() || '0' != get_comments_number() ) {
      	comments_template();
      } // endif

      nest_single_pager();
    ?>

	</div><!-- /.doc-content.doc-content-single -->

</article><!-- #post-## -->


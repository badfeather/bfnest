<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header">
	  <?php nest_posted_on(); ?>
		<h1 class="entry-title doc-title"><?php the_title(); ?></h1>
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

		<footer class="entry-footer">
			<?php nest_meta(); ?>
			<?php nest_scriptless_social_share(); ?>
		</footer>

	    <?php
	      if ( comments_open() || '0' != get_comments_number() ) {
	      	comments_template();
	      } // endif

	      nest_single_pager();
	    ?>

	</div><!-- /.doc-content.doc-content-single -->

</article><!-- #post-## -->


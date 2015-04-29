<article id="post-<?php the_ID(); ?>" <?php post_class( 'excerpt' ); ?>>

	<header class="entry-header">
	  <?php nest_meta_above(); ?>
		<h1 class="entry-title excerpt-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</header><?php // /.doc-header ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><?php // /.entry-summary ?>

	<?php nest_edit_footer(); ?>

</article><?php // /#post-## ?>

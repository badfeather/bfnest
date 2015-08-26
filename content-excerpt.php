<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--excerpt' ); ?>>

	<header class="entry__header">
	  <?php nest_meta_above(); ?>
		<h1 class="entry-title excerpt-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</header><?php // /.entry__header ?>

	<div class="entry__content.entry-summary">
		<?php the_excerpt(); ?>
	</div><?php // /.entry__content.entry-summary ?>

	<?php nest_edit_footer(); ?>

</article><?php // /#post-##.entry.entry--excerpt ?>

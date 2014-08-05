<article id="post-<?php the_ID(); ?>" <?php post_class( 'excerpt' ); ?>>

	<header class="entry-header">
		<h1 class="entry-title excerpt-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php get_template_part( 'meta-above' ); ?>
	</header><!-- /.doc-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- /.entry-summary -->

</article><!-- #post-## -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php nest_meta_above(); ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</header><!-- /.entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading &rarr;', 'nest' ) ); ?>
	</div><!-- /.entry-content -->

	<?php nest_meta_below(); ?>

</article><!-- #post-## -->
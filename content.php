<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php nest_posted_on(); ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</header><!-- /.entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading &rarr;', 'nest' ) ); ?>
	</div><!-- /.entry-content -->

	<footer class="entry-footer">
		<?php nest_meta(); ?>
		<?php nest_scriptless_social_share(); ?>
	</footer>

</article><!-- #post-## -->
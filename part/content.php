<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

		<?php get_template_part( '/part/meta-above' ); ?>

	</header><!-- /.entry-header -->

	<div class="entry-content">

		<?php the_content( __( 'Continue reading &rarr;', 'bfn' ) ); ?>

	</div><!-- /.entry-content -->

	<?php get_template_part( '/part/meta-below' ); ?>

</article><!-- #post-## -->
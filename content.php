<?php
	$post_id = $post->ID;
	$post_type = $post->post_type;
	$post_title = $post->post_title;
  $post_permalink = esc_url( get_permalink() );
?>
<article id="post-<?php echo $post_id; ?>" <?php post_class( 'entry' ); ?>>

	<header class="entry__header">
		<h1 class="entry-title entry__title"><a href="<?php echo $post_permalink; ?>"><?php echo $post_title; ?></a></h1>
		<?php get_template_part( 'meta-above', $post_type ); ?>
	</header>

	<div class="entry-content entry__content">
		<?php the_content( __( 'Continue reading &rarr;', 'nest' ) ); ?>
	</div><?php // /.entry__content.entry-content ?>

	<footer class="entry__footer">
		<?php get_template_part( 'meta-below', $post_type ); ?>
	</footer>

</article><?php // /#post-##.entry ?>

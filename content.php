<?php
  $post_type = get_post_type();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<header class="entry__header">
		<?php get_template_part( 'meta-above', $post_type ); ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</header>

	<div class="entry__content entry-content">
		<?php the_content( __( 'Continue reading &rarr;', 'nest' ) ); ?>
	</div><?php // /.entry__content.entry-content ?>

	<footer class="entry__footer">
		<?php get_template_part( 'meta-below', $post_type ); ?>
		<?php nest_scriptless_social_share(); ?>
	</footer>

</article><?php // /#post-##.entry ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<header class="entry__header">
		<h2 class="entry-title entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php
			nest_meta( array(
				nest_get_meta_pubdate(),
				nest_get_meta_author(),
			) );
		?>
	</header>

	<div class="entry-content entry__content">
		<?php the_content( __( 'Continue reading &rarr;', 'nest' ) ); ?>
	</div><?php // /.entry__content.entry-content ?>

	<footer class="entry__footer">
		<?php
			nest_meta( array(
				nest_get_meta_categories(),
				nest_get_meta_tags(),
				nest_get_meta_comments_link(),
				nest_get_meta_edit_link()
			) );
		?>
	</footer>

</article><?php // /#post-##.entry ?>

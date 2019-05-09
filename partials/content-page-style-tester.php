<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="doc-header>">
		<h1 class="doc-title entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="doc-content">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'bfnest' ),
					'after'	=> '</div>',
				) );
			?>
			<?php get_template_part( 'partials/style-tester' ); ?>
		</div>

		<?php bfnest_edit_footer(); ?>

	</div>

</article>




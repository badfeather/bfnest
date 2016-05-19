<?php get_header(); ?>

		<div class="inner doc__inner">
			<main class="doc__main doc__main--archive">

			<?php if ( have_posts() ) { ?>

				<div id="content" class="doc__content entries">
					<?php
						while ( have_posts() ) {
							the_post();
							get_template_part( 'content', get_post_type() );
						}

						nest_postnav_archive();
					?>
				</div><?php // /#content.doc__content.entries ?>

			<?php
				} else {
					get_template_part( 'content', 'no-results' );
				} // endif
			?>

			</main><?php // /.doc__main.doc__main--archive ?>

			<?php get_sidebar(); ?>
		</div><?php // /.inner.doc__inner ?>

<?php get_footer(); ?>

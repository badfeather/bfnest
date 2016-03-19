<?php get_header(); ?>

		<main class="doc__main doc__main--archive doc__main--search">

			<?php
				if ( have_posts() ) {
			?>

				<header class="doc__header">
					<h1 class="doc__title"><?php printf( __( 'Search Results for %s', 'nest' ), get_search_query() ); ?></h1>
				</header>

				<div id="content" class="doc__content entries">

					<?php
						while ( have_posts() ) {
							the_post();
							get_template_part( 'content', get_post_type() );
						} // endwhile

						nest_postnav_archive();
					?>

				</div><?php // /#content.doc__content.entries ?>

			<?php
				} else {
					get_template_part( 'content', 'no-results' );
				} // endif
			?>
		</main><?php // /.doc__main.doc__main--archive.doc__main--search ?>

		<?php get_sidebar(); ?>

<?php get_footer(); ?>

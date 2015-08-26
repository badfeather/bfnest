<?php get_header(); ?>

		<main class="doc__main doc__main--archive" role="main">

			<?php
				if ( have_posts() ) {
			?>

				<header class="doc__header">
					<h1 class="doc__title"><?php
						if ( is_category() || is_tag() || is_tax() ) {
							single_term_title();

						} elseif ( is_post_type_archive() ) {
							post_type_archive_title();

						} elseif ( is_author() ) {
							$author = get_queried_object();
							printf( __( 'Author: %s', 'nest' ), '<span>' . $author->display_name . '</span>' );

						} elseif ( is_day() ) {
							printf( __( 'Day: %s', 'nest' ), '<span>' . get_the_date() . '</span>' );

						} elseif ( is_month() ) {
							printf( __( 'Month: %s', 'nest' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

						} elseif ( is_year() ) {
							printf( __( 'Year: %s', 'nest' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
						} else {
							_e( 'Archives', 'nest' );
						}
					?></h1>

					<?php
						// Show an optional term description.
						$term_description = term_description();
						if ( ! empty( $term_description ) )
							printf( __( '<div class="description">%s</div>', 'nest' ), $term_description );
					?>
				</header>

				<div class="doc__content entries">

					<?php
						while ( have_posts() ) {
							the_post();
							get_template_part( 'content', get_post_type() );
						} // endwhile

						nest_postnav_archive();
					?>

				</div><?php // /.doc__content.entries ?>

			<?php
				} else {
					get_template_part( 'content', 'no-results' );
				} // endif
			?>
		</main><?php // /.doc__main.doc__main--archive ?>

		<?php get_sidebar(); ?>

<?php get_footer(); ?>

<?php get_header(); ?>

		<div id="content" class="doc doc--archive site-main">
			<div class="inner doc__inner">
				<main class="doc-main">
					<?php nest_taxonomy_subnav( $title = 'TEST TAX SUBNAV' ); ?>

					<?php
						if ( have_posts() ) {
							$term = get_queried_object();
					?>

						<header class="doc-header">
							<h1 class="doc-title"><?php
								if ( is_category() || is_tag() || is_tax() ) {
									echo $term->name;

								} elseif ( is_post_type_archive() ) {
									echo $term->labels->name;

								} elseif ( is_author() ) {
									printf( __( 'Author: %s', 'nest' ), '<span>' . $term->display_name . '</span>' );

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
								$term_description = $term->description;
								if ( ! empty( $term_description ) && ! is_paged() )
									printf( __( '<div class="description">%s</div>', 'nest' ), $term_description );
							?>
						</header>

						<div id="content" class="doc-content entries">

							<?php
								while ( have_posts() ) {
									the_post();
									get_template_part( 'content', get_post_type() );
								} // endwhile
							?>

						</div><?php // /#content.doc-content.entries ?>

						<?php nest_postnav_archive(); ?>

					<?php
						} else {
							get_template_part( 'content', 'no-results' );
						} // endif
					?>
				</main><?php // /.doc-main ?>

				<?php get_sidebar(); ?>
			</div><?php // /.inner.doc__inner ?>
		</div><?php // /.doc.doc--archive.site-main ?>

<?php get_footer(); ?>

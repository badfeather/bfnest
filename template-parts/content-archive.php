<?php
	$post_type = ( is_post_type_archive() ? get_query_var( 'post_type' ) : '' );
?>
<main class="doc-main">

		<header class="doc-header">
			<h1 class="doc-title"><?php
				if ( is_post_type_archive() ) {
					post_type_archive_title();

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
		</header>

		<?php get_template_part( 'template-parts/loop-archive', $post_type ); ?>

</main><?php // /.doc-main ?>

<?php get_template_part( 'template-parts/sidebar-archive', $post_type ); ?>

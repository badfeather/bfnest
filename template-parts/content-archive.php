<?php
	$title = '';
	if ( is_category() ) {
	  $title = sprintf( __( 'Category: %s' ), single_cat_title( '', false ) );

	} elseif ( is_tag() ) {
	  $title = sprintf( __( 'Tag: %s' ), single_tag_title( '', false ) );

	} elseif ( is_author() ) {
	  $title = sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );

	} elseif ( is_year() ) {
	  $title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );

	} elseif ( is_month() ) {
	  $title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );

	} elseif ( is_day() ) {
	  $title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );

	} elseif ( is_post_type_archive() ) {
	  $title = sprintf( __( 'Archives: %s' ), post_type_archive_title( '', false ) );

	} elseif ( is_tax() ) {
	  $tax = get_taxonomy( get_queried_object()->taxonomy );
	  $title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );

	} else {
	  $title = __( 'Archives' );
	}
?>
<header class="doc-header">
	<h1 class="doc-title"><?php echo $title; ?></h1>

	<?php the_archive_description( '<div class="description">', '</div>' ); ?>
</header>

<?php get_template_part( 'template-parts/loop-archive' ); ?>



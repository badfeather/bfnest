<?php get_header(); ?>

<?php 
	if ( have_posts() ) { 
		$post_type = ( is_post_type_archive() ? get_query_var( 'post_type' ) : '' );
		
		$title = '';
		$archive_class = '';
		if ( is_category() ) {
		  $title = sprintf( __( 'Category: %s', 'bfnest'  ), single_cat_title( '', false ) );
		  $archive_class = ' doc--archive-category';
	
		} elseif ( is_tag() ) {
		  $title = sprintf( __( 'Tag: %s', 'bfnest'  ), single_tag_title( '', false ) );
		  $archive_class = ' doc--archive-tag';
	
		} elseif ( is_author() ) {
		  $title = sprintf( __( 'Author: %s', 'bfnest'  ), '<span class="vcard">' . get_the_author() . '</span>' );
		  $archive_class = ' doc--archive-author';
	
		} elseif ( is_year() ) {
		  $title = sprintf( __( 'Year: %s', 'bfnest'  ), get_the_date( _x( 'Y', 'yearly archives date format', 'bfnest' ) ) );
		  $archive_class = ' doc--archive-year';
	
		} elseif ( is_month() ) {
		  $title = sprintf( __( 'Month: %s', 'bfnest'  ), get_the_date( _x( 'F Y', 'monthly archives date format', 'bfnest' ) ) );
		  $archive_class = ' doc--archive-month';
	
		} elseif ( is_day() ) {
		  $title = sprintf( __( 'Day: %s', 'bfnest'  ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'bfnest' ) ) );
		  $archive_class = ' doc--archive-day';
	
		} elseif ( is_post_type_archive() ) {
		  $title = sprintf( __( 'Archives: %s', 'bfnest'  ), post_type_archive_title( '', false ) );
		  $archive_class = ' doc--archive-' . $post_type;
	
		} elseif ( is_tax() ) {
		  $tax = get_taxonomy( get_queried_object()->taxonomy );
		  $title = sprintf( __( '%1$s: %2$s', 'bfnest'  ), $tax->labels->singular_name, single_term_title( '', false ) );
		  $archive_class = ' doc--archive-taxonomy-' . $tax->name;
	
		} else {
		  $title = __( 'Archives', 'bfnest'  );
		}
?>
	<div class="site-content doc doc--archive<?php echo esc_attr( $archive_class ); ?>">
		<main id="content" class="doc__main">
			<header class="doc__header">
				<h1 class="doc__title"><?php echo esc_html( $title ); ?></h1>
				
				<?php the_archive_description( '<div class="doc__description">', '</div>' ); ?>
			</header>
			
			<?php get_template_part( 'partials/loop-archive' ); ?>
		</main>
		
		<?php get_template_part( 'partials/sidebar-archive', $post_type ); ?>
	</div>
<?php
	} else {
		get_template_part( 'partials/content', 'no-results' );
	}
?>
<?php get_footer(); ?>

<?php
global $wp_query, $post;
$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
$next = get_adjacent_post( false, '', false );

if ( $next || $previous ) {
?>
<div class="doc-nav doc-nav-single">
	<?php
	  next_post_link( '<div class="nav-link nav-link-prev">%link</div>', _x( '&larr;&nbsp;%title', 'Next post link', 'nest' ) );
    previous_post_link( '<div class="nav-link nav-link-next">%link</div>', _x( '%title&nbsp;&rarr;', 'Previous post link', 'nest' ) );
  ?>
</div><?php // /.doc-nav.doc-nav-single ?>
<?php
} // endif

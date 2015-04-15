<?php
global $wp_query, $post;
$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
$next = get_adjacent_post( false, '', false );

if ( $next || $previous ) {
?>
<div class="postnav postnav--single">
	<?php
	  next_post_link( '<div class="postnav__link postnav__link--prev">%link</div>', _x( '&larr;&nbsp;%title', 'Next post link', 'nest' ) );
    previous_post_link( '<div class="postnav__link postnav__link--next">%link</div>', _x( '%title&nbsp;&rarr;', 'Previous post link', 'nest' ) );
  ?>
</div><?php // /.postnav.postnav--single ?>
<?php
} // endif


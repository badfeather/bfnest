<?php
global $wp_query, $post;
if ( $wp_query->max_num_pages > 1 ) {
?>
	<nav class="postnav postnav--archive">
  	<?php if ( get_previous_posts_link() ) { ?>
  	  <div class="postnav__link postnav__link--prev"><?php previous_posts_link( __( '&larr; Prev', 'nest' ) ); ?></div>
  	<?php } ?>
  	<?php if ( get_next_posts_link() ) { ?>
  	  <div class="postnav__link postnav__link--next"><?php next_posts_link( __( 'Next &rarr;', 'nest' ) ); ?></div>
  	<?php } ?>
	</nav><?php // /.postnav.postnav--archive ?>
<?php
} // endif


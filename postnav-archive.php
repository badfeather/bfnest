<?php
global $wp_query, $post;
if ( $wp_query->max_num_pages > 1 ) {
?>
	<div class="doc-nav doc-nav-archive">
  	<?php if ( get_previous_posts_link() ) { ?>
  	  <div class="nav-link nav-link-prev"><?php previous_posts_link( __( '&larr; Prev', 'nest' ) ); ?></div>
  	<?php } ?>
  	<?php if ( get_next_posts_link() ) { ?>
  	  <div class="nav-link nav-link-next"><?php next_posts_link( __( 'Next &rarr;', 'nest' ) ); ?></div>
  	<?php } ?>
	</div><?php // /.doc-nav.doc-nav-archive ?>
<?php
} // endif


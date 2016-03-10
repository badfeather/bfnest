<?php
  if ( post_password_required() ) {
  	return;
  }
?>

<section id="comments" class="entry-comments comments-area">

	<?php if ( have_comments() ) { ?>
		<h2 class="section__title comments__title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'nest' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style' => 'ol',
					'short_ping' => true,
					'callback' => 'nest_comment'
				) );
			?>
		</ol><?php // /.comment-list ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
  		<nav class="postnav postnav--comments" role="navigation">
  			<h1 class="screen-reader-text"><?php _e( 'Comment Navigation', 'nest' ); ?></h1>
  			<div class="postnav__link postnav__link--prev"><?php previous_comments_link( __( '&larr; Older Comments', 'nest' ) ); ?></div>
  			<div class="postnav__link postnav__link--next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'nest' ) ); ?></div>
  		</nav><?php #comment-nav-below ?>
		<?php } // endif ?>

	<?php } // endif have_comments ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) { ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'nest' ); ?></p>
	<?php } // endif ?>

	<?php comment_form(); ?>

</section><?php // /#comments.entry-comments.comments-area ?>

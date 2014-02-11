<?php
	if ( post_password_required() )
		return;
?>

<section id="comments" class="entry-comments">

	<?php if ( have_comments() ) { ?>
		<h1 class="comments-title">
			<?php
				printf(
					_nx(
						'One thought on &ldquo;%2$s&rdquo;',
						'%1$s thoughts on &ldquo;%2$s&rdquo;',
						get_comments_number(),
						'comments title',
						'_bfn'
					),
					number_format_i18n(
						get_comments_number()
					),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h1>

		<ol class="comment-list">
			<?php wp_list_comments(); ?>
		</ol><!-- /.comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', '_bfn' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', '_bfn' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', '_bfn' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php } // endif check for comment navigation ?>

	<?php } // endif have_comments() ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) { ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', '_bfn' ); ?></p>
	<?php } // endif ?>

	<?php comment_form(); ?>

</section><!-- /#comments.comments -->

<?php

/**
 * Comment listing
 */
function nest_comment( $comment, $args, $depth, $meta_sep = ' | ' ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) {
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment__body">
			<?php _e( 'Pingback:', 'nest' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'nest' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

<?php
	} else { // else if not pingback or trackback
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment__body">
			<header class="comment-meta comment-header">
				<span class="comment__author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s', 'nest' ), sprintf( '<cite class="fn meta meta-author">%s</cite>', get_comment_author_link() ) ); ?>
				</span><?php // / /.comment__author ?>

				<?php echo $meta_sep; ?><a class="meta meta--comment--time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ago'; ?>
					</time>
				</a>
				<?php edit_comment_link( __( 'Edit', 'nest' ), $meta_sep . '<span class="meta meta--edit">', '</span>' ); ?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<div class="comment-awaiting-moderation"><?php echo $meta_sep; ?><?php _e( 'Your comment is awaiting moderation.', 'nest' ); ?></div>
				<?php endif; ?>
			</header><?php // / /.comment-meta.comment-header ?>

			<div class="comment-main">
				<div class="comment-content">
					<?php comment_text(); ?>
				</div><?php // / /.comment-content ?>
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'			=> $depth,
						'max_depth' => $args['max_depth'],
						'before'		=> '<div class="comment-meta comment-meta--reply"><span class="meta meta--reply">',
						'after'			=> '</div></div>',
					) ) );
				?>
			</div><?php // / /.comment-main ?>
		</article><?php // / /.comment__body ?>
<?php
	} // endif
} // nest_comment

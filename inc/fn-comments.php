<?php

/**
 * Comment listing
 */
function bfnest_comment( $comment, $args, $depth, $meta_sep = ' | ' ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) {
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment__body">
			<?php _e( 'Pingback:', 'bfnest' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'bfnest' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

<?php
	} else { // else if not pingback or trackback
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment__body">
			<header class="comment-meta comment-header">
				<span class="comment__author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s', 'bfnest' ), sprintf( '<cite class="fn meta meta-author">%s</cite>', get_comment_author_link() ) ); ?>
				</span>

				<?php echo $meta_sep; ?><a class="meta meta--comment--time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ago'; ?>
					</time>
				</a>
				<?php edit_comment_link( __( 'Edit', 'bfnest' ), $meta_sep . '<span class="meta meta--edit">', '</span>' ); ?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<div class="comment-awaiting-moderation"><?php echo $meta_sep; ?><?php _e( 'Your comment is awaiting moderation.', 'bfnest' ); ?></div>
				<?php endif; ?>
			</header>

			<div class="comment-main">
				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth' => $depth,
						'max_depth' => $args['max_depth'],
						'before' => '<div class="comment-meta comment-meta--reply"><span class="meta meta--reply">',
						'after' => '</span></div>',
					) ) );
				?>
			</div>
		</article>
<?php
	} // endif
} // bfnest_comment

/**
 * Customize output of comment form
 */
function bfnest_comment_form( $args ) {
    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';
    if ( ! isset( $args['format'] ) )
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
    $req = get_option( 'require_name_email' );
    $html_req = ( $req ? " required='required'" : '' );
    $html5 = 'html5' === $args['format'];

	$args['fields'] = array(
		'author' => '<p class="comment-form-author form-group">' . '<label for="author">' . __( 'Name', 'bfnest' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		'<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" maxlength="245"' . $html_req . ' /></p>',
		'email' => '<p class="comment-form-email form-group"><label for="email">' . __( 'Email', 'bfnest' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		'<input id="email" class="form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></p>',
		'url' => '<p class="comment-form-url form-group"><label for="url">' . __( 'Website', 'bfnest' ) . '</label> ' .
		'<input id="url" class="form-control" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" maxlength="200" /></p>',
	);

	$args['comment_field'] = '<p class="comment-form-comment form-group"><label for="comment">' . _x( 'Comment', 'noun', 'bfnest' ) . '</label> <textarea id="comment" class="form-control" name="comment" rows="8" maxlength="65525" required="required"></textarea></p>';

	$args['class_submit'] = 'submit button';

    return $args;
}
add_filter( 'comment_form_defaults', 'bfnest_comment_form' );

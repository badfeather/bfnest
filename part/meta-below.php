<footer class="entry-footer">

	<div class="entry-meta">
		<?php
			$id = get_the_id();
			$meta_sep = ' | ';
			$item_sep = ', ';

			echo get_the_term_list( $id, 'category', '<span class="meta meta-cats">' . __( 'Posted in: ', 'bfn' ), $item_sep, '</span>' );

			echo get_the_term_list( $id, 'post_tag', $meta_sep . '<span class="meta meta-tags">' . __( 'Tagged: ', 'bfn' ), $item_sep, '</span>' );

			if ( comments_open() ) {
				echo $meta_sep . '<span class="meta meta-comment-link">';
				comments_popup_link( __( 'Leave a comment', 'bfn' ), __( '1 Comment', 'bfn' ), __( '% Comments', 'bfn' ) );
				echo '</span>';
			} // endif

			edit_post_link( __( 'Edit', 'bfn' ), $meta_sep . '<span class="meta meta-edit-link">', '</span>' );
		?>
	</div><!-- /.entry-meta -->

	<?php bfn_scriptless_social_share(); ?>
</footer>
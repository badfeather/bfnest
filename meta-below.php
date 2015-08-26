<?php

global $post;
$id = $post->ID;
$meta_sep = ' | ';
$item_sep = ', ';

$meta_array = array();
if ( 'post' == get_post_type() ) {

  // categories
  $meta_array[] = get_the_term_list( $id, 'category', '<span class="meta meta--cats"><span class="meta__title">' . __( 'Posted in: ', 'nest' ) . '</span>', $item_sep, '</span>' );

  // tags
  $meta_array[] = get_the_term_list( $id, 'post_tag', '<span class="meta meta--tags"><span class="meta__title">' . __( 'Tagged: ', 'nest' ) . '</span>', $item_sep, '</span>' );

  // comments
  if ( comments_open() ) {
    $comments_count = get_comments_number();
    if ( $comments_count == 0 ) {
      $meta_array[] = '<span class="meta meta--comment"><a href="' . get_comments_link() . '">' . __( 'Comment', 'nest' ) . '</a></span>';
    } else {
      $meta_array[] = sprintf( '<span class="meta meta--comment"><a href="' . get_comments_link() . '">' . _n( '1 Comment', '%s Comments', $comments_count, 'nest' ), $comments_count . '</a></span>' );
    }
  }
}
if ( get_edit_post_link() ) {
  $meta_array[] = '<span class="meta meta--edit"><a href="' . get_edit_post_link() . '">' . __( 'Edit', 'nest' ) . '</a></span>';
}

if ( ! empty( $meta_array ) ) {
  echo "\t" . '<div class="entry__meta">' . implode( $meta_sep, array_filter( $meta_array ) ) . '</div>' . "\n";
}

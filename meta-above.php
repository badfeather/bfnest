<?php
// uncomment below as needed for meta functions
$post = get_post();
$post_id = $post->ID;
$post_type = $post->post_type;
//$edit_post_link = get_edit_post_link();
$meta_array = array();
$meta_sep = ' | ';
$item_sep = ', ';

if ( 'post' == $post_type ) {

  // published date
  $meta_array[] = '<span class="meta meta--published"><time class="published" datetime = "' . get_the_time( 'c' ) . '">' . get_the_date() . '</time></span>';

  // author
  $meta_array[] = '<span class="meta meta--author"><span class="meta__title">' . __( 'Author: ', 'bsb' ) . '</span><span class="byline author vcard"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . get_the_author() . '</a></span></span>';

}

if ( ! empty( $meta_array ) ) {
  echo "\t" . '<div class="entry__meta">' . implode( $meta_sep, array_filter( $meta_array ) ) . '</div>' . "\n";
}

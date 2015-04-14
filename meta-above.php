<div class="entry-meta">
  <?php
    printf(
      __( '%1$s by %2$s', 'nest' ),
      '<span class="meta meta-published"><time class="published" datetime = "' . get_the_time( 'c' ) . '">' . get_the_date() . '</time></span>',
      '<span class="meta meta-author byline author vcard"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . get_the_author() . '</a></span>'
    );
  ?>
</div><?php // /.entry-meta ?>

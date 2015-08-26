<?php

/**
 * Postnav single
 */
function nest_postnav_single( $in_same_term = false, $taxonomy = 'category', $excluded_terms = array() ) {
  global $wp_query, $post;
  $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
  $next = get_adjacent_post( false, '', false );

  if ( $next || $previous ) {
  ?>
  <div class="postnav postnav--single">
  	<?php
  	  next_post_link( '<div class="postnav__link postnav__link--prev">%link</div>', _x( '&larr;&nbsp;%title', 'Next post link', 'nest' ), $in_same_term, $excluded_terms, $taxonomy );
      previous_post_link( '<div class="postnav__link postnav__link--next">%link</div>', _x( '%title&nbsp;&rarr;', 'Previous post link', 'nest' ), $in_same_term, $excluded_terms, $taxonomy );
    ?>
  </div><?php // /.postnav.postnav--single ?>
  <?php
  } // endif
}

/**
 * Postnav archives
 */
function nest_postnav_archive() {
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
}

/**
 * Comment listing
 */
function nest_comment( $comment, $args, $depth, $meta_sep = ' | ' ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) {
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'nest' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'nest' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

<?php
	} else { // else if not pingback or trackback
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<span class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s', 'nest' ), sprintf( '<cite class="fn meta meta-author">%s</cite>', get_comment_author_link() ) ); ?>
				</span><!-- /.comment-author -->

				<?php echo $meta_sep; ?><a class="meta meta-comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<time datetime="<?php comment_time( 'c' ); ?>">
						 <?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ago'; ?>
					</time>
				</a>
				<?php edit_comment_link( __( 'Edit', 'nest' ), $meta_sep . '<span class="meta meta-edit">', '</span>' ); ?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<div class="comment-awaiting-moderation"><?php echo $meta_sep; ?><?php _e( 'Your comment is awaiting moderation.', 'nest' ); ?></div>
				<?php endif; ?>
			</footer><!-- /.comment-meta -->

			<div class="comment-main">
				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- /.comment-content -->
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="comment-meta meta-reply">',
						'after'     => '</div>',
					) ) );
				?>
			</div><!-- /.comment-main -->
		</article><!-- /.comment-body -->
<?php
	} // endif
} // nest_comment


/**
 * Get the first image from a post
 * Must be used within the loop
 * Use nest_get_first_image( $atts ) in template, much like get_the_post_thumbnail()
 * Atts defaults:
 * 'size' => 'thumbnail'
 * 'output' => 'img' // can be either 'img' or 'url'
 * 'link' => false // if true, will link to full version of itself
 */
function nest_get_first_image( $post_id = null, $size = 'thumbnail', $atts = array() ) {
  $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$defaults = array(
		'output' => 'img', // accepts either 'img' or 'url'
		'link' => false // ignored if output is set to url
	);

	$atts = wp_parse_args( $atts, $defaults );
	extract( $atts, EXTR_SKIP );

	$query_args = array(
		'post_parent' => $post_id,
		'post_type' => 'attachment',
		'numberposts' => 1,
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'post_mime_type' => 'image'
	);
	$images = get_children( $query_args );
	if ( $images ) {
		foreach ( $images as $image ) {
			$img = wp_get_attachment_image( $image->ID, $size );
			$img_src = wp_get_attachment_image_src( $image->ID, $size );
			$img_url = $img_src[0];
			$img_full_url = wp_get_attachment_url( $image->ID );
			$img_link = get_permalink( $image->post_parent );
			$img_title = $image->post_title;
			$img_caption = $image->post_excerpt;
			$img_desc = $image->post_content;

			if ( 'img' == $output ) {
				if ( $link ) {
					return '<a href="' . $img_full_url . '>">' . $img . '</a>';
				} else {
					return $img;
				} // endif $link

			} elseif ( 'url' == $output ) {
					return $img_url;
			} // endif $output - 'img'

		} // endforeach
	} // endif ( $images )
}

/**
 * Echoes the first image from a post using arguments from nest_get_first_image() function
 * Much like the_post_thumbnail
 */
function nest_first_image( $post_id = null, $size = 'thumbnail', $atts = array() ) {
	echo nest_get_first_image( $post_id, $size, $atts );
}

/**
 * Echoes the first image from a post using arguments from nest_get_first_image() function
 * Much like the_post_thumbnail
 */
function nest_get_first_image_url( $post_id = null, $size = 'thumbnail' ) {
	return nest_get_first_image( $post_id, $size, $atts = array( 'output' => 'url' ) );
}

/**
 * Get featured or first image
 * must be used within the loop
 */
function nest_get_featured_or_first_image( $post_id = null, $size = 'thumbnail' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail( $post_id, $size );

	} else {
		return nest_get_first_image( $post_id, $size, $atts = array( 'output' => 'img' ) );
	}
}

/**
 * Featured or first image
 * must be used within the loop
 */
function nest_featured_or_first_image( $post_id = null, $size = 'thumbnail' ) {
	echo nest_get_featured_or_first_image( $post_id, $size );
}

/**
 * Email encode shortcode - use on pages and posts as follows [email]you@you.com[/email]
 * via http://bavotasan.com/2012/shortcode-to-encode-email-in-wordpress-posts/
 */
function nest_mailto_encode( $atts, $content ) {
	return '<a href="'. antispambot( 'mailto:'. $content ) .'">'. antispambot( $content ) .'</a>';
}
add_shortcode( 'email', 'nest_mailto_encode' );

/**
 * Returns only encoded mailto address, for use with links having custom text (not the email address) as the linked text
 * ie. '<a href="[mailto]you@you.com[/mailto]">Example link</a>'
 */
function nest_email_address_encode( $atts, $content ) {
	return antispambot( 'mailto:'. $content );
}
add_shortcode( 'mailto', 'nest_email_address_encode' );

/**
 * Post is in descendant category
 * See http://codex.wordpress.org/Function_Reference/in_category
 */
function nest_post_is_in_descendant_category( $cats, $_post = null ) {
	foreach ( (array) $cats as $cat ) {
		// get_term_children() accepts integer ID only
		$descendants = get_term_children( (int) $cat, 'category' );
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}

/**
 * Inherit category template by category id
 * Checks if current category is child of category id that has a template
 */
function nest_inherit_category_template() {
	if ( is_category() ) {
		$catid = get_query_var( 'cat' );
		$cat = get_category( $catid );
		$parent = $cat->category_parent;
		while ( $parent ) {
			$cat = get_category( $parent );
			if ( locate_template('category-' . $catid . '.php') != '' ) {
				get_template_part( 'category', $catid );
				exit;
			} // endif
		} // endwhile
	} // endif
}
// uncomment below statement to make it work
// add_action( 'template_redirect', 'nest_inherit_category_template' );


/**
 * Get top parent page id - used in page subnav function
 */
function nest_get_top_parent_page_id() {
    global $post;
    $ancestors = $post->ancestors;
    if ( $ancestors ) {
        return end( $ancestors );
    } else {
        return $post->ID;
    }
}

/**
 * test if is a descendant page of a particular page id
 * modified/cleaned up version of is_tree function found here: http://codex.wordpress.org/Conditional_Tags
 */
function nest_is_descendant_page( $page_id ) {
	global $post;
	$ancestors = get_post_ancestors( $post->ID );
	foreach ( $ancestor as $ancestor ) {
		if ( is_page() && $ancestor == $pag_id )
			return true;
	}
	if ( is_page() && is_page( $page_id ) )
		return true;

	else
		return false;
};

// page subnav function
function nest_page_subnav( $page_id = '', $title = '' ) {
	global $post;
	if ( $page_id ) {
		$top_parent = $page_id;
	} else {
		$top_parent = nest_get_top_parent_page_id( $post->ID );
	}
	$children = wp_list_pages( array(
		'sort_column' => 'menu_order',
		'title_li' => '',
		'child_of' => $top_parent,
		'echo' => 0
	) );
	$top_parent_name = get_the_title( $top_parent );
	if ( $children != '' ) {
?>
<nav class="widget widget-subnav">
<h1 class="widget-title nav-title"><?php
	if ( $title ) {
		echo $title;
	} else {
		echo $top_parent_name;
  }
?></h1>
<div class="widget-content">
	<ul class="menu menu-secondary">
		<?php echo $children; ?>
	</ul>
</div><!-- .widget-content -->
</nav><!-- .widget.widget-subnav -->
<?php
	} // endif
}

/**
 * Subnav of current category's topmost parent's children, outputted as widget
 * todo - make it an actual widget
 */
function nest_category_subnav() {
	global $post;
	if ( is_category() || is_single() ) {
		$categories = get_the_category();
		$category = array_shift( $categories );
		$top_parent = ( $category->category_parent ) ? $category->category_parent : $category->cat_ID;
		$top_parent_name = get_cat_name( $top_parent );
		$top_parent_children = wp_list_categories( array(
			'child_of' => $top_parent,
			'title_li' => '',
			'echo' => 0
		) );
		if ( $top_parent_children != '<li>No categories</li>' ) {
?>
<nav class="widget widget-subnav">
	<h1 class="widget-title nav-title"><?php echo $top_parent_name; ?></h1>
	<div class="widget-content">
		<ul class="menu menu-secondary">
			<?php echo $top_parent_children; ?>
		</ul>
	</div><!-- /.widget-content -->
</nav><!-- /.widget.widget-subnav -->
<?php
		}
	}
}

/**
 * Subnav of current post or taxonomy's topmost parent's children, outputted as widget
 * todo - make it an actual widget that allows you to select the taxonomy
 */
function nest_taxonomy_subnav( $tax = '', $title = '' ) {
	global $post;
	if ( is_tax( $tax ) || is_single() ) {
		$terms = get_the_terms( $post->ID, $tax );
		$term = array_pop( $terms );
		$top_parent_term = ( $term->parent ? $term->parent : $term->term_id );
		$top_parent_term_name = $top_parent_term->name;
		$top_parent_children = wp_list_categories( array(
			'child_of' => $top_parent_term,
			'title_li' => '',
			'echo' => 0,
			'taxonomy' => $tax
		) );
		if ( $top_parent_children && ( $top_parent_children != '<li>No categories</li>' ) ) {
?>
<nav class="widget widget-subnav">
	<h1 class="widget-title nav-title"><?php
		if ( $title )
			echo $title;
		else
			echo $top_parent_term_name;
		?></h1>
	<div class="widget-content">
		<ul class="menu menu-secondary">
			<?php echo $top_parent_children; ?>
		</ul>
	</div><!-- .widget-content -->
</nav><!-- .widget.widget-subnav.widget-subnav-taxonomies -->
<?php
		}
	}
}

/**
 * Latest posts
 * Requires term ID. Defaults to 3 posts ordered by date
 */
function nest_latest_posts( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'orderby' => 'date',
		'post_type' => 'post',
		'content_part' => '',
		'widget_title' => 'Latest Posts',
		'exclude' => ''
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	$query_args = array(
		'post_type' => $post_type,
		'posts_per_page' => $posts_per_page,
		'orderby' => $orderby,
		'no_found_rows' => true
	);
	$latest = new WP_Query( $query_args );
	if ( $latest->have_posts() ) {
?>
<aside class="widget widget-latest">
	<?php if( $widget_title ) {
		echo '<h1 class="widget-title">'. $widget_title .'</h1>';
	} ?>
	<div class="widget-content">
		<?php
  		while ( $latest->have_posts() ) {
  		  $latest->the_post();
  			get_template_part( 'content', $content_part );
  		} // endwhile
  		wp_reset_postdata();
		?>
	</div><!-- /.widget-content -->
</aside><!-- /.widget.widget-latest -->
<?php
	} // endif
}

/**
 * Latest posts in specific taxonomy id
 * Requires term ID. Defaults to 3 posts and category as taxonomy
 */
function nest_latest_taxonomy_posts( $args ) {
	$defaults = array(
		'term_id' => '',
		'taxonomy' => '',
		'posts_per_page' => 3,
		'orderby' => 'date',
		'post_type' => 'post',
		'content_part' => '',
		'widget_title' => 'Latest Posts in ' . $term_name,
		'exclude' => ''
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	$term = get_term_by( 'id', $term_id, $taxonomy );
	$term_name = $term->name;
	$term_slug = $term->slug;
	$query_args = array(
		'post_type' => $post_type,
		'tax_query' => array(
			array(
				'taxonomy' => $taxonomy,
				'field' => 'ID',
				'terms' => $term_id
			)
		),
		'posts_per_page' => $posts_per_page,
		'orderby' => $orderby,
		'no_found_rows' => true
	);
	$latest = new WP_Query( $query_args );
	if ( $latest->have_posts() ) {
?>
<aside class="widget widget-latest-<?php echo $term_slug; ?>">
  <?php if ( $widget_title ) {
    echo '<h1 class="widget-title">' . $widget_title . '</h1>';
  } ?>
	<div class="widget-content">
		<?php
  		while ( $latest->have_posts() ) {
    		  $latest->the_post();
    			get_template_part( 'content', $content_part );
  		} // endwhile
  		wp_reset_postdata();
		?>
	</div><!-- /.widget-content -->
</aside><!-- /.widget.widget-latest -->
<?php
	} //endif
}

/**
 * Scriptless social sharing links
 * Turn the defaults for various profiles on or off as needed using booleans
 * If 'new window' is set to true, link targets will be set to "_blank"
 * If you set the twitter handle to your twitter username, it will append the twitter share link with a via tag
 */
function nest_scriptless_social_share( $args = array() ) {

	$defaults = array(
		'delicious' => 0,
		'digg' => 0,
		'facebook' => 1,
		'twitter' => 1,
		'google_plus' => 1,
		'instapaper' => 0,
		'myspace' => 0,
		'pinterest' => 0,
		'linked_in' => 0,
		'reddit' => 0,
		'stumbleupon' => 0,
		'tumblr' => 0,
		'twitter_handle' => '',
		'email' => 1,

		'new_window' => true,
		'share_title' => __( 'Share: ', 'nest' ),
		'item_sep' => '<span class="sep"> | </span>'
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	if ( $new_window ) {
		$target = ' target="_blank"';
	} else {
		$target = '';
	}

	$post_url = get_permalink();

	$post_title = get_the_title();

	$share_array = array();

	if ( $delicious ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--delicious" href="' . esc_url( 'http://delicious.com/save?url=' . $post_url . '&title=' . $post_title ) . '" title="Delicious"' . $target . '>Delicious</a></span> ';
	}

	if ( $digg ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--digg" href="' . esc_url( 'http://digg.com/submit?url=' . $post_url . '&title=' . $post_title ) . '" title="Digg"' . $target . '>Digg</a></span> ';
	}

	if ( $facebook ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--facebook" href="' . esc_url( 'http://www.facebook.com/share.php?u=' . $post_url . '&t=' . $post_title ) . '" title="Facebook"' . $target . '>Facebook</a></span> ';
	}

	if ( $google_plus ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--google-plus" href="' . esc_url( 'https://plus.google.com/share?url=' . $post_url ) . '" title="Google+"' . $target . '>Google+</a></span> ';
	}

	if ( $instapaper ) {
		 $share_array[] = '<span class="share__item"><a class="share__link share__link--instapaper" href="' . esc_url( 'http://www.instapaper.com/hello2?url=' . $post_url . '&title=' . $post_title ) . '" title="Instapaper"' . $target . '>Instapaper</a></span> ';
	}

	if ( $linked_in ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--linked-in" href="' . esc_url( 'https://www.linkedin.com/cws/share?url=' . $post_url ) . '" title="LinkedIn"' . $target . '>LinkedIn</a></span> ';
	}

	if ( $myspace ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--myspace" href="' . esc_url( 'http://www.myspace.com/index.cfm?fuseaction=postto&u=' . $post_url . '&t=' . $post_title . '&c=' . $post_title ) . '" title="Myspace"' . $target . '>Myspace</a></span> ';
	}

	if ( $pinterest ) {

		if ( has_post_thumbnail() ) {
			$featured_image_id = get_post_thumbnail_id();
			$featured_image = wp_get_attachment_image_src( $featured_image_id, 'large' );
			$image_path = $featured_image[0];
		} else {
			$image_path = nest_get_first_image_url( $size = 'large' );
		}

		$share_array[] = '<span class="share__item"><a class="share__link share__link--pinterest" href="' . esc_url( 'http://pinterest.com/pin/create/button/?url=' . $post_url . '&media=' . $image_path . '&description='. $post_title ) . '" title="Pinterest"' . $target . '>Pinterest</a></span> ';
	}

	if ( $reddit ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--reddit" href="' . esc_url( 'http://www.reddit.com/submit?url=' . $post_url . '&title=' . $post_title ) . '" title="Reddit"' . $target . '>Reddit</a></span> ';
	}

	if ( $stumbleupon ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--stumbleupon" href="' . esc_url( 'http://www.stumbleupon.com/submit?url=' . $post_url ) . '" title="Stumbleupon"' . $target . '>Stumbleupon</a></span> ';
	}

	if ( $tumblr ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--tumblr" href="' . esc_url( 'http://www.tumblr.com/share/link?url=' . $post_url . '&name=' . $post_title ) . '" title="Share on Tumblr" title="Tumblr"' . $target . '>Tumblr</a></span> ';
	}

	if ( $twitter ) {

	  $twitter_via = '';
	  if ( $twitter_handle ) {
		  $twitter_via = '&via=' . $twitter_handle;
	  }
		$share_array[] = '<span class="share__item"><a class="share__link share__link--twitter" href="' . esc_url( 'http://twitter.com/share?url=' . $post_url . '&text=' . $post_title . $twitter_via ) . '" title="Tweet"' . $target . '>Twitter</a></span> ';
	}

	if ( $email ) {
		$share_array[] = '<span class="share__item"><a class="share__link share__link--email" href="' . esc_url( 'mailto:?subject=' . $post_title . '&body=' . $post_url ) . '" title="Email"' . $target . '>Email</a></span> ';
	}

	if ( ! empty( $share_array ) ) {
		echo '<div class="meta meta--share"><span class="meta__title">' . $share_title . '</span>' . implode( $item_sep, array_filter( $share_array ) ) . '</div>' . "\n";
  } // if !empty $share_links
}

/**
 * Follow navigation widget
 */
function nest_follow_links( $args = array() ) {
	$defaults = array(
		'facebook_url' => '',
		'facebook_message' => __( 'On Facebook', 'nest' ),

		'flickr_url' => '',
		'flickr_message' => __( 'On Flickr', 'nest' ),

		'googleplus_url' => '',
		'googleplus_message' => __( 'On Google+', 'nest' ),

		'instagram_url' => '',
		'instagram_message' => __( 'On Instagram', 'nest' ),

		'linkedin_url' => '',
		'linkedin_message' => __( 'On LinkedIn', 'nest' ),

		'myspace_url' => '',
		'myspace_message' => __( 'On MySpace', 'nest' ),

		'pinterest_url' => '',
		'pinterest_message' => __( 'On Pinterest', 'nest' ),

		'soundcloud_url' => '',
		'soundcloud_message' => __( 'On Soundcloud', 'nest' ),

		'tumblr_url' => '',
		'tumblr_message' => __( 'On Tumblr', 'nest' ),

		'twitter_url' => '',
		'twitter_message' => __( 'On Twitter', 'nest' ),

		'vimeo_url' => '',
		'vimeo_message' => __( 'On Vimeo', 'nest' ),

		'youtube_url' => '',
		'youutube_message' => __( 'On YouTube', 'nest' ),

		'mailing_list_url' => '',
		'mailing_list_message' => __( 'Join Our Mailing List', 'nest' ),

		'rss_url' => get_bloginfo( 'rss2_url' ),
		'rss_message' => __( 'Subscribe via RSS', 'nest' ),

		'follow_text' => 'Follow '. get_bloginfo( 'name' ),
		'new_window' => true
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	if ( $new_window ) {
		$target = ' target="_blank"';
	} else {
		$target = '';
	}
?>
<aside class="widget widget--follow">
	<h1 class="widget__title"><?php echo $follow_text; ?></h1>
	<div class="widget__content">
		<ul class="follow">
			<?php
			if ( $facebook_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $facebook_url ) .'" class="follow__link follow__link--facebook"'. $target .'>' . $facebook_message . '</a></li>';
			}

			if ( $flickr_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $flickr_url ) .'" class="follow__link follow__link--flickr"'. $target .'>' . $flickr_message . '</a></li>';
			}

			if ( $googleplus_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $googleplus_url ) .'" class="follow__link follow__link--googleplus"'. $target .'>' . $googleplus_message . '</a></li>';
			}

			if ( $instagram_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $instagram_url ) .'" class="follow__link follow__link--instagram"'. $target .'>' . $instagram_message . '</a></li>';
			}

			if ( $linkedin_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $linkedin_url ) .'" class="follow__link follow__link--linkedin"'. $target .'>' . $linkedin_message . '</a></li>';
			}

			if ( $myspace_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $myspace_url ) .'" class="follow__link follow__link--myspace"'. $target .'>' . $myspace_message . '</a></li>';
			}

			if ( $pinterest_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $pinterest_url ) .'" class="follow__link follow__link--pinterest"'. $target .'>' . $pinterest_message . '</a></li>';
			}

			if ( $soundcloud_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $soundcloud_url ) .'" class="follow__link follow__link--soundcloud"'. $target .'>' . $soundcloud_message . '</a></li>';
			}

			if ( $tumblr_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $tumblr_url ) .'" class="follow__link follow__link--tumblr"'. $target .'>' . $tumblr_message . '</a></li>';
			}

			if ( $twitter_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $twitter_url ) .'" class="follow__link follow__link--twitter"'. $target .'>' . $twitter_message . '</a></li>';
			}

			if ( $vimeo_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $vimeo_url ) .'" class="follow__link follow__link--vimeo"'. $target .'>' . $vimeo_message . '</a></li>';
			}

			if ( $youtube_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $youtube_url ) .'" class="follow__link follow__link--youtube"'. $target .'>' . $youtube_message . '</a></li>';
			}

      if ( $mailing_list_url ) {
        echo '<li class="follow__item"><a href="'. esc_url( $mailing_list_url ) .'" class="follow__link follow__link--mailing-list"'. $target .'>' . $mailing_list_message . '</a></li>';
      }

			if ( $rss_url ) {
				echo '<li class="follow__item"><a href="'. esc_url( $rss_url ) .'" class="follow__link follow__link--rss"'. $target .'>' . $rss_message . '</a></li>';
			}
			?>
		</ul>
	</div><?php // /.widget__content ?>
</aside>
<?php
}

/**
 * All taxonomies terms links, by taxonomy term, outputted as meta data
 */
function nest_taxonomy_terms_links( $term_sep = ', ' ) {
	global $post;
	// get post by post id
	$post = get_post( $post->ID );

	// get post type by post
	$post_type = $post->post_type;

	// get post type taxonomies
	$taxonomies = get_object_taxonomies( $post_type, 'objects' );

	$out = array();
	$sep = ', ';

	foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

		// get the terms related to post
		$terms = get_the_terms( $post->ID, $taxonomy_slug );

		if ( !empty( $terms ) ) {
			$term_links_array = array();
			foreach ( $terms as $term ) {
				$term_links_array[] = '<a href="'. get_term_link( $term->slug, $taxonomy_slug ) .'">'. $term->name .'</a>';
			}
			$term_links = join( $term_sep, $term_links_array );
?>
<div class="meta meta-taxonomies"><span class="meta-title"><?php echo $taxonomy->label; ?></span>: <?php echo $term_links; ?></div>
<?php
		} // endif

	} // endforeach
}

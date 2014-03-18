<?php

/**
 * Pagination for archives
 */
function bfn_archive_pager() {
	global $wp_query, $post;
	if ( $wp_query->max_num_pages > 1 ) {
?>
	<ul class="pager-nav">
		<li class="nav-next"><?php next_posts_link( __( '&larr; Older', 'bfn' ) ); ?></li>
		<li class="nav-prev"><?php previous_posts_link( __( 'Newer &rarr;', 'bfn' ) ); ?></li>
	</ul>
<?php
	} // endif
}

/**
 * Pagination for single posts
 */
function bfn_single_pager() {
	global $wp_query, $post;
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( $next || $previous ) {
?>
	<ul class="pager-nav">
		<li class="nav-next"><?php next_post_link( '&larr; %link' ); ?></li>
		<li class="nav-prev"><?php previous_post_link( '%link &rarr;' ); ?></li>
	</ul>
<?php
	}
}

/**
 * Comment listing
 */
function bfn_comment( $comment, $args, $depth, $meta_sep = ' | ' ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) {
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'bfn' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'bfn' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

<?php
	} else { // else if not pingback or trackback
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<span class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s', 'bfn' ), sprintf( '<cite class="fn meta meta-author">%s</cite>', get_comment_author_link() ) ); ?>
				</span><!-- /.comment-author -->

				<?php echo $meta_sep; ?><a class="meta meta-comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<time datetime="<?php comment_time( 'c' ); ?>">
						 <?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ago'; ?>
					</time>
				</a>
				<?php edit_comment_link( __( 'Edit', 'bfn' ), $meta_sep . '<span class="meta meta-edit">', '</span>' ); ?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<div class="comment-awaiting-moderation"><?php echo $meta_sep; ?><?php _e( 'Your comment is awaiting moderation.', 'bfn' ); ?></div>
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
} // bfn_comment


/**
 * Get the first image from a post
 * Must be used within the loop
 * Use bfn_get_first_image( $atts ) in template, much like get_the_post_thumbnail()
 * Atts defaults:
 * 'size' => 'thumbnail'
 * 'output' => 'img' // can be either 'img' or 'url'
 * 'link' => false // if true, will link to full version of itself
 */
function bfn_get_first_image( $size = 'thumbnail', $atts = array() ) {

	$defaults = array(
		'output' => 'img', // accepts either 'img' or 'url'
		'link' => false // ignored if output is set to url
	);

	$atts = wp_parse_args( $atts, $defaults );
	extract( $atts, EXTR_SKIP );

	$query_args = array(
		'post_parent' => get_the_ID(),
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

			} elseif ( $output == 'url' ) {
					return $img_url;
			} // endif $output - 'img'

		} // endforeach
	} // endif ( $images )
}

/**
 * Echoes the first image from a post using arguments from bfn_get_first_image() function
 * Much like the_post_thumbnail
 */
function bfn_first_image( $size = 'thumbnail', $atts ) {
	echo bfn_get_first_image( $size, $atts );
}

/**
 * Echoes the first image from a post using arguments from bfn_get_first_image() function
 * Much like the_post_thumbnail
 */
function bfn_get_first_image_url( $size = 'thumbnail' ) {
	return bfn_get_first_image( $size, $atts = array( 'output' => 'url' ) );
}

/**
 * Featured or first image
 * must be used within the loop
 */
function bfn_featured_or_first_image( $size = 'thumbnail' ) {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $size );

	} else {
		bfn_first_image( $size );

	}
}

/**
 * Email encode shortcode - use on pages and posts as follows [email]you@you.com[/email]
 * via http://bavotasan.com/2012/shortcode-to-encode-email-in-wordpress-posts/
 */
function bfn_mailto_encode( $atts, $content ) {
	return '<a href="'. antispambot( 'mailto:'. $content ) .'">'. antispambot( $content ) .'</a>';
}
add_shortcode( 'email', 'bfn_mailto_encode' );

/**
 * Returns only encoded mailto address, for use with links having custom text (not the email address) as the linked text
 */
function bfn_email_address_encode( $atts, $content ) {
	return antispambot( 'mailto:'. $content );
}
add_shortcode( 'mailto', 'bfn_email_address_encode' );

/**
 * Post is in descendant category
 * See http://codex.wordpress.org/Function_Reference/in_category
 */
function bfn_post_is_in_descendant_category( $cats, $_post = null ) {
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
function bfn_inherit_category_template() {
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
// add_action( 'template_redirect', 'bfn_inherit_category_template' );


/**
 * Get top parent page id - used in page subnav function
 */
function bfn_get_top_parent_page_id() {
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
function bfn_is_descendant_page( $page_id ) {
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
function bfn_page_subnav( $title = '' ) {
	global $post;
	if ( is_page() ) {
		$top_parent = bfn_get_top_parent_page_id( $post->ID );
		$parent = $post->post_parent;
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
		if ( $title )
			echo $title;
		else
			echo $top_parent_name;
		?></h1>
	<div class="widget-content">
		<ul class="menu menu-secondary">
			<?php echo $children; ?>
		</ul>
	</div><!-- .widget-content -->
</nav><!-- .widget.widget-subnav -->
<?php
		} // endif
	} // endif
}

/**
 * Subnav of current category's topmost parent's children, outputted as widget
 * todo - make it an actual widget
 */
function bfn_category_subnav() {
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
function bfn_taxonomy_subnav( $tax = '', $title = '' ) {
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
		if ( $top_parent_children != '<li>No categories</li>' ) {
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
 * Scriptless social sharing links
 * Turn the defaults for various profiles on or off as needed using booleans
 * If 'new window' is set to true, link targets will be set to "_blank"
 * If you set the twitter handle to your twitter username, it will append the twitter share link with a via tag
 */
function bfn_scriptless_social_share( $args = array() ) {

	$defaults = array(
		'twitter' => 1,
		'twitter_handle' => '',
		'facebook' => 1,
		'google_plus' => 1,
		'pinterest' => 0,
		'instapaper' => 0,
		'linked_in' => 0,
		'tumblr' =>0,
		'myspace' => 0,
		'reddit' => 0,
		'digg' => 0,
		'delicious' => 0,
		'stumbleupon' => 0,
		'email' => 1,
		'new_window' => true,
		'share_title' => __( 'Share', 'bfn' )
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	if ( $new_window ) {
		$target = ' target="_blank"';
	} else {
		$target = '';
	}

	$post_url = get_permalink();

	$post_title = the_title_attribute( 'echo=0' );

	$encoded_title = rawurlencode( $post_title );

	if ( $twitter || $facebook || $google_plus || $pinterest || $instapaper || $linked_in || $tumblr ) {

		echo '<div class="entry-meta entry-meta-share">' . "\n";

		if ( $share_title ) {
			echo '<span class="meta-title">' . $share_title . '</span>: ';
		}

		if ( $twitter ) {
			$twitter_share = 'http://twitter.com/share?url=' . $post_url . '&text=' . $encoded_title;

			if ( $twitter_handle ) {
				$twitter_share .= '&via=' . $twitter_handle;
			}

			echo '<span class="meta meta-share"><a class="share-link share-link-twitter" href="' . esc_url( $twitter_share ) . '" title="Tweet"' . $target . '>Twitter</a></span> ';
		}

		if ( $facebook ) {
			$facebook_share = 'http://www.facebook.com/share.php?u=' . $post_url . '&t=' . $encoded_title;

			echo '<span class="meta meta-share"><a class="share-link share-link-facebook" href="' . esc_url( $facebook_share ) . '" title="Facebook"' . $target . '>Facebook</a></span> ';
		}

		if ( $google_plus ) {
			$google_plus_share = 'https://plus.google.com/share?url=' . $post_url;

			echo '<span class="meta meta-share"><a class="share-link share-link-google-plus" href="' . esc_url( $google_plus_share ) . '" title="Google+"' . $target . '>Google+</a></span> ';

		}

		if ( $pinterest ) {

			if ( has_post_thumbnail() ) {
				$featured_image_id = get_post_thumbnail_id();
				$featured_image = wp_get_attachment_image_src( $featured_image_id, 'large' );
				$image_path = $featured_image[0];

			} else {
				$image_path = bfn_get_first_image_url( $size = 'large' );
			}

			$pinterest_share = 'http://pinterest.com/pin/create/button/?url=' . $post_url . '&media=' . $image_path . '&description='. $encoded_title;

			echo '<span class="meta meta-share"><a class="share-link share-link-pinterest" href="' . esc_url( $pinterest_share ) . '" title="Pinterest"' . $target . '>Pinterest</a></span> ';
		}

		if ( $instapaper ) {
			 $instapaper_share = 'http://www.instapaper.com/hello2?url=' . $post_url . '&title=' . $encoded_title;

			 echo '<span class="meta meta-share"><a class="share-link share-link share-link-instapaper" href="' . esc_url( $instapaper_share ) . '" title="Instapaper"' . $target . '>Instapaper</a></span> ';
		}

		if ( $linked_in ) {
			$linked_in_share = 'https://www.linkedin.com/cws/share?url=' . $post_url;

			echo '<span class="meta meta-share"><a class="share-link share-link-linked-in" href="' . esc_url( $linked_in_share ) . '" title="LinkedIn"' . $target . '>LinkedIn</a></span> ';
		}

		if ( $tumblr ) {
			$tumblr_share = 'http://www.tumblr.com/share/link?url=' . $post_url . '&name=' . $encoded_title;

			echo '<span class="meta meta-share"><a class="share-link share-link share-link-tumblr" href="' . esc_url( $tumblr_share ) . '" title="Share on Tumblr" title="Tumblr"' . $target . '>Tumblr</a></span> ';
		}

		if ( $myspace ) {
			$myspace_share = 'http://www.myspace.com/index.cfm?fuseaction=postto&u=' . $post_url . '&t=' . $encoded_title . '&c=' . $encoded_title;

			echo '<span class="meta meta-share"><a class="share-link share-link share-link-myspace" href="' . esc_url( $myspace_share ) . '" title="Myspace"' . $target . '>Myspace</a></span> ';

		}

		if ( $reddit ) {
			$reddit_share = 'http://www.reddit.com/submit?url=' . $post_url . '&title=' . $encoded_title;

			echo '<span class="meta meta-share"><a class="share-link share-link share-link-reddit" href="' . esc_url( $reddit_share ) . '" title="Reddit"' . $target . '>Reddit</a></span> ';
		}

		if ( $digg ) {
			$digg_share = 'http://digg.com/submit?url=' . $post_url . '&title=' . $encoded_title;

			echo '<span class="meta meta-share"><a class="share-link share-link share-link-digg" href="' . esc_url( $digg_share ) . '" title="Digg"' . $target . '>Digg</a></span> ';
		}

		if ( $delicious ) {
			$delicious_share = 'http://delicious.com/save?url=' . $post_url . '&title=' . $encoded_title;

			echo '<span class="meta meta-share"><a class="share-link share-link share-link-delicious" href="' . esc_url( $delicious_share ) . '" title="Delicious"' . $target . '>Delicious</a></span> ';
		}

		if ( $stumbleupon ) {
			$stumbleupon_share = 'http://www.stumbleupon.com/submit?url=' . $post_url;

			echo '<span class="meta meta-share"><a class="share-link share-link share-link-stumbleupon" href="' . esc_url( $stumbleupon_share ) . '" title="Stumbleupon"' . $target . '>Stumbleupon</a></span> ';
		}

		if ( $email ) {
			$email_share = 'mailto:?subject=' . $encoded_title . '&body=' . $post_url;

			echo '<span class="meta meta-share"><a class="share-link share-link share-link-email" href="' . esc_url( $email_share ) . '" title="Email"' . $target . '>Email</a></span> ';
		}

		echo "\n" . '</div><!-- /.share -->';

	} // endif any sharing urls aren't empty
}

/**
 * Follow navigation widget
 */
function bfn_follow_links( $args = array() ) {
	$defaults = array(
		'twitter' => '',
		'facebook' => '',
		'googleplus' => '',
		'pinterest' => '',
		'linkedin' => '',
		'tumblr' => '',
		'myspace' => '',
		'soundcloud' => '',
		'youtube' => '',
		'vimeo' => '',
		'flickr' => '',
		'rss' => get_bloginfo( 'rss2_url' ),
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
<aside class="widget widget-follow">
	<h1 class="widget-title"><?php echo $follow_text; ?></h1>
	<div class="widget-content">
		<ul class="follow">
			<?php
			if ( $facebook ) {
				echo '<li><a href="'. esc_url( $facebook ) .'" class="follow-link follow-link-facebook"'. $target .'>Facebook</a></li>';
			}

			if ( $twitter ) {
				echo '<li><a href="'. esc_url( $twitter ) .'" class="follow-link follow-link-twitter"'. $target .'>Twitter</a></li>';
			}

			if ( $googleplus ) {
				echo '<li><a href="'. esc_url( $googleplus ) .'" class="follow-link follow-link-googleplus"'. $target .'>Google+</a></li>';
			}

			if ( $pinterest ) {
				echo '<li><a href="'. esc_url( $pinterest ) .'" class="follow-link follow-link-pinterest"'. $target .'>Pinterest</a></li>';
			}

			if ( $linkedin ) {
				echo '<li><a href="'. esc_url( $linkedin ) .'" class="follow-link follow-link-linkedin"'. $target .'>LinkedIn</a></li>';
			}

			if ( $tumblr ) {
				echo '<li><a href="'. esc_url( $tumblr ) .'" class="follow-link follow-link-tumblr"'. $target .'>Tumblr</a></li>';
			}

			if ( $myspace ) {
				echo '<li><a href="'. esc_url( $myspace ) .'" class="follow-link follow-link-myspace"'. $target .'>MySpace</a></li>';
			}

			if ( $soundcloud ) {
				echo '<li><a href="'. esc_url( $soundcloud ) .'" class="follow-link follow-link-soundcloud"'. $target .'>Soundcloud</a></li>';
			}

			if ( $youtube ) {
				echo '<li><a href="'. esc_url( $youtube ) .'" class="follow-link follow-link-youtube"'. $target .'>YouTube</a></li>';
			}

			if ( $vimeo ) {
				echo '<li><a href="'. esc_url( $vimeo ) .'" class="follow-link follow-link-vimeo"'. $target .'>Vimeo</a></li>';
			}

			if ( $flickr ) {
				echo '<li><a href="'. esc_url( $flickr ) .'" class="follow-link follow-link-flickr"'. $target .'>Flickr</a></li>';
			}

			if ( $rss ) {
				echo '<li><a href="'. esc_url( $rss ) .'" class="follow-link follow-link-rss"'. $target .'>RSS</a></li>';
			}
			?>
		</ul>
	</div><!-- /.widget-content -->
</aside>
<?php
}

/**
 * All taxonomies terms links, by taxonomy term, outputted as meta data
 */
function bfn_taxonomy_terms_links( $term_sep = ', ' ) {
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
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
	</nav>
<?php
	}
}

/**
 * Posted on
 */
function bfn_posted_on( $published_before = '', $sep = ' ', $author_before = 'by ' ) {
	echo '<span class="meta meta-published">' . $published_before . '<time class="published" datetime="' . get_the_time( 'c' ) . '">' . get_the_date() . '</time></span>';

	echo $sep . '<span class="meta meta-author byline author vcard">' . $author_before . '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . get_the_author() . '</a></span>';
}

/**
 * Post meta
 */
function bfn_post_meta( $meta_sep = ' | ', $item_sep = ', ', $categories_before = 'Posted in: ', $tags_before = 'Tagged: ' ) {
	$id = get_the_id();
	echo get_the_term_list( $id, 'category', '<span class="meta meta-cats">' . $categories_before, $item_sep, '</span>' );

	echo get_the_term_list( $id, 'post_tag', $meta_sep . '<span class="meta meta-tags">' . $tags_before, $item_sep, '</span>' );

	if ( comments_open() ) {
		echo $meta_sep . '<span class="meta meta-comment-link">';
		comments_popup_link( __( 'Leave a comment', 'bfn' ), __( '1 Comment', 'bfn' ), __( '% Comments', 'bfn' ) );
		echo '</span>';
	} // endif

	edit_post_link( 'Edit', $meta_sep . '<span class="meta meta-edit-link">', '</span>' );
}

/**
 * Comment listing
 */
function bfn_comment( $comment, $args, $depth ) {
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
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'bfn' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- /.comment-author -->

				<a class="meta meta-comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'bfn' ), get_comment_date(), get_comment_time() ); ?>
					</time>
				</a>
				<?php edit_comment_link( __( 'Edit', 'bfn' ), '<span class="meta meta-edit">', '</span>' ); ?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'bfn' ); ?></p>
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
						'before'    => '<div class="reply">',
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
 * Use bfn_get_first_image( $atts ) in template, much like get_the_post_thumbnail()
 * Atts defaults:
 * 'output' => 'img', // can be either 'img' or 'url'
 * 'link' => false // if true, will link to full version of itself
 */
function bfn_get_first_image( $post_id = null, $size = 'thumbnail', $atts = array() ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$defaults = array(
		'output' => 'img', // can be either 'img' or 'url'
		'link' => false
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
function bfn_first_image( $size = 'thumbnail', $atts = '' ) {
	echo bfn_get_first_image( null, $size, $atts );
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

// scriptless social sharing links
// turn the defaults on or off as needed
function bfn_scriptless_social_share( $args = array() ) {
	$defaults = array(
		'twitter' => true,
		'twitter_handle' => 'fraenkelGallery',
		'facebook' => true,
		'google_plus' => true,
		'pinterest' => true,
		'instapaper' => false,
		'linked_in' => false,
		'tumblr' => false,
		'myspace' => false,
		'reddit' => false,
		'digg' => false,
		'delicious' => false,
		'stumbleupon' => false,
		'email' => true,
		'new_window' => true
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	if ( $new_window )
		$target = ' target="_blank"';
	else
		$target = '';

	$post_url = get_permalink();
	$encoded_post_url = esc_url( $post_url );
	$post_title = the_title_attribute( 'echo=0' );
	$encoded_title = rawurlencode( $post_title );
	if( has_post_thumbnail() ) {
		$featured_image_id = get_post_thumbnail_id();
		$featured_image = wp_get_attachment_image_src( $featured_image_id, 'large' );
		$image_path = $featured_image[0];
	} else {
		$image_path = bfn_first_image_url();
	}
	$encoded_image_path = urlencode( $image_path );
	if ( $twitter || $facebook || $google_plus || $pinterest || $instapaper || $linked_in || $tumblr ) {
		echo '<div class="entry-meta entry-meta-share"><span class="meta-title">Share</span>: ';

			if ( $twitter && $twitter_handle )
				echo '<span class="meta meta-share"><a class="share-link share-link-twitter" href="http://twitter.com/share?url='. $encoded_post_url .'&amp;text='. $encoded_title .'&amp;via='. $twitter_handle .'" title="Tweet"'. $target .'>Twitter</a></span>';
			elseif ( $twitter )
				echo '<span class="meta meta-share"><a class="share-link share-link-twitter" href="http://twitter.com/share?url='. $encoded_post_url .'&amp;text='. $encoded_title .'" title="Tweet"'. $target .'>Tweet</a><span>';

			if ( $facebook )
				echo '<span class="meta meta-share"><a  class="share-link share-link-facebook" href="http://www.facebook.com/share.php?u='. $encoded_post_url .'&amp;t='. $encoded_title .'" title="Facebook"'. $target .'>Facebook</a></span>';

			if ( $google_plus )
				echo '<span class="meta meta-share"><a class="share-link share-link-google-plus" href="https://plus.google.com/share?url='. $encoded_post_url .'" title="Google+"'. $target .'>Google+</a></span>';

			if ( $pinterest )
				echo '<span class="meta meta-share"><a class="share-link share-link-pinterest" href="//pinterest.com/pin/create/button/?url='. $encoded_post_url .'&amp;media='. $encoded_image_path .'&amp;description='. $encoded_title .'" title="Pinterest"'. $target .'>Pinterest</a></span>';

			if( $instapaper )
				echo '<span class="meta meta-share"><a class="share-link share-link share-link-instapaper" href="http://www.instapaper.com/hello2?url='. $encoded_post_url .'&amp;title='. $encoded_title .'" title="Instapaper"'. $target .'>Instapaper</a></span>';

			if ( $linked_in )
				echo '<span class="meta meta-share"><a class="share-link share-link-linked-in" href="https://www.linkedin.com/cws/share?url='. $encoded_post_url .'" title="LinkedIn"'. $target .'>LinkedIn</a></span>';

			if ( $tumblr )
				echo '<span class="meta meta-share"><a class="share-link share-link share-link-tumblr" href="http://www.tumblr.com/share/link?url='. $encoded_post_url .'&amp;name='. $encoded_title .'" title="Share on Tumblr" title="Tumblr"'. $target .'>Tumblr</a></span>';

			if ( $myspace )
				echo '<span class="meta meta-share"><a class="share-link share-link share-link-myspace" href="http://www.myspace.com/index.cfm?fuseaction=postto&amp;u='. $encoded_post_url .'&amp;t='. $encoded_title .'&amp;c='. $encoded_title .'" title="Myspace"'. $target .'>Myspace</a></span>';

			if ( $reddit )
				echo '<span class="meta meta-share"><a class="share-link share-link share-link-reddit" href="http://www.reddit.com/submit?url='. $encoded_post_url .'&amp;title='. $encoded_title .'" title="Reddit"'. $target .'>Reddit</a></span>';

			if ( $digg )
				echo '<span class="meta meta-share"><a class="share-link share-link share-link-digg" href="http://digg.com/submit?url='. $encoded_post_url .'&amp;title='. $encoded_title .'" title="Digg"'. $target .'>Digg</a></span>';

			if( $delicious )
				echo '<span class="meta meta-share"><a class="share-link share-link share-link-delicious" href="http://delicious.com/save?url='. $encoded_post_url .'&amp;title='. $encoded_title .'" title="Delicious"'. $target .'>Delicious</a></span>';

			if( $stumbleupon )
				echo '<span class="meta meta-share"><a class="share-link share-link share-link-stumbleupon" href="http://www.stumbleupon.com/submit?url=' . $encoded_post_url . '" title="Stumbleupon"'. $target .'>Stumbleupon</a></span>';

			if ( $email )
				echo '<span class="meta meta-share"><a class="share-link share-link share-link-email" href="mailto:?subject='. $encoded_title .'&amp;body='. $encoded_post_url .'" title="Email"'. $target .'>Email</a></span>';

		echo '</div><!-- /.share -->';
	}
}

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
				echo '<li><a href="'. $facebook .'" class="follow-link follow-link-facebook"'. $target .'>Facebook</a></li>';
			}
			if ( $twitter ) {
				echo '<li><a href="'. $twitter .'" class="follow-link follow-link-twitter"'. $target .'>Twitter</a></li>';
			}
			if ( $googleplus ) {
				echo '<li><a href="'. $googleplus .'" class="follow-link follow-link-googleplus"'. $target .'>Google+</a></li>';
			}
			if ( $pinterest ) {
				echo '<li><a href="'. $pinterest .'" class="follow-link follow-link-pinterest"'. $target .'>Pinterest</a></li>';
			}
			if ( $linkedin ) {
				echo '<li><a href="'. $linkedin .'" class="follow-link follow-link-linkedin"'. $target .'>LinkedIn</a></li>';
			}
			if ( $tumblr ) {
				echo '<li><a href="'. $tumblr .'" class="follow-link follow-link-tumblr"'. $target .'>Tumblr</a></li>';
			}
			if ( $myspace ) {
				echo '<li><a href="'. $myspace .'" class="follow-link follow-link-myspace"'. $target .'>MySpace</a></li>';
			}
			if ( $soundcloud ) {
				echo '<li><a href="'. $soundcloud .'" class="follow-link follow-link-soundcloud"'. $target .'>Soundcloud</a></li>';
			}
			if ( $youtube ) {
				echo '<li><a href="'. $youtube .'" class="follow-link follow-link-youtube"'. $target .'>YouTube</a></li>';
			}
			if ( $vimeo ) {
				echo '<li><a href="'. $vimeo .'" class="follow-link follow-link-vimeo"'. $target .'>Vimeo</a></li>';
			}
			if ( $flickr ) {
				echo '<li><a href="'. $flickr .'" class="follow-link follow-link-flickr"'. $target .'>Flickr</a></li>';
			}
			if ( $rss ) {
				echo '<li><a href="'. $rss .'" class="follow-link follow-link-rss"'. $target .'>RSS</a></li>';
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
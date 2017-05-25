<?php

/**
 * Postnav single
 */
function nest_postnav_single( $in_same_term = false, $excluded_terms = array(), $taxonomy = 'category', $newer_title = '&larr; %title', $older_title = '%title &rarr;' ) {
	$newer = get_next_post_link( '<div class="postnav__link postnav__link--newer">%link</div>', $newer_title, $in_same_term, $excluded_terms, $taxonomy );
	$older = get_previous_post_link( '<div class="postnav__link postnav__link--older">%link</div>', $older_title, $in_same_term, $excluded_terms, $taxonomy );
	$postnav = array();

	if ( $newer ) {
		$postnav[] = $newer;
	}

	if ( $older ) {
		$postnav[] = $older;
	}

	if ( ! empty( $postnav ) ) {
		echo '<nav class="postnav doc--single__postnav">' . "\n" . implode( '', $postnav ) . '</nav>';
	}
}

/**
 * Postnav archives
 */
function nest_postnav_archive( $newer_title = null, $older_title = null ) {
	if ( null === $newer_title ) {
		$newer_title = __( '&larr; Newer Entries', 'nest' );
	}

	if ( null === $older_title ) {
		$older_title =	__( 'Older Entries &rarr;', 'nest' );
	}

	$newer = get_previous_posts_link( $newer_title );
	$older = get_next_posts_link( $older_title );
	$postnav = array();

	if ( $newer ) {
		$postnav[] = '<div class="postnav__link postnav__link--newer">' . $newer . '</div>' . "\n";
	}

	if ( $older ) {
		$postnav[] = '<div class="postnav__link postnav__link--older">' . $older . '</div>' . "\n";
	}

	if ( ! empty( $postnav ) ) {
		echo '<nav class="postnav doc--archive__postnav">' . "\n" . implode( '', $postnav ) . '</nav>';
	}
}

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
			<header class="comment__meta comment__header">
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
			</header><?php // / /.comment__meta.comment__header ?>

			<div class="comment__main">
				<div class="comment-content">
					<?php comment_text(); ?>
				</div><?php // / /.comment-content ?>
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'			=> $depth,
						'max_depth' => $args['max_depth'],
						'before'		=> '<div class="comment__meta comment__meta--reply"><span class="meta meta--reply">',
						'after'			=> '</div></div>',
					) ) );
				?>
			</div><?php // / /.comment__main ?>
		</article><?php // / /.comment__body ?>
<?php
	} // endif
} // nest_comment

/**
 * Return SVG markup.
 *
 * @param  array  $args {
 *     Parameters needed to display an SVG.
 *
 *     @param string $icon Required. Use the icon filename, e.g. "facebook-square".
 *     @param string $title Optional. SVG title, e.g. "Facebook".
 *     @param string $desc Optional. SVG description, e.g. "Share this post on Facebook".
 * }
 * @return string SVG markup.
 */
function nest_get_svg( $args = array() ) {

	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', '_s' );
	}

	// YUNO define an icon?
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', '_s' );
	}

	// Set defaults.
	$defaults = array(
		'icon'  => '',
		'title' => '',
		'desc'  => ''
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Begin SVG markup
	$svg = '<svg class="icon icon-' . esc_html( $args['icon'] ) . '" aria-hidden="true">';

		// If there is a title, display it.
		if ( $args['title'] ) {
			$svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
		}

		// If there is a description, display it.
		if ( $args['desc'] ) {
			$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
		}

	$svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
	$svg .= '</svg>';

	return $svg;
}

/**
 * Display an SVG.
 *
 * @param  array  $args  Parameters needed to display an SVG.
 */
function nest_do_svg( $args = array() ) {
	echo nest_get_svg( $args );
}

/**
 * Get the first image from a post
 * Must be used within the loop
 * Use nest_get_first_image( $atts ) in template, much like get_the_post_thumbnail()
 * Atts defaults:
 * 'size' => 'thumbnail'
 * 'output' => 'img' // can be either 'img' or 'url'
 * 'link' => false // if true, will link to full version of itself
 */
function nest_get_first_image( $size = 'thumbnail', $post_id = null, $atts = array() ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$defaults = array(
		'output' => 'img', // accepts either 'img' or 'url'
		'link' => false // ignored if output is set to url
	);

	$atts = wp_parse_args( $atts, $defaults );
	extract( $atts, EXTR_SKIP );

	$images = get_attached_media( 'image' );

	if ( count( $images ) > 0 ) {
		$image = array_shift( $images );
		$image_id = $image->ID;
		$img = wp_get_attachment_image( $image_id, $size );
		$img_src = wp_get_attachment_image_src( $image_id, $size );
		$img_url = $img_src[0];
		$img_full_url = wp_get_attachment_url( $image_id );
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

	}

}

/**
 * Echoes the first image from a post using arguments from nest_get_first_image() function
 * Much like the_post_thumbnail
 */
function nest_first_image( $size = 'thumbnail', $post_id = null, $atts = array() ) {
	echo nest_get_first_image( $size, $post_id, $atts );
}

/**
 * Echoes the first image from a post using arguments from nest_get_first_image() function
 * Much like the_post_thumbnail
 */
function nest_get_first_image_url( $size = 'thumbnail', $post_id = null ) {
	return nest_get_first_image( $size, $post_id, $atts = array( 'output' => 'url' ) );
}

/**
 * Get featured or first image
 * must be used within the loop
 */
function nest_get_featured_or_first_image( $size = 'thumbnail', $post_id = null ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail( $post_id, $size );

	} else {
		return nest_get_first_image( $size, $post_id, $atts = array( 'output' => 'img' ) );
	}
}

/**
 * Featured or first image
 * must be used within the loop
 */
function nest_featured_or_first_image( $size = 'thumbnail',	 $post_id = null ) {
	echo nest_get_featured_or_first_image( $size, $post_id );
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
		if ( $descendants && in_category( $descendants, $_post ) ) {
			return true;
		}
	}
	return false;
}

function nest_post_is_in_cat_or_descendant( $cat_id ) {
	if ( in_category( $cat_id ) || nest_post_is_in_descendant_category( $cat_id ) ) {
		return true;

	} else {
		return false;
	}
}

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
		if ( is_page() && $ancestor == $pag_id ) {
			return true;
		}
	}
	if ( is_page() && is_page( $page_id ) ) {
		return true;
	}

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
	if ( ! empty( $children ) ) {
?>
<nav class="nav nav--secondary">
	<h2 class="nav__title"><?php
		if ( $title ) {
			echo $title;
		} else {
			echo $top_parent_name;
		 }
	?></h2>
	<ul class="menu menu--secondary">
		<?php echo $children; ?>
	</ul>
</nav>
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
			'echo' => 0,
			'show_option_none' => ''
		) );
		if ( ! empty( $top_parent_children ) ) {
?>
<nav class="nav nav--secondary nav--categories">
	<h2 class="nav__title"><?php echo $top_parent_name; ?></h2>
	<ul class="menu menu--secondary">
		<?php echo $top_parent_children; ?>
	</ul>
</nav>
<?php
		} // endif
	} // endif
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
			'taxonomy' => $tax,
			'show_option_none' => ''
		) );
		if ( ! empty( $top_parent_children ) ) {
?>
<nav class="nav nav--secondary nav--taxonomies">
	<h2 class="nav__title"><?php
		if ( $title ) {
			echo $title;
		} else {
			echo $top_parent_term_name;
		}
	?></h2>
	<ul class="menu menu--secondary">
		<?php echo $top_parent_children; ?>
	</ul>
</nav>
<?php
		} // endif
	} // endif
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
<aside class="widget widget--latest">
	<?php if( $widget_title ) {
		echo '<h2 class="widget__title">'. $widget_title .'</h2>';
	} ?>
	<div class="widget__content">
		<?php
			while ( $latest->have_posts() ) {
				$latest->the_post();
				get_template_part( 'content', $content_part );
			} // endwhile
			wp_reset_postdata();
		?>
	</div><?php //	 /.widget__content ?>
</aside><?php //	/.widget.widget--latest ?>
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
<aside class="widget widget--latest widget--latest--<?php echo $term_slug; ?>">
	<?php if ( $widget_title ) {
		echo '<h2 class="widget__title">' . $widget_title . '</h2>';
	} ?>
	<div class="widget__content">
		<?php
			while ( $latest->have_posts() ) {
					$latest->the_post();
					get_template_part( 'content', $content_part );
			} // endwhile
			wp_reset_postdata();
		?>
	</div><?php //	 /.widget__content ?>
</aside><?php //	/.widget.widget--latest ?>
<?php
	} //endif
}

/**
 * META Functions
 */

/**
 * Meta terms
 */
function nest_get_meta_terms( $taxonomy = 'category', $before = null, $sep = ', ', $element = 'span' ) {
	$meta_title = '';
	if ( null === $before ) {
		$meta_title = '<span class="meta__title">' . __( 'Posted in: ', 'nest' ) . '</span>';

	} elseif ( ! empty( $before ) ) {
		$meta_title = '<span class="meta__title">' . $before . '</span>';
	}

	return get_the_term_list( get_the_ID(), $taxonomy, '<' . $element . ' class="meta meta--terms">' . $meta_title, $sep, '</' . $element . '>' );
}

/**
 * Meta categories
 */
function nest_get_meta_categories( $before = null, $sep = ', ', $element = 'span' ) {
	return nest_get_meta_terms( 'category', $before, $sep, $element );
}

/**
 * Meta tags
 */
function nest_get_meta_tags( $before = null, $sep = ', ', $element = 'span' ) {
	$meta_title = '';
	if ( null === $before ) {
		$meta_title = '<span class="meta__title">' . __( 'Tagged: ', 'nest' ) . '</span>';

	} elseif ( ! empty( $before ) ) {
		$meta_title = '<span class="meta__title">' . $before . '</span>';
	}

	return nest_get_meta_terms( 'post_tag', $meta_title, $sep, $element );
}

/**
 * Meta comments link
 */
function nest_get_meta_comments_link( $element = 'span' ) {
	if ( ! comments_open() ) {
		return false;
	}

	$content = '';
	$comments_count = get_comments_number();
	$comments_link = get_comments_link();

	$content .= '<'. $element . ' class="meta meta--comment"><a href="' . $comments_link . '">';

	if ( $comments_count == 0 ) {
		$content .= '<span class=meta--comment__text">' . __( 'Comment', 'nest' ) . '</span>';

	} else {

		$content .= sprintf(
			_n(
				'<span class="meta--comment__count">%d</span><span class="meta--comment__text"> comment</span>',
				'<span class="meta--comment__count">%d<span><span class="meta--comment__text"> comments</span>',
				$comments_count,
				'nest'
			),
			number_format_i18n( $comments_count )
		);
	}

	$content .= '</a></' . $element . '>';

	return $content;
}

/**
 * Meta pubdate
 */
function nest_get_meta_pubdate( $before = null, $element = 'span' ) {
	if ( 'post' == get_post_type() ) {

		$meta_title = '';
		if ( $before ) {
			$meta_title = '<span class="meta__title">' . $before . '</span>';
		}

		return '<' . $element . ' class="meta meta--published">' . $meta_title . '<time class="published" datetime = "' . get_the_time( 'c' ) . '">' . get_the_date() . '</time></' . $element . '>';
	}

	return false;
}

/**
 * Meta author
 */
function nest_get_meta_author( $before = null, $element = 'span' ) {
	if ( 'post' != get_post_type() ) {
		return false;
	}

	$meta_title = '';
	if ( $before ) {
		$meta_title = '<span class="meta__title">' . $before . '</span>';
	}

	return '<' . $element . ' class="meta meta--author">' . $meta_title . '<span class="byline author vcard"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . get_the_author() . '</a></span></' . $element . '>';
}

/**
 * Advanced custom fields meta
 * Requires Advanced Custom Fields to be active, and for the field to be a text field
 */
function nest_get_meta_field( $meta_field = '', $before = null, $element = 'span' ) {
	if ( empty( $meta_field ) ) {
		return false;
	}

	$field = get_post_meta( get_the_ID(), $meta_field, true );

	$meta_title = '';
	if ( $before ) {
		$meta_title = '<span class="meta__title">' . $before . '</span>';
	}

	return '<' . $element . ' class="meta meta--acf">' . $meta_title . $field . '</' . $element . '>';
}

/**
 * Meta edit link
 */
function nest_get_meta_edit_link( $link_text = null, $element = 'span' ) {

	$edit_post_link = get_edit_post_link();

	if ( ! $edit_post_link ) {
		return false;
	}

	if ( null === $link_text ) {
		$link_text = __( 'Edit', 'nest' );
	}

	return '<' . $element . ' class="meta meta--edit"><a href="' . $edit_post_link . '">' . $link_text . '</a></' . $element . '>';
}

/**
 * Scriptless social sharing links
 * Turn the defaults for various profiles on or off as needed using booleans
 * If 'new window' is set to true, link targets will be set to "_blank"
 * If you set the twitter handle to your twitter username, it will append the twitter share link with a via tag
 */
function nest_get_meta_share( $args = array(), $before = null, $element = 'span', $item_sep = ', ', $new_window = true ) {

	$defaults = array(
		'delicious' => 0,
		'digg' => 0,
		'facebook' => 1,
		'twitter' => 1,
		'google_plus' => 0,
		'instapaper' => 0,
		'myspace' => 0,
		'pinterest' => 1,
		'linked_in' => 0,
		'reddit' => 0,
		'stumbleupon' => 0,
		'tumblr' => 0,
		'twitter_handle' => '',
		'email' => 1,
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	$meta_title = '';
	if ( null === $before ) {
		$meta_title = '<span class="meta__title">' . __( 'Share: ', 'nest' ) . '</span>';

	} elseif ( ! empty( $before ) ) {
		$meta_title = '<span class="meta__title">' . $before . '</span>';
	}

	if ( $new_window ) {
		$target = ' target="_blank"';

	} else {
		$target = '';
	}

	$post_url = get_permalink();

	$post_title = get_the_title();
	$encoded_title = urlencode( get_the_title() );

	$share_array = array();

	if ( $delicious ) {
		$share_array[] = '<a class="share-link share-link--delicious" href="' . esc_url( 'http://delicious.com/save?url=' . $post_url . '&title=' . $encoded_title ) . '" title="Delicious"' . $target . '>Delicious</a>';
	}

	if ( $digg ) {
		$share_array[] = '<a class="share-link share-link--digg" href="' . esc_url( 'http://digg.com/submit?url=' . $post_url . '&title=' . $encoded_title ) . '" title="Digg"' . $target . '>Digg</a>';
	}

	if ( $facebook ) {
		$share_array[] = '<a class="share-link share-link--facebook" href="' . esc_url( 'http://www.facebook.com/share.php?u=' . $post_url . '&t=' . $encoded_title ) . '" title="Facebook"' . $target . '>Facebook</a>';
	}

	if ( $google_plus ) {
		$share_array[] = '<a class="share-link share-link--google-plus" href="' . esc_url( 'https://plus.google.com/share?url=' . $post_url ) . '" title="Google+"' . $target . '>Google+</a>';
	}

	if ( $instapaper ) {
		 $share_array[] = '<a class="share-link share-link--instapaper" href="' . esc_url( 'http://www.instapaper.com/hello2?url=' . $post_url . '&title=' . $encoded_title ) . '" title="Instapaper"' . $target . '>Instapaper</a>';
	}

	if ( $linked_in ) {
		$share_array[] = '<a class="share-link share-link--linked-in" href="' . esc_url( 'https://www.linkedin.com/cws/share?url=' . $post_url ) . '" title="LinkedIn"' . $target . '>LinkedIn</a>';
	}

	if ( $myspace ) {
		$share_array[] = '<a class="share-link share-link--myspace" href="' . esc_url( 'http://www.myspace.com/index.cfm?fuseaction=postto&u=' . $post_url . '&t=' . $encoded_title . '&c=' . $encoded_title ) . '" title="Myspace"' . $target . '>Myspace</a>';
	}

	if ( $pinterest ) {

		if ( has_post_thumbnail() ) {
			$featured_image_id = get_post_thumbnail_id();
			$featured_image = wp_get_attachment_image_src( $featured_image_id, 'large' );
			$image_path = $featured_image[0];
		} else {
			$image_path = nest_get_first_image_url( $size = 'large' );
		}

		$share_array[] = '<a class="share-link share-link--pinterest" href="' . esc_url( 'http://pinterest.com/pin/create/button/?url=' . $post_url . '&media=' . $image_path . '&description='. $encoded_title ) . '" title="Pinterest"' . $target . '>Pinterest</a>';
	}

	if ( $reddit ) {
		$share_array[] = '<a class="share-link share-link--reddit" href="' . esc_url( 'http://www.reddit.com/submit?url=' . $post_url . '&title=' . $encoded_title ) . '" title="Reddit"' . $target . '>Reddit</a>';
	}

	if ( $stumbleupon ) {
		$share_array[] = '<a class="share-link share-link--stumbleupon" href="' . esc_url( 'http://www.stumbleupon.com/submit?url=' . $post_url ) . '" title="Stumbleupon"' . $target . '>Stumbleupon</a>';
	}

	if ( $tumblr ) {
		$share_array[] = '<a class="share-link share-link--tumblr" href="' . esc_url( 'http://www.tumblr.com/share/link?url=' . $post_url . '&name=' . $encoded_title ) . '" title="Share on Tumblr" title="Tumblr"' . $target . '>Tumblr</a>';
	}

	if ( $twitter ) {

		$twitter_via = '';
		if ( $twitter_handle ) {
			$twitter_via = '&via=' . $twitter_handle;
		}
		$share_array[] = '<a class="share-link share-link--twitter" href="' . esc_url( 'http://twitter.com/share?url=' . $post_url . '&text=' . $encoded_title . $twitter_via ) . '" title="Tweet"' . $target . '>Twitter</a>';
	}

	if ( $email ) {
		$share_array[] = '<a class="share-link share-link--email" href="' . esc_url( 'mailto:?subject=' . $encoded_title . '&body=' . $post_url ) . '" title="Email"' . $target . '>Email</a>';
	}

	if ( ! empty( $share_array ) ) {
		return '<' . $element . ' class="meta meta--share">' . $meta_title . implode( $item_sep, array_filter( $share_array ) ) . '</' . $element . '>';
	} // if ! empty $share_links

	return false;
}

/**
 * Meta
 * $metas array takes the following functions:
 * nest_get_meta_terms() - use for custom taxonomies - use taxonomy name as argument, ie. nest_get_meta_terms( 'taxonomy_name' )
 * nest_get_meta_categories()
 * nest_get_meta_tags()
 * nest_get_meta_comments_link()
 * nest_get_meta_author()
 * nest_get_meta_pubdate()
 * nest_get_meta_edit_link()
 * nest_get_meta_share()
 */
function nest_meta( $metas = array(), $meta_sep = ' | ', $meta_class = '' ) {
	$meta_array = array();

	if ( ! empty( $metas ) ) {
		foreach ( $metas as $meta ) {
			if ( $meta ) {
				$meta_array[] = $meta;
			}
		}
	}

	if ( ! empty( $meta_array ) ) {
		echo "\t" . '<div class="entry__meta' . $meta_class . '">' . implode( $meta_sep, array_filter( $meta_array ) ) . '</div>' . "\n";
	}

	return false;
}

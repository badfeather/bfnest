<?php
/**
 * Outputs meta functions
 * @param array $metas Array of functions to return
 * @param string $meta_sep Separator
 * @param array $classes Array of classes to add
 */
// Get
function bfnest_get_meta( $metas = [], $meta_sep = ' | ', $classes = [] ) {
	if ( ! is_array( $metas ) || empty( $metas ) ) return false;
	$meta_array = [];

	foreach ( $metas as $meta ) {
		$meta_array[] = $meta;
	}
	$meta_array = array_filter( $meta_array );
	if ( empty( $meta_array ) ) return false;

	$classes = is_array( $classes ) ? $classes : [];
	if ( ! in_array( 'entry-meta', $classes ) ) $classes[] = 'entry-meta';

	return '<div class="' . esc_attr( join( ' ', $classes ) ) . '">' . join( esc_html( $meta_sep ), $meta_array ) . '</div>' ."\n";
}

// Echo
function bfnest_meta( $metas = [], $meta_sep = ' | ', $classes = [] ) {
	echo bfnest_get_meta( $metas, $meta_sep, $classes );
}

/**
 * Edit footer - used on post type views without any other meta info in the footer
 * $footer_class should either be 'doc' or 'entry'
 */
function bfnest_get_edit_footer( $classes = [] ) {
	$classes = is_array( $classes ) ? $classes : [];
	if ( ! in_array( 'entry-footer', $classes ) ) $classes[] = 'entry-footer';
	return '<footer class="' . esc_attr( join( ' ', $classes ) ) . '">' . bfnest_get_meta( [ bfnest_get_meta_edit_link() ] ) . '</footer>' . "\n";
}

function bfnest_edit_footer( $classes = [] ) {
	echo bfnest_get_edit_footer( $classes );
}

/**
 * Meta taxonomy terms
 * @param string $taxonomy Taxonomy key
 * @param string $before Text to display before terms
 * @param string $sep Term separator
 * @param boolean $inline Whether to display meta block inline ('span') or block ('div')
 */
function bfnest_get_meta_terms( $taxonomy = 'category', $before = null, $sep = ', ', $inline = 1, $link = true ) {
	$title = '';

	if ( null === $before ) {
		$title = '<span class="meta-title">' . __( 'Posted in: ', 'bfnest' ) . '</span>';

	} elseif ( ! empty( $before ) ) {
		$title = '<span class="meta-title">' . sprintf( __( '%1$s', 'bfnest' ), $before ) . '</span>';
	}

	$terms = get_the_terms( get_the_ID(), $taxonomy );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return false;
	}

	$terms_array = [];

	foreach ( $terms as $term ) {
		$term_before = $term_after = '';
		if ( $link ) {
			$url = get_term_link( $term, $taxonomy );
			$term_before = '<a href="' . esc_url( $url ) . '" rel="tag">';
			$term_after = '</a>';
		}
		$terms_array[] = $term_before . $term->name . $term_after;
	}
	$element = $inline ? 'span' : 'div';
	return '<' . $element . ' class="meta meta--terms meta--' . esc_attr( $taxonomy ) . '-terms">' . $title . join( esc_html( $sep ), $terms_array ) . '</' . $element . '>' . "\n";
}

/**
 * Meta categories
 * $before can be null, which will default to 'Posted in: ', '', which will omit the title, or any custom text
 * $element expects 'span' or 'div'
 */
function bfnest_get_meta_categories( $before = null, $sep = ', ', $inline = 1, $link = true ) {
	return bfnest_get_meta_terms( 'category', $before, $sep, $inline, $link );
}

/**
 * Meta tags
 * $before can be null, which will default to 'Tagged: ', '', which will omit the title, or any custom text
 * $element expects 'span' or 'div'
 */
function bfnest_get_meta_tags( $before = null, $sep = ', ', $inline = 1, $link = true ) {
	if ( null === $before ) {
		$before = __( 'Tagged: ', 'bfnest' );
	}

	return bfnest_get_meta_terms( 'post_tag', $before, $sep, $inline, $link );
}

/**
 * Meta comments link
 */
function bfnest_get_meta_comments_link( $inline = 1 ) {
	if ( ! comments_open() ) {
		return false;
	}

	$comments_count = get_comments_number();
	$comments_link = get_comments_link();

	$label = '';

	if ( $comments_count == 0 ) {
		$label = __( 'Leave a comment', 'bfnest' );

	} else {

		$label =  sprintf(
			_n(
				__( '%d comment', 'bfnest' ),
				__( '%d comments', 'bfnest' ),
				$comments_count
			),
			number_format_i18n( $comments_count )
		);
	}

	$label = apply_filters( 'bfnest_meta_comments_link_label', $label );
	$element = $inline ? 'span' : 'div';

	return '<'. $element . ' class="meta meta--comment"><a href="' . $comments_link . '">' . $label . '</a></' . $element . '>';

}

/**
 * Meta pubdate
 * $before can be custom text, or will be otherwise omitted
 * $element expects 'span' or 'div'
 */
function bfnest_get_meta_pubdate( $before = null, $inline = 1 ) {
	$date = get_the_date();

	if ( ! $date ) {
		return false;
	}

	$title = $before ? '<span class="meta-title">' . $before . '</span>' : '';
	$element = $inline ? 'span' : 'div';
	return '<' . $element . ' class="meta meta--published">' . $title . '<time class="published" datetime = "' . get_the_time( 'c' ) . '">' . $date . '</time></' . $element . '>';
}

/**
 * Meta author
 */
function bfnest_get_meta_author( $before = null, $inline = 1 ) {
	$author = get_the_author();

	if ( empty( $author ) || is_wp_error( $author ) ) {
		return false;
	}

	$title = $before ? '<span class="meta-title">' . $before . '</span>' : '';
	$element = $inline ? 'span' : 'div';
	return '<' . $element . ' class="meta meta--author">' . $title . '<span class="byline author vcard"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . $author . '</a></span></' . $element . '>';
}

/**
 * Custom field meta
 * Expects string custom field value
 */
function bfnest_get_meta_field( $meta_field = '', $before = null, $inline = 1, $class = '' ) {
	if ( empty( $meta_field ) ) {
		return false;
	}

	$field = get_post_meta( get_the_ID(), $meta_field, true );
	if ( ! $field ) {
		return false;
	}

	$title = $before ? '<span class="meta-title">' . $before . '</span>' : '';
	$add_class = $class ? ' ' . $class : '';
	$element = $inline ? 'span' : 'div';
	return '<' . $element . ' class="meta meta--cf' . esc_attr( $add_class ) . '">' . $title . $field . '</' . $element . '>';
}

/**
 * Custom field link meta
 * Expects url custom field value
 * $linked_text defaults to 'Download'
 */
function bfnest_get_meta_field_link( $meta_field = '', $before = null, $linked_text = 'Download', $inline = 1, $class = '', $new_window = false ) {
	if ( empty( $meta_field ) ) {
		return false;
	}

	$field = get_post_meta( get_the_ID(), $meta_field, true );
	if ( ! $field ) {
		return false;
	}

	$title = $before ? '<span class="meta-title">' . $before . '</span>' : '';
	$target = $new_window ? ' target="_blank"' : '';
	$add_class = $class ? ' ' . $class : '';
	$element = $inline ? 'span' : 'div';
	return '<' . $element . ' class="meta meta--cf-link' . esc_attr( $add_class ) . '">' . $title . '<a href="' . esc_url( $field ) . '"' . $target . '>' .
	esc_html( $linked_text ) .
	'</a></' . $element . '>';
}

/**
 * Meta edit link
 */
function bfnest_get_meta_edit_link( $label = null, $inline = 1 ) {
	$edit_post_link = get_edit_post_link();

	if ( ! $edit_post_link ) {
		return false;
	}

	if ( null === $label ) {
		$label = __( 'Edit', 'bfnest' );
	}
	$element = $inline ? 'span' : 'div';
	return '<' . $element . ' class="meta meta--edit"><a href="' . $edit_post_link . '">' . $label . '</a></' . $element . '>';
}

function bfnest_get_share_stubs() {
	$url = get_permalink();
	$text = rawurlencode( html_entity_decode( get_the_title() ) );
	$image = bfnest_get_featured_or_first_image_url( $size = 'large' );
	// many taken from here: https://github.com/drmonkeyninja/social-share-url/blob/master/src/data/stubs.php
	return [
		"bluesky" => ["https://bsky.app/intent/compose?text={$text}%20{$url}", "Bluesky"],
		"digg" => ["https://digg.com/submit?url={$url}&title={$text}", "Digg"],
		"email" => ["mailto:?subject={$text}&body={$url}", "Email"],
		"facebook" => ["https://www.facebook.com/sharer/sharer.php?u={$url}", "Facebook"],
		"linkedin" => ["http://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$text}", "LinkedIn"],
		"pinterest" => ["http://www.pinterest.com/pin/create/button/?url={$url}&media={$image}&description={$text}", "Pinterest"],
		"reddit" => ["http://www.reddit.com/submit?url={$url}&title={$text}", "Reddit"],
		"threads" => ["https://threads.net/intent/post?url={$url}&text={$text}", "Threads"],
		"tumblr" => ["http://www.tumblr.com/share?v=3&u={$url}&t={$text}", "Tumblr"],
		"x" => ["https://x.com/intent/tweet?text={$text}&url={$url}", "X"],
	];
}

/**
 * Scriptless social sharing links
 * Turn the defaults for various profiles on or off as needed using booleans
 * If 'new window' is set to true, link targets will be set to "_blank"
 * If you set the twitter handle to your twitter username, it will append the twitter share link with a via tag
 * Uses bfnest_get_share_data()
 */
function bfnest_get_meta_share(
		// comment out the ones you don't want
		$networks = [
			'bluesky',
			'digg',
			'email',
			'facebook',
			'linkedin',
			'pinterest',
			'reddit',
			'threads',
			'tumblr',
			'x',
		],
		$before = null,
		$inline = 1,
		$item_sep = ' ',
		$new_window = true,
		$add_icons = true,
		$text_replace = true
	) {
	$stubs = bfnest_get_share_stubs();
	$title = '';
	if ( null === $before ) {
		$title = '<span class="meta-title">' . __( 'Share: ', 'bfnest' ) . '</span>';

	} elseif ( ! empty( $before ) ) {
		$title = '<span class="meta-title">' . $before . '</span>';
	}
	$target = $new_window ? ' target="_blank" rel="noopener noreferrer"' : '';

	$share_array = [];
	foreach ( $networks as $network ) {
		$stub = $stubs[$network];
		$network_before = $network_after = '';
		$before_link = $after_link = '';
		if ( $add_icons ) {
			if ( $text_replace ) {
				$network_before .= '<span class="visually-hidden">';
				$network_after .= '</span>';
				$icon = 'email' === $network ? 'mail' : $network;
			}
			$network_after .= '<span class="icon--' . esc_attr( $icon ) . '"></span>';
		}

		$share_array[] = '<a class="share-link share-link--' . esc_attr( $network ) . '" href="' . esc_url( $stub[0] ) . '" title="Share on ' . esc_attr( $stub[1] ) . '"' . $target . '>' . $network_before . $stub[1] . $network_after . '</a>';
	}

	if ( ! empty( $share_array ) ) {
		$element = $inline ? 'span' : 'div';
		return '<' . $element . ' class="meta meta--share">' . $title . join( $item_sep, $share_array ) . '</' . $element . '>';
	}
	return false;
}


<?php

/**
 * Outputs meta functions added via first arg array
 * Use any of the the below functions or any custom functions you declare
 */
function nest_meta( $metas = array(), $meta_sep = ' | ', $meta_class = array() ) {
	$meta_array = array();

	if ( ! empty( $metas ) ) {
		foreach ( $metas as $meta ) {
			if ( $meta ) {
				$meta_array[] = $meta;
			}
		}
	}

	array_unshift( $meta_class, 'entry-meta' );

	if ( ! empty( $meta_array ) ) {
		echo '<div class="' . join( ' ', $meta_class ) . '">' . implode( $meta_sep, array_filter( $meta_array ) ) . '</div>' . "\n";
	}

	return false;
}

/**
 * Meta taxonomy terms
 * $taxonomy defaults to 'category'
 * $before can be null, which will default to 'Posted in: ', '', which will omit the title, or any custom text
 * $element expects 'span' or 'div'
 */
function nest_get_meta_terms( $taxonomy = 'category', $before = null, $sep = ', ', $element = 'span' ) {
	$meta_title = '';
	if ( null === $before ) {
		$meta_title = '<span class="meta__title">' . __( 'Posted in: ', 'nest' ) . '</span>';

	} elseif ( ! empty( $before ) ) {
		$meta_title = '<span class="meta__title">' . __( $before ) . '</span>';
	}

	return get_the_term_list( get_the_ID(), $taxonomy, '<' . $element . ' class="meta meta--terms">' . $meta_title, $sep, '</' . $element . '>' );
}

/**
 * Meta categories
 * $before can be null, which will default to 'Posted in: ', '', which will omit the title, or any custom text
 * $element expects 'span' or 'div'
 */
function nest_get_meta_categories( $before = null, $sep = ', ', $element = 'span' ) {
	return nest_get_meta_terms( 'category', $before, $sep, $element );
}

/**
 * Meta tags
 * $before can be null, which will default to 'Tagged: ', '', which will omit the title, or any custom text
 * $element expects 'span' or 'div'
 */
function nest_get_meta_tags( $before = 'Tagged: ', $sep = ', ', $element = 'span' ) {
	return nest_get_meta_terms( 'post_tag', $before, $sep, $element );
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
 * $before can be custom text, or will be otherwise omitted
 * $element expects 'span' or 'div'
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
 * Custom field meta
 * Expects string custom field value
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

	return '<' . $element . ' class="meta meta--cf">' . $meta_title . $field . '</' . $element . '>';
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

function nest_get_share_data( $args = array() ) {

	if ( empty( $args ) || is_wp_error( $args ) ) {
		return false;
	}

	$defaults = array(
		'facebook' => 0,
		'twitter' => 0,
		'googleplus' => 0,
		'linkedin' => 0,
		'pinterest' => 0,
		'digg' => 0,
		'reddit' => 0,
		'email' => 0,
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	$post_url = get_permalink();
	$post_title = get_the_title();
	//$encoded_title = urlencode( get_the_title() );
	$encoded_title = rawurlencode( html_entity_decode( $post_title ) );

	$networks = array();

	if ( $facebook ) {
		$networks[] = array(
			'name' => __( 'Facebook', 'nest' ),
			'slug' => 'facebook',
			'url' => 'https://www.facebook.com/sharer.php?u=' . $post_url . '&t=' . $encoded_title,
		);
	}

	if ( $twitter ) {

		$decoded_title = html_entity_decode( $post_title );
		//$short_title = strlen( $decoded_title ) > 117 ? substr( $decoded_title, 0, 117 ) . "..." : $decoded_title;
		$short_title = strlen( $decoded_title ) > 117 ? substr( $decoded_title, 0, strrpos( substr( $decoded_title, 0, 117 ), ' ' ) ) . html_entity_decode( '&hellip;' ) : $decoded_title;
		$encoded_short_title = rawurlencode( html_entity_decode( $short_title ) );

		$networks[] = array(
			'name' => __( 'Twitter', 'nest' ),
			'slug' => 'twitter',
			'url' => 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $encoded_short_title,
		);
	}

	if ( $googleplus ) {
		$networks[] = array(
			'name' => __( 'Google+', 'nest' ),
			'slug' => 'googleplus',
			'url' => 'https://plus.google.com/share?url=' . $post_url,
		);
	}

	if ( $linkedin ) {
		$networks[] = array(
			'name' => __( 'LinkedIn', 'nest' ),
			'slug' => 'linkedin',
			'url' => 'https://www.linkedin.com/cws/share?url=' . $post_url,
		);
	}

	if ( $pinterest ) {

		if ( has_post_thumbnail() ) {
			$featured_image_id = get_post_thumbnail_id();
			$featured_image = wp_get_attachment_image_src( $featured_image_id, 'large' );
			$image_path = $featured_image[0];

		} else {
			$image_path = nest_get_first_image_url( $size = 'large' );
		}

		$networks[] = array(
			'name' => __( 'Pinterest', 'nest' ),
			'slug' => 'pinterest',
			'url' => 'https://pinterest.com/pin/create/bookmarklet/?media=?url=' . $post_url . '&media=' . $image_path . '&description='. $encoded_title,
		);
	}

	if ( $digg ) {
		$networks[] = array(
			'name' => __( 'Digg', 'nest' ),
			'slug' => 'digg',
			'url' => 'http://digg.com/submit?url=' . $post_url . '&title=' . $encoded_title,
		);
	}

	if ( $reddit ) {
		$networks[] = array(
			'name' => __( 'Reddit', 'nest' ),
			'slug' => 'reddit',
			'url' => 'https://www.reddit.com/submit?url=' . $post_url . '&title=' . $encoded_title,
		);
	}

	if ( $email ) {
		$networks[] = array(
			'name' => __( 'Email', 'nest'),
			'slug' => 'email',
			'url' => 'mailto:?subject=' . $encoded_title . '&body=' . $post_url,
		);
	}

	return $networks;
}

/**
 * Scriptless social sharing links
 * Turn the defaults for various profiles on or off as needed using booleans
 * If 'new window' is set to true, link targets will be set to "_blank"
 * If you set the twitter handle to your twitter username, it will append the twitter share link with a via tag
 */

function nest_get_meta_share( $args = array( 'facebook' => 1, 'twitter' => 1, 'googleplus' => 1  ), $before = null, $element = 'span', $item_sep = ', ', $new_window = true ) {
	$networks = nest_get_share_data( $args );
	if ( empty( $networks ) && is_wp_error( $networks ) ) {
		return false;
	}

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

	$share_array = array();

	foreach ( $networks as $network ) {
		$share_array[] = '<a class="share-link share-link--' . $network['slug'] . '" href="' . esc_url( $network['url'] ) . '" title="Share on ' . $network['name'] . '"' . $target . '>' . $network['name'] . '</a>';
	}

	if ( ! empty( $share_array ) ) {
		return '<' . $element . ' class="meta meta--share">' . $meta_title . implode( $item_sep, array_filter( $share_array ) ) . '</' . $element . '>';
	} // if ! empty $share_links

	return false;
}


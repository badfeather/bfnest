<?php

/**
 * Outputs meta functions added via first arg array
 * Use any of the the below functions or any custom functions you declare
 */
// Get function
function bfnest_get_meta( $metas = array(), $meta_sep = ' | ', $meta_class = array(), $before = '', $after = '' ) {
	$meta_array = array();

	if ( ! empty( $metas ) ) {
		foreach ( $metas as $meta ) {
			if ( $meta ) {
				$meta_array[] = $meta;
			}
		}
	}

	array_unshift( $meta_class, 'entry-meta' );

	$meta_array = array_values( array_filter( $meta_array ) );

	if ( ! empty( $meta_array ) ) {
		return $before . "\n" . '<div class="' . join( ' ', $meta_class ) . '">' . join( $meta_sep, $meta_array ) . '</div>' . "\n" . $after . "\n";
	}

	return false;
}

// Echo function
function bfnest_meta( $metas = array(), $meta_sep = ' | ', $meta_class = array(), $before = '', $after = '' ) {
	echo bfnest_get_meta( $metas, $meta_sep, $meta_class, $before, $after );
}

/**
 * Edit footer - used on post type views without any other meta info in the footer
 * $footer_class should either be 'doc' or 'entry'
 */
function bfnest_edit_footer( $footer_class = 'doc' ) {
	bfnest_meta( array( bfnest_get_meta_edit_link() ), '', array(), $before = '<footer class="' . esc_attr( $footer_class ) . '-footer">', $after = '</footer>' );
}

/**
 * Meta taxonomy terms
 * $taxonomy defaults to 'category'
 * $before can be null, which will default to 'Posted in: ', '', which will omit the title, or any custom text
 * $element expects 'span' or 'div'
 */
function bfnest_get_meta_terms( $taxonomy = 'category', $before = null, $sep = ', ', $element = 'span', $link = true ) {
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

	$terms_array = array();

	foreach ( $terms as $term ) {
		$term_before = $term_after = '';
		if ( $link ) {
			$url = get_term_link( $term, $taxonomy );
			$term_before = '<a href="' . esc_url( $url ) . '" rel="tag">';
			$term_after = '</a>';
		}
		$terms_array[] = $term_before . $term->name . $term_after;
	}

	return '<' . $element . ' class="meta meta--terms">' . $title . join( $sep, $terms_array ) . '</' . $element . '>' . "\n";
}

/**
 * Meta categories
 * $before can be null, which will default to 'Posted in: ', '', which will omit the title, or any custom text
 * $element expects 'span' or 'div'
 */
function bfnest_get_meta_categories( $before = null, $sep = ', ', $element = 'span', $link = true ) {
	return bfnest_get_meta_terms( 'category', $before, $sep, $element, $link );
}

/**
 * Meta tags
 * $before can be null, which will default to 'Tagged: ', '', which will omit the title, or any custom text
 * $element expects 'span' or 'div'
 */
function bfnest_get_meta_tags( $before = null, $sep = ', ', $element = 'span', $link = true ) {
	if ( null === $before ) {
		$before = __( 'Tagged: ', 'bfnest' );
	}

	return bfnest_get_meta_terms( 'post_tag', $before, $sep, $element, $link );
}

/**
 * Meta comments link
 */
function bfnest_get_meta_comments_link( $element = 'span' ) {
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

	return '<'. $element . ' class="meta meta--comment"><a href="' . $comments_link . '">' . $label . '</a></' . $element . '>';

}

/**
 * Meta pubdate
 * $before can be custom text, or will be otherwise omitted
 * $element expects 'span' or 'div'
 */
function bfnest_get_meta_pubdate( $before = null, $element = 'span' ) {
	$date = get_the_date();

	if ( ! $date ) {
		return false;
	}

	$title = $before ? '<span class="meta-title">' . $before . '</span>' : '';

	return '<' . $element . ' class="meta meta--published">' . $title . '<time class="published" datetime = "' . get_the_time( 'c' ) . '">' . $date . '</time></' . $element . '>';
}

/**
 * Meta author
 */
function bfnest_get_meta_author( $before = null, $element = 'span' ) {
	$author = get_the_author();

	if ( empty( $author ) || is_wp_error( $author ) ) {
		return false;
	}

	$title = $before ? '<span class="meta-title">' . $before . '</span>' : '';

	return '<' . $element . ' class="meta meta--author">' . $title . '<span class="byline author vcard"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . $author . '</a></span></' . $element . '>';
}

/**
 * Custom field meta
 * Expects string custom field value
 */
function bfnest_get_meta_field( $meta_field = '', $before = null, $element = 'span', $class = '' ) {
	if ( empty( $meta_field ) ) {
		return false;
	}

	$field = get_post_meta( get_the_ID(), $meta_field, true );
	if ( ! $field ) {
		return false;
	}

	$title = $before ? '<span class="meta-title">' . $before . '</span>' : '';
	$add_class = $class ? ' ' . $class : '';

	return '<' . $element . ' class="meta meta--cf' . esc_attr( $add_class ) . '">' . $title . $field . '</' . $element . '>';
}

/**
 * Custom field link meta
 * Expects url custom field value
 * $linked_text defaults to 'Download'
 */
function bfnest_get_meta_field_link( $meta_field = '', $before = null, $linked_text = 'Download', $element = 'span', $class = '', $new_window = false ) {
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

	return '<' . $element . ' class="meta meta--cf-link' . esc_attr( $add_class ) . '">' . $title . '<a href="' . esc_url( $field ) . '"' . $target . '>' .
	esc_html( $linked_text ) .
	'</a></' . $element . '>';
}

/**
 * Meta edit link
 */
function bfnest_get_meta_edit_link( $label = null, $element = 'span' ) {
	$edit_post_link = get_edit_post_link();

	if ( ! $edit_post_link ) {
		return false;
	}

	if ( null === $label ) {
		$label = __( 'Edit', 'bfnest' );
	}

	return '<' . $element . ' class="meta meta--edit"><a href="' . $edit_post_link . '">' . $label . '</a></' . $element . '>';
}

/**
 * Helper function for bfnest_get_meta_share
 */
function bfnest_get_share_data( $args = array() ) {
	if ( empty( $args ) || is_wp_error( $args ) ) {
		return false;
	}

	$defaults = array(
		'facebook' => 0,
		'twitter' => 0,
		'linkedin' => 0,
		'pinterest' => 0,
		'pocket' => 0,
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
			'name' => __( 'Facebook', 'bfnest' ),
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
			'name' => __( 'Twitter', 'bfnest' ),
			'slug' => 'twitter',
			'url' => 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $encoded_short_title,
		);
	}

	if ( $linkedin ) {
		$networks[] = array(
			'name' => __( 'LinkedIn', 'bfnest' ),
			'slug' => 'linkedin',
			'url' => 'https://www.linkedin.com/cws/share?url=' . $post_url,
		);
	}

	if ( $pinterest ) {
		$image = bfnest_get_featured_or_first_image_url( $size = 'large' );
		if ( $image ) {
			$networks[] = array(
				'name' => __( 'Pinterest', 'bfnest' ),
				'slug' => 'pinterest',
				'url' => 'https://pinterest.com/pin/create/bookmarklet/?media=?url=' . $post_url . '&media=' . $image . '&description='. $encoded_title,
			);
		}
	}

	if ( $pocket ) {
		$networks[] = array(
			'name' => __( 'Pocket', 'bfnest' ),
			'slug' => 'pocket',
			'url' => 'https://getpocket.com/save?url=' . $post_url,
		);
	}

	if ( $digg ) {
		$networks[] = array(
			'name' => __( 'Digg', 'bfnest' ),
			'slug' => 'digg',
			'url' => 'http://digg.com/submit?url=' . $post_url . '&title=' . $encoded_title,
		);
	}

	if ( $reddit ) {
		$networks[] = array(
			'name' => __( 'Reddit', 'bfnest' ),
			'slug' => 'reddit',
			'url' => 'https://www.reddit.com/submit?url=' . $post_url . '&title=' . $encoded_title,
		);
	}

	if ( $email ) {
		$networks[] = array(
			'name' => __( 'Email', 'bfnest'),
			'slug' => 'mail',
			'url' => 'mailto:?subject=' . $encoded_title . '&body=' . $post_url,
		);
	}

	$networks = array_values( array_filter( $networks ) );

	return apply_filters( 'bfnest_add_share_networks', $networks );
}

/**
 * Scriptless social sharing links
 * Turn the defaults for various profiles on or off as needed using booleans
 * If 'new window' is set to true, link targets will be set to "_blank"
 * If you set the twitter handle to your twitter username, it will append the twitter share link with a via tag
 * Uses bfnest_get_share_data()
 */

function bfnest_get_meta_share(
		$args = array(
			'facebook' => 1,
			'twitter' => 1,
			'linkedin' => 1,
			'pinterest' => 1,
			'pocket' => 1,
			'digg' => 1,
			'reddit' => 1,
			'email' => 1,
		),
		$before = null,
		$element = 'span',
		$item_sep = ' ',
		$new_window = true,
		$add_icons = true,
		$text_replace = true
	) {
	$networks = bfnest_get_share_data( $args );
	if ( empty( $networks ) || is_wp_error( $networks ) ) {
		return false;
	}

	$title = '';
	if ( null === $before ) {
		$title = '<span class="meta-title">' . __( 'Share: ', 'bfnest' ) . '</span>';

	} elseif ( ! empty( $before ) ) {
		$title = '<span class="meta-title">' . $before . '</span>';
	}

	if ( $new_window ) {
		$target = ' target="_blank"';

	} else {
		$target = '';
	}

	$share_array = array();

	foreach ( $networks as $network ) {
		$network_before = $network_after = '';
		$network_slug = $network['slug'];
		$network_name = $network['name'];
		$before_link = $after_link = '';
		if ( $add_icons ) {
			$svg = bfnest_get_social_svg( $network['slug'] );
			if ( $svg ) {
				$network_before .= '<span class="share-link-icon" aria-hidden="true">' . $svg . '</span>';
				if ( $text_replace ) {
					$network_before .= '<span class="sr-only">';
					$network_after .= '</span>';
				}
			}
		}

		$share_array[] = '<a class="share-link share-link--' . $network['slug'] . '" href="' . esc_url( $network['url'] ) . '" title="Share on ' . $network['name'] . '"' . $target . ' rel="noopener noreferrer nofollow">' . $network_before . $network['name'] . $network_after . '</a>';
	}

	if ( ! empty( $share_array ) ) {
		return '<' . $element . ' class="meta meta--share">' . $title . join( $item_sep, $share_array ) . '</' . $element . '>';
	} // if ! empty $share_links

	return false;
}


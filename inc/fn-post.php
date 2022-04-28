<?php
/**
 * Used in post type and taxonomy archives
 * Add any custom post type/taxonomy conditionals here
 */
function bfnest_get_archive_post_type() {
	if ( ! ( is_archive() || is_home() ) ) {
		return false;
	}
	$type = false;

	if ( is_home() || is_category() || is_tag() || is_date() || is_author() ) {
		$type = 'post';
	}

	// add conditionals for other post types

//	if ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
//		$type = 'product';
//	}

	return $type;
}

/**
 * Post is in descendant category
 * See http://codex.wordpress.org/Function_Reference/in_category
 */
function bfnest_post_is_in_descendant_term( $terms, $post = null, $taxonomy = 'category' ) {
	foreach ( (array) $terms as $term ) {
		// get_term_children() accepts integer ID only
		$descendants = get_term_children( (int) $term, $taxonomy );
		if ( $descendants && has_term( $descendants, $taxonomy, $post ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Legacy bfnest_post_is_in_descentant_category()
 * Uses bfnest_post_is_in_descendant_term()
 */
function bfnest_post_is_in_descendant_category( $terms, $post = null ) {
	return bfnest_post_is_in_descendant_term( $terms, $post );
}

/**
 * Check if post is in a term or a descendant term
 */
function bfnest_post_is_in_term_or_term_descendant( $term_id, $post = null, $taxonomy = 'category' ) {
	if ( has_term( $term_id, $taxonomy, $post ) || bfnest_post_is_in_descendant_term( $term_id, $post, $taxonomy ) ) {
		return true;
	}
	return false;
}

/**
 * Legacy bfnest_post_is_in_category_or_descentant_category()
 * Uses bfnest_post_is_in_term_or_descendant_term()
 */
function bfnest_post_is_in_category_or_category_descendant( $term_id, $post = null ) {
	return bfnest_post_is_in_term_or_term_descendant( $term_id, $post, 'category' );
}

/**
 * Test whether the current taxonomy archive matches a term or a descendant term
 */
function bfnest_is_term_or_term_descendant( $term_id = null, $taxonomy = 'category' ) {
	if ( ! is_tax( $taxonomy ) || ! term_exists( $term_id ) ) {
		return false;
	}

	$current_term_id = get_queried_object_id();

	if ( $term_id == $current_term_id || in_array( $current_term_id, get_term_children( $term_id, $taxonomy ) ) ) {
		return true;
	}

	return false;
}

/**
 * Get the top parent term of current post or taxonomy archive
 * Works only on single posts and hierarchical
 */
function bfnest_get_top_parent_term_id( $term_id = null, $taxonomy = 'category' ) {
	if ( ! $term_id ) {
		if ( is_single() ) {
			$terms = get_the_terms( get_the_ID(), $taxonomy );
			$term_ids = [];
			foreach ( $terms as $term ) {
				$term_ids[] = $term->term_id;
			}

			$term_id = $term_ids[0];

		} elseif ( is_tax( $taxonomy ) || ( 'category' == $taxonomy && is_category() ) ) {
			$term_id = get_queried_object_id();
		}
	}

	if ( ! term_exists( $term_id, $taxonomy ) ) {
		return false;
	}

	$ancestors = get_ancestors( $term_id, $taxonomy, 'taxonomy' );
	array_unshift( $ancestors, $term_id );
	return end( $ancestors );
}

/**
 * Get top parent term
 * Should be used only on single post templates or taxonomy archives
 * $taxonomy detaults to 'category' but can be any hierarchical taxonomy
*/
function bfnest_get_top_parent_term( $term_id = null, $taxonomy = 'category' ) {
	$top_term_id = bfnest_get_top_parent_term_id( $term_id, $taxonomy );

	if ( ! $top_term_id ) {
		return false;
	}

	return get_term_by( 'id', $top_term_id, $taxonomy );
}

/**
 * Get top parent page id
 * Returns current post_id if no parents are found
 */
function bfnest_get_top_parent_page_id( $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$ancestors = get_post_ancestors( $post_id );
	array_unshift( $ancestors, $post_id );
	return end( $ancestors );
}


/**
 * test if is a descendant page of a particular page id
 * https://developer.wordpress.org/reference/functions/is_page/
 */
function bfnest_is_tree( $parent_id ) {
	$is_tree = is_page( $parent_id ) ? true : false;
    $ancestors = get_post_ancestors( get_the_ID() );
    foreach ( $ancestors as $ancestor ) {
        if ( is_page() && $ancestor == $parent_id ) {
            $is_tree = true;
        }
    }
    return $is_tree;
}

/**
 * Page subnav widget
 */
function bfnest_page_subnav( $page_id = '', $title = '' ) {
	if ( $page_id && is_page( $page_id ) ) {
		$top_parent = $page_id;

	} else {
		$top_parent = bfnest_get_top_parent_page_id( get_the_ID() );
	}

	$children = wp_list_pages( array(
		'sort_column' => 'menu_order',
		'title_li' => '',
		'child_of' => $top_parent,
		'echo' => 0
	) );

	if ( empty( $children ) ) {
		return false;
	}

	$nav_title = ( $title ? $title : get_the_title( $top_parent ) );
?>
<nav class="nav nav--secondary">
	<h2 class="nav-title"><?php echo esc_html( $nav_title ); ?></h2>
	<ul class="menu menu--secondary">
		<?php echo $children; ?>
	</ul>
</nav>
<?php
}

/**
 * Outputs subnav list of childen of current post or current taxonomy's topmost parent
 */
function bfnest_taxonomy_subnav( $taxonomy = 'category', $title = '', $exclude = '', $orderby = 'name' ) {
	$top_parent = bfnest_get_top_parent_term( $taxonomy );
	if ( ! $top_parent ) {
		return false;
	}

	$children = wp_list_categories( array(
		'child_of' => $top_parent->term_id,
		'title_li' => '',
		'echo' => 0,
		'taxonomy' => $taxonomy,
		'show_option_none' => '',
		'exclude' => $exclude,
		'orderby' => $orderby
	) );

	if ( ! $children ) {
		return false;
	}

	$nav_title = ( $title ? $title : $top_parent->name );
?>
<nav class="nav nav--secondary nav--taxonomies">
	<h2 class="nav-title"><?php echo esc_html( $nav_title ); ?></h2>
	<ul class="menu menu--secondary">
		<?php echo $children; ?>
	</ul>
</nav>
<?php
}

/**
 * Outputs subnav list of childen of current post or current category's topmost parent
 */
function bfnest_category_subnav( $title = '' ) {
	return bfnest_taxonomy_subnav( 'category', $title );
}

/**
 * Latest posts
 * Requires term ID. Defaults to 3 posts ordered by date
 */
function bfnest_latest_posts( $args ) {
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
	<?php
		if ( $widget_title ) {
			echo '<h2 class="widget-title">'. esc_html( $widget_title ) .'</h2>';
		}
	?>
	<div class="widget-content">
		<?php
			while ( $latest->have_posts() ) {
				$latest->the_post();
				get_template_part( 'partials/content', $content_part );
			}
			wp_reset_postdata();
		?>
	</div>
</aside>
<?php
	}
}

/**
 * Latest posts in specific taxonomy id
 * Requires term ID. Defaults to 3 posts and category as taxonomy
 */
function bfnest_latest_taxonomy_posts( $args ) {
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
		echo '<h2 class="widget-title">' . esc_html( $widget_title ) . '</h2>';
	} ?>
	<div class="widget-content">
		<?php
			while ( $latest->have_posts() ) {
					$latest->the_post();
					get_template_part( 'partials/content', $content_part );
			}
			wp_reset_postdata();
		?>
	</div>
</aside>
<?php
	}
}

/**
 * Get first taxonomy term assigned to post
 * @param string $taxonomy Taxonomy key
 * @param integer $post_id Post ID, defaults to current post
 */
function bfnest_get_first_term( $taxonomy = 'category', $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$terms = get_the_terms( $post_id, $taxonomy );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return false;
	}
	return array_pop( $terms );
}

/**
 * Get primary taxonomy term assigned to post
 * @param string $taxonomy Taxonomy key
 * @param integer $post_id Post ID, defaults to current post
 */
function bfnest_get_primary_term( $taxonomy = 'category', $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$first_term = bfnest_get_first_term( $taxonomy, $post_id );

	if ( ! class_exists( 'WPSEO_Primary_Term' ) ) {
		return $first_term;
	}
	$wpseo_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
	$primary_term_id = $wpseo_term->get_primary_term();
	$primary_term = get_term( $primary_term_id );
	return ! empty( $primary_term ) && ! is_wp_error( $primary_term ) ? $primary_term : $first_term;
}

/**
 * Pretty print array/object - basically a print_r with a <pre> wrapper
 * @param $array data
 */
function bfnest_pretty_print( $data = [] ) {
	if ( empty( $data ) ) {
		return;
	}
	echo '<pre>';
	print_r( $data );
	echo '</pre>' . "\n";
}

/**
 * Get post title based via custom field, with fallback to post title
 * @param string $field Custom field key
 * @param intenger $post_id Post ID. Defaults to current ID
 */
function bfnest_get_title( $field = 'alternate_title', $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$alt_title = get_post_meta( $post_id, $field, true );
	return $alt_title ? $alt_title : get_the_title();
}

function bfnest_title( $field = 'alternate_title', $post_id = null ) {
	echo bfnest_get_title( $field, $post_id );
}

/**
 * Get post lede based via custom field
 * @param string $field Custom field key
 * @param intenger $post_id Post ID. Defaults to current ID
 */
function bfnest_get_lede( $field = 'lede', $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$lede = get_post_meta( $post_id, $field, true );
	if ( ! $lede ) {
		return false;
	}
	return '<div class="entry-lede">' . wp_kses_post( $lede ) . '</div>' . "\n";
}

function bfnest_lede( $field = 'lede', $post_id = null ) {
	echo bfnest_get_lede( $field, $post_id );
}

/**
 * Get post subtitle based via custom field
 * @param string $field Custom field key
 * @param intenger $post_id Post ID. Defaults to current ID
 */
// Get
function bfnest_get_subtitle( $field = 'subtitle', $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$subtitle = get_post_meta( $post_id, $field, true );
	if ( ! $subtitle ) {
		return false;
	}
	return '<div class="entry-subtitle">' . esc_html( $subtitle ) . '</div>' . "\n";
}

// Echo
function bfnest_subtitle( $field = 'subtitle', $post_id = null ) {
	echo bfnest_get_subtitle( $field, $post_id );
}

/**
 * Get primary term and output in div with class 'entry-content-flag'
 * @param string $taxonomy Taxonomy key
 * @param boolean $link Whether to link to term
 * @param integer $post_id Defaults to current post if not specified
 * @return string Div with 'entry-content-flag' class, with term name optionally linked to term
 */
// Get
function bfnest_get_content_flag( $taxonomy = 'category', $link = 1, $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$term = bfnest_get_primary_term( $taxonomy, $post_id );
	if ( empty( $term ) ) {
		return false;
	}
	$name = $term->name;
	$name = $link ?  '<a href="' . get_term_link( $term, $taxonomy ) . '">' . $name . '</a>' : $name;
	return '<div class="entry-content-flag">' . $name . '</div>' . "\n";
}

// Echo
function bfnest_content_flag( $taxonomy = 'category', $link = true, $post_id = null ) {
	echo bfnest_get_content_flag( $taxonomy, $link, $post_id );
}

/**
 * Get taxonomy terms outputted in div with class 'entry-content-flag'
 * @param string $taxonomy Taxonomy key
 * @param boolean $link Whether to link terms
 * @param string $sep Term separator
 */
function bfnest_get_content_flags( $taxonomy = 'category', $link = true, $sep = ' &nbsp;' ) {
	$flags = bfnest_get_meta_terms( $taxonomy, '', $sep, 'div', $link );
	if ( ! $flags ) return false;
	return '<div class="entry-content-flag">' . $flags . '</div>' . "\n";
}

function bfnest_content_flags( $taxonomy = 'category', $link = true, $sep = ' ' ) {
	echo bfnest_get_content_flags( $taxonomy, $link, $sep );
}

/**
 * Get featured image and return in figure, with optional link
 * @param string $size The media size
 * @param boolean $link Whether to link to post (default) or url specified in $url
 * @param string $url URL to link to other than post if $link is set to true
 * @param boolean $caption Whether to display image caption or not
 * @param array $classes Additional classes to add to figure in addition to 'entry-figure'
 * @param boolean $use_first Whether to use the first image if no featured image is found
 * @param integer $post_id The post ID. Defaults to current post in query if not specified
 * @return figure element with featured image, optionally linking to post or other url
 */
// Get
function bfnest_get_figure( $size = 'thumbnail', $link = 1, $url = '', $caption = 0, $classes = [], $use_first = 0, $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$image_id = $use_first ? bfnest_get_featured_or_first_image_id( $post_id ) : get_post_thumbnail_id( $post_id );
	if ( ! $image_id ) return false;
	$image = wp_get_attachment_image( $image_id, $size );
	$figcaption = $caption ? wp_get_attachment_caption( $post_id ) : '';
	if ( $link ) {
		$href = $url ? $url : get_permalink( $post_id );
		$atts = $url ? ' target="_blank" rel="noopener nofollow"' : '';
		$image = '<a href="' . esc_url( $href ) . '"' . $atts . '>' . $image . '</a>';
	}
	if ( ! in_array( 'entry-figure', $classes ) ) {
		$classes[] = 'entry-figure';
	}
	$classes[] = 'entry-figure--size-' . $size;
	return '<figure class="' . esc_attr( join( ' ', $classes ) ) . '">' . $image . $figcaption . '</figure>' . "\n";
}

// Echo
function bfnest_figure( $size = 'thumbnail', $link = 1, $url = '', $caption = 0, $classes = [], $use_first = 0, $post_id = null ) {
	echo bfnest_get_figure( $size, $link, $url, $caption, $classes, $use_first, $post_id );
}

/**
 * Get post excerpt, with optional read more link
 * @param boolean $auto Whether to use auto excerpts. If false, only displays excerpt if manual one is set.
 * @param boolean $link Whether to add link to post after excerpt
 * @param string $link_text Inner text of link
 * @param array $link_classes Classes to add to link
 * @return string div containing entry excerpt or false if none exists
 */
// Get
function bfnest_get_excerpt( $auto = 0, $link = 0, $link_text = 'Read more', $link_classes = [], $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : $post_id;
	$excerpt = $auto ? get_the_excerpt() : '';
	$excerpt = ! $auto && has_excerpt() ? get_the_excerpt() : '';
	if ( ! $excerpt ) return;
	$add_link = '';
	if ( $link && $link_text ) {
		$class = ! empty( $link_classes ) ? ' class="' . esc_attr( join( ' ', $link_classes ) ) . '"' : '';
		$add_link = '<a href="' . get_permalink( $post_id ) . '"' . $class . '>' . esc_html( $link_text ) . '</a>';
	}
	return '<div class="entry-excerpt">' . $excerpt . $add_link . '</div>' . "\n";
}

// Echo
function bfnest_excerpt( $auto = 0, $link = 0, $link_text = 'Read more', $link_classes = [], $post_id = null ) {
	echo bfnest_get_excerpt( $auto, $link, $link_text, $link_classes, $post_id );
}

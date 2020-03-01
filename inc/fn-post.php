<?php
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
			$term_ids = array();
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
			} // endwhile
			wp_reset_postdata();
		?>
	</div><?php //	 /.widget-content ?>
</aside><?php //	/.widget.widget--latest ?>
<?php
	} // endif
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
			} // endwhile
			wp_reset_postdata();
		?>
	</div><?php //	 /.widget-content ?>
</aside><?php //	/.widget.widget--latest ?>
<?php
	} //endif
}

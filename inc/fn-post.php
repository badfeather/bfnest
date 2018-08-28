<?php
/**
 * Post is in descendant category
 * See http://codex.wordpress.org/Function_Reference/in_category
 */
function nest_post_is_in_descendant_term( $terms, $post = null, $taxonomy = 'category' ) {
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
 * Legacy nest_post_is_in_descentant_category()
 * Uses nest_post_is_in_descendant_term()
 */
function nest_post_is_in_descendant_category( $terms, $post = null ) {
	return nest_post_is_in_descendant_term( $terms, $post );
}

/**
 * Check if post is in a term or a descendant term
 */
function nest_post_is_in_term_or_term_descendant( $term_id, $post = null, $taxonomy = 'category' ) {
	if ( has_term( $term_id, $taxonomy, $post ) || nest_post_is_in_descendant_term( $term_id, $post, $taxonomy ) ) {
		return true;

	}
	return false;
}

/**
 * Legacy nest_post_is_in_category_or_descentant_category()
 * Uses nest_post_is_in_term_or_descendant_term()
 */
function nest_post_is_in_category_or_category_descendant( $term_id, $post = null ) {
	return nest_post_is_in_term_or_term_descendant( $term_id, $post, 'category' );
}

/**
 * Test whether the current taxonomy archive matches a term or a descendant term
 */
function nest_is_term_or_term_descendant( $term_id = null, $taxonomy = 'category' ) {
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
 * Get top parent page id
 * Returns current post_id if no parents are found
 */
function nest_get_top_parent_page_id( $post_id = null ) {

	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	$ancestors = get_post_ancestors( $post_id );
	array_unshift( $ancestors, $post_id );
	return end( $ancestors );
}

/**
 * Test whether post is a descendant
 */
function nest_is_descendant_page( $post_id = null ) {

	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! get_post_status( $post_id ) ) {
		return false;
	}

	$ancestors = get_post_ancestors( $post_id );

	if ( ! empty( $ancestors ) ) {
		return true;
	}

	return false;
}

/**
 * test if is a descendant page of a particular page id
 * modified/cleaned up version of is_tree function found here:
 * https://developer.wordpress.org/reference/functions/is_page/
 */
function nest_is_page_or_descendant_page( $post_id = null ) {

	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! get_post_status( $post_id ) ) {
		return false;
	}

	if ( is_single( $post_id ) || nest_is_descendant_page( $post_id ) ) {
		return true;
	}

	return false;
};

/**
 * Get the top parent term of current post or taxonomy archive
 * Works only on single posts and hierarchical
 */
function nest_get_top_parent_term_id( $term_id = null, $taxonomy = 'category' ) {
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
function nest_get_top_parent_term( $term_id = null, $taxonomy = 'category' ) {
	$top_term_id = nest_get_top_parent_term_id( $term_id, $taxonomy );

	if ( ! $top_term_id ) {
		return false;
	}

	return get_term_by( 'id', $top_term_id, $taxonomy );
}

/**
 * Page subnav widget
 */
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
 * Outputs subnav list of childen of current post or current taxonomy's topmost parent
 */
function nest_taxonomy_subnav( $taxonomy = 'category', $title = '', $exclude = '', $orderby = 'name' ) {
	$top_parent = nest_get_top_parent_term( $taxonomy );
	if ( ! $top_parent ) {
		return false;
	}

	$terms_list = wp_list_categories( array(
		'child_of' => $top_parent->term_id,
		'title_li' => '',
		'echo' => 0,
		'taxonomy' => $taxonomy,
		'show_option_none' => '',
		'exclude' => $exclude,
		'orderby' => $orderby
	) );

	if ( ! $title ) {
		$title = $top_parent->name;
	}

	if ( ! empty( $terms_list ) ) {
?>
<nav class="nav nav--secondary nav--taxonomies">
	<h2 class="nav__title"><?php echo esc_html( $title ); ?></h2>
	<ul class="menu menu--secondary">
		<?php echo $terms_list; ?>
	</ul>
</nav>
<?php
	} // endif
}

/**
 * Outputs subnav list of childen of current post or current category's topmost parent
 */
function nest_category_subnav( $title = '' ) {
	return nest_taxonomy_subnav( 'category', $title );
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

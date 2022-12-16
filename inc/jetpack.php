<?php

/**
 * Add support for infinite scroll
 */
function bfnest_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'type' => 'click', // options are 'scroll' or 'click'. Defaults to 'click'.
		// 'container' => 'content', // id of loop container. defaults to 'content'
		'footer' => false, // id of site wrapper. defaults to 'page'
		'posts_per_page' => get_option( 'posts_per_page' ) // defaults to 7 for 'scroll' or standard posts per page for click
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'bfnest_jetpack_setup' );

/**
 * Change text of infinite scroll load more button
 */
function bfnest_infinite_scroll_js_settings( $settings ) {
	$settings['text'] = __( 'Load more', 'bfnest' );
	return $settings;
}
add_filter( 'infinite_scroll_js_settings', 'bfnest_infinite_scroll_js_settings' );

/**
 * Remove Jetpack sharing buttons from loop
 */
function bfnest_remove_jetpack_share() {
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}
add_action( 'loop_start', 'bfnest_remove_jetpack_share' );

/**
 * Manually place sharing buttons using the following function
 */
function bfnest_jetpack_share() {
	if ( function_exists( 'sharing_display' ) ) {
		sharing_display( '', true );
	}

	if ( class_exists( 'Jetpack_Likes' ) ) {
		$custom_likes = new Jetpack_Likes;
		echo $custom_likes->post_likes( '' );
	}
}

/**
 * Remove Jetpack CSS
 */
// First, make sure Jetpack doesn't concatenate all its CSS
add_filter( 'jetpack_implode_frontend_css', '__return_false' );

// Then, remove each CSS file, one at a time
function bfnest_remove_jetpack_css() {
	wp_deregister_style( 'AtD_style' ); // After the Deadline
	wp_deregister_style( 'jetpack_likes' ); // Likes
	wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
	wp_deregister_style( 'jetpack-carousel' ); // Carousel
	wp_deregister_style( 'grunion.css' ); // Grunion contact form
	wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
	wp_deregister_style( 'noticons' ); // Notes
	wp_deregister_style( 'post-by-email' ); // Post by Email
	wp_deregister_style( 'publicize' ); // Publicize
	wp_deregister_style( 'sharedaddy' ); // Sharedaddy
	wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
	wp_deregister_style( 'stats_reports_css' ); // Stats
	wp_deregister_style( 'jetpack-widgets' ); // Widgets
	wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
	wp_deregister_style( 'presentations' ); // Presentation shortcode
	wp_deregister_style( 'jetpack-subscriptions' ); // Subscriptions
	wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
	//wp_deregister_style( 'widget-conditions' ); // Widget Visibility
	wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
	wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
	wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
	wp_deregister_style( 'jetpack-widgets' ); // Widgets
}
add_action('wp_print_styles', 'bfnest_remove_jetpack_css' );

/**
 * Customize sharedaddy sharing markup
 */
function bfnest_sharing_display_markup( $sharing_content ) {

	global $post, $wp_current_filter;

	$sharing_content = '';

	$sharer = new Sharing_Service();
	$global = $sharer->get_global_options();
	$enabled = $sharer->get_blog_services();

	$sharing_content = '';

	if ( count( $enabled['all'] ) > 0 ) {

		$dir = get_option( 'text_direction' );

		// Wrapper
		$sharing_content .= '<div class="sharedaddy sd-sharing-enabled"><div class="robots-nocontent sd-block sd-social sd-social-' . $global['button_style'] . ' sd-sharing">';
		if ( $global['sharing_label'] != '' )
			$sharing_content .= '<h3 class="sd-title">' . $global['sharing_label'] . '</h3>';
		$sharing_content .= '<div class="sd-content"><ul class="sd-share">';

		// Visible items
		$visible = '';
		foreach ( $enabled['visible'] as $id => $service ) {
			// Individual HTML for sharing service
			$visible .= '<li class="share-' . $service->get_class() . '">' . $service->get_display( $post ) . '</li>';
		}

		$parts = [];
		$parts[] = $visible;
		if ( count( $enabled['hidden'] ) > 0 ) {
			if ( count( $enabled['visible'] ) > 0 )
				$expand = __( 'More', 'bfnest' );
			else
				$expand = __( 'Share', 'bfnest' );
			$parts[] = '<li><a href="#" class="sharing-anchor sd-button share-more"><span>'.$expand.'</span></a></li>';
		}

		if ( $dir == 'rtl' )
			$parts = array_reverse( $parts );

		$sharing_content .= implode( '', $parts );
		//$sharing_content .= '<li class="share-end"></li></ul>';
		$sharing_content .= '</li></ul>';

		if ( count( $enabled['hidden'] ) > 0 ) {
			$sharing_content .= '<div class="sharing-hidden"><div class="inner" style="display: none;';

			if ( count( $enabled['hidden'] ) == 1 )
				$sharing_content .= 'width:150px;';

			$sharing_content .= '">';

			if ( count( $enabled['hidden'] ) == 1 )
				$sharing_content .= '<ul style="background-image:none;">';
			else
				$sharing_content .= '<ul>';

			$count = 1;
			foreach ( $enabled['hidden'] as $id => $service ) {
				// Individual HTML for sharing service
				$sharing_content .= '<li class="share-'.$service->get_class().'">';
				$sharing_content .= $service->get_display( $post );
				$sharing_content .= '</li>';

				//if ( ( $count % 2 ) == 0 )
					//$sharing_content .= '<li class="share-end"></li>';

				$count ++;
			}

			// End of wrapper
			//$sharing_content .= '<li class="share-end"></li></ul></div></div>';
			$sharing_content .= '</ul></div></div>';
		}

		$sharing_content .= '</div></div></div>';
	}
	return $sharing_content;
}
add_filter( 'jetpack_sharing_display_markup', 'bfnest_sharing_display_markup', 10, 1 );

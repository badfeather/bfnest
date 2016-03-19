<?php
/**
 * Chill Yoast SEO out
 */

// Remove "page analysis" and annoying SEO columns
add_filter( 'wpseo_use_page_analysis', '__return_false' );

// Make sure the SEO box is at the very bottom of the post edit screen
function nest_metabox_prio( $in ) {
	return 'low';
};

add_filter( 'wpseo_metabox_prio', 'nest_metabox_prio');

// Remove SEO menu from Admin bar
function nest_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'wpseo-menu' );
}

add_action( 'wp_before_admin_bar_render', 'nest_admin_bar_render' );

// Remove "Has been updated" notification and tour bubble.
function nest_get_user_metadata( $value, $object_id, $meta_key, $single ) {
	if( $meta_key === 'wpseo_ignore_tour' ) {
		return true;
	}

	if( $meta_key === 'wpseo_seen_about_version' ) {
		return defined('WPSEO_VERSION') ? WPSEO_VERSION : null;
	}

	return $value;
}

add_action( 'get_user_metadata', 'nest_get_user_metadata', 10, 4 );

// Remove notification nags for every update
function nest_disable_yoast_notifications() {
	if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
		remove_action( 'admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
		remove_action( 'all_admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
	}
}

add_action( 'admin_init', 'nest_disable_yoast_notifications' );

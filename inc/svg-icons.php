<?php
/**
 * inline SVG file
 */
// Get function
function bfnest_get_svg( $path = null ) {
	if ( ! file_exists( $path ) ) {
		return false;
	}

	return file_get_contents( $path );
}

// Echo function
function bfnest_svg( $path = null ) {
	echo bfnest_get_svg( $path );
}

/**
 * Add SVG definitions immediately after opening body tag
 * Utilizes 'body-before-scripts' action hook
 */
function bfnest_include_svg_sprite() {
	// Define SVG sprite file.
	$sprite_path = get_stylesheet_directory() . '/assets/dist/img/svg-sprite.svg';

	$sprite = bfnest_get_svg( $sprite_path );
	if ( ! $sprite ) {
		return;
	}

	if ( $sprite === '<svg style="display: none;"/>' ) {
		return;
	}

	echo $sprite;
}
add_action( 'wp_footer', 'bfnest_include_svg_sprite', 1099 );



/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function bfnest_social_links_icons() {
	// Supported social links icons.
	$social_links_icons = array(
		'airbnb.com' => 'airbnb',
		'music.apple.com' => 'apple-music',
		'bandcamp.com' => 'bandcamp',
		'behance.net' => 'behance',
		'blogger.com' => 'blogger',
		'codepen.io' => 'codepen',
		'deviantart.com' => 'deviantart',
		'digg.com' => 'digg',
		'dribbble.com' => 'dribbble',
		'ello.co' => 'ello',
		'facebook.com' => 'facebook',
		'flickr.com' => 'flickr',
		'foursquare.com' => 'foursquare',
		'github.com' => 'github',
		'instagram.com' => 'instagram',
		'last.fm' => 'last-fm',
		'linkedin.com' => 'linkedin',
		'mailto:' => 'mail',
		'medium.com' => 'medium',
		'mix.com' => 'mix',
		'pinboard.in' => 'pinboard',
		'pinterest.com' => 'pinterest',
		'getpocket.com' => 'pocket',
		'reddit.com' => 'reddit',
		'/feed' => 'rss',
		'skype.com' => 'skype',
		'skype:' => 'skype',
		'snapchat.com' => 'snapchat',
		'soundcloud.com' => 'soundcloud',
		'spotify.com' => 'spotify',
		'tumblr.com' => 'tumblr',
		'twitch.tv' => 'twitch',
		'twitter.com' => 'twitter',
		'vimeo.com' => 'vimeo',
		'wordpress.org' => 'wordpress',
		'wordpress.com' => 'wordpress',
		'yahoo.com' => 'yahoo',
		'yelp.com' => 'yelp',
		'ycombinator.com' => 'ycombinator',
		'youtube.com' => 'youtube',
	);
	return apply_filters( 'bfnest_social_links_icons', $social_links_icons );
}

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function bfnest_social_nav_menu_icons( $item_output, $item, $depth, $args, $text_replace = true ) {
	// Get supported social icons.
	$social_icons = bfnest_social_links_icons();

	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		//return $item_output;
		foreach ( $social_icons as $attr => $value ) {
			if ( strpos( $item_output, $attr ) ) {
				$svg = bfnest_get_svg( get_stylesheet_directory() . '/assets/dist/img/social-icons/' . $value . '.svg' );
				$before = $after = '';
				if ( $svg ) {
					$before = '<span class="social-link-icon social-link-icon--' . $value . '" aria-hidden="true">' . $svg . '</span>';
					$before .= $text_replace ? '<span class="social-link-text sr-only">' : '<span class="social-link-text">';
					$item_output = str_replace( $args->link_before, $before, $item_output );
				}
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'bfnest_social_nav_menu_icons', 10, 5 );

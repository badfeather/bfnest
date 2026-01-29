<?php
/**
 * inline SVG file
 * $path indicates directory that file lives in
 $ $id indicates filename, minus '.svg'
 */
// Get function
function bfnest_get_svg( $path = '', $id = '' ) {
	if ( ! $path || ! $id ) {
		return false;
	}
	$svg_url = esc_url( $path . $id . '.svg' );
	if ( ! file_exists( $svg_url ) ) {
		return false;
	}

	return file_get_contents( $svg_url );
}

// shortcut for ui icons
function bfnest_get_ui_svg( $id = '' ) {
	if ( ! $id ) {
		return;
	}
	$path = get_stylesheet_directory() . '/img/ui-icons/';
	return bfnest_get_svg( $path, $id );
}

// shortcut for ui icons
function bfnest_get_social_svg( $id = '' ) {
	if ( ! $id ) {
		return;
	}
	$path = get_stylesheet_directory() . '/img/social-icons/';
	return bfnest_get_svg( $path, $id );
}

// Echo function
function bfnest_svg( $path = '', $id = '' ) {
	echo bfnest_get_svg( $path, $id );
}


function bfnest_inline_svg( $path = '', $id = '' ) {
	$svg = bfnest_get_svg( $path, $id );
	if ( ! $svg ) {
		return;
	}
	echo '<span class="icon icon-' . esc_attr( $id ) . '" aria-hidden="true">' . $svg . '</span>';
}

function bfnest_ir_svg( $text = '', $path = '', $id = '' ) {
	if ( ! $text ) {
		return;
	}
	$svg = bfnest_get_svg( $path, $id );
	$html = esc_html( $text );
	if ( $svg ) {
		$html = '<span class="icon icon-' . esc_attr( $id ) . '" aria-hidden="true">' . $svg . '</span><span class="visually-hidden">' . esc_html( $text ) . '</span>';
	}
	echo $html;
}

function bfnest_inline_svg_social( $id = '' ) {
	$path = get_stylesheet_directory() . '/img/social-icons/';
	bfnest_inline_svg( $path, $id );
}

function bfnest_inline_svg_ui( $id = '' ) {
	$path = get_stylesheet_directory() . '/img/ui-icons/';
	bfnest_inline_svg( $path, $id );
}

function bfnest_ir_svg_social( $text = '', $id = '' ) {
	$path = get_stylesheet_directory() . '/img/social-icons/';
	bfnest_ir_svg( $path, $id );
}

function bfnest_ir_svg_ui( $text = '', $id = '' ) {
	$path = get_stylesheet_directory() . '/img/ui-icons/';
	bfnest_ir_svg( $path, $id );
}

/**
 * Add SVG definitions immediately after opening body tag
 * Utilizes 'body-before-scripts' action hook
 */
function bfnest_include_svg_sprite() {
	// Define SVG sprite file.
	$sprite_path = get_stylesheet_directory() . '/img/svg-sprite.svg';

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
	$social_links_icons = [
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
	];
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
				$svg = bfnest_get_social_svg( $value );
				$before = $after = '';
				if ( $svg ) {
					$before = '<span class="social-link-icon social-link-icon--' . $value . '" aria-hidden="true">' . $svg . '</span>';
					$before .= $text_replace ? '<span class="social-link-text visually-hidden">' : '<span class="social-link-text">';
					$item_output = str_replace( $args->link_before, $before, $item_output );
				}
			}
		}
	}

	return $item_output;
}
// add_filter( 'walker_nav_menu_start_el', 'bfnest_social_nav_menu_icons', 10, 5 );

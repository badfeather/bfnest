<?php
/**
 * Helper function to return whether SCRIPT_DEBUG setting in wp-config.php is set to true
 */
function bfnest_is_debug() {
	return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) || ( isset( $_GET['script_debug'] ) ) ? true : false;
}

/**
 * Helper function to get theme version
 */
function bfnest_get_theme_version() {
	$my_theme = wp_get_theme();
	return $my_theme->get( 'Version' );
}

/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'bfnest_scripts' );
function bfnest_scripts() {
	$template_directory = get_template_directory_uri();

	// Fetch the version number of the theme, which can be appended on css/js files for debugging/cacheing issues
	$version = bfnest_get_theme_version();
	$suffix = bfnest_is_debug() ? '' : '.min';

	// Enqueue styles.
	wp_enqueue_style( 'bfnest-style', $template_directory . '/css/theme' . $suffix . '.css', [], $version );

	// Enqueue scripts.
	wp_enqueue_script( 'bfnest-scripts', $template_directory . '/js/theme' . $suffix . '.js', [], $version, [ 'strategy' => 'defer', 'in_footer' => true ] );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }

	// move jQuery to footer
	wp_script_add_data( 'jquery-core', 'group', 1 );
    wp_script_add_data( 'jquery-migrate', 'group', 1 );
	wp_script_add_data( 'jquery', 'group', 1 );
}

/**
 * Remove jQuery migrate
 */
add_action( 'wp_default_scripts', 'bfnest_remove_jquery_migrate' );
function bfnest_remove_jquery_migrate( $scripts ) {
    if ( !is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];

        if ( $script->deps ) {
            $script->deps = array_diff( $script->deps, [ 'jquery-migrate' ] );
        }
    }
}

/**
 * Add preload links for webfonts
 */
add_action( 'wp_head', 'bfnest_add_preload_links_for_fonts' );
function bfnest_add_preload_links_for_fonts() {
	// use font filename, minus directory path and filetype extension, e.g. 'comic-sans'
	$fonts = [];
	foreach ( $fonts as $font ) {
		echo '<link rel="preload" as="font" href="' . esc_url( $template_directory . '/fonts/' . $font . '.woff2' ) . '" type="font/woff2" crossorigin="anonymous">' . "\n";
	}
}

/**
 * Admin head scripts
 */
function bfnest_site_icons() {
	$template_directory = get_template_directory_uri();
?>
<link rel="icon" href="<?php echo esc_url( $template_directory . '/img/favicon.ico' ); ?>" sizes="any">
<link rel="icon" href="<?php echo esc_url( $template_directory . '/img/favicon.svg' ); ?>" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?php echo esc_url( $template_directory . '/img/apple-touch-icon.png' ); ?>" />
<?php
}
add_action( 'wp_head', 'bfnest_site_icons' );
add_action( 'login_head', 'bfnest_site_icons' );
add_action( 'admin_head', 'bfnest_site_icons' );

/**
 * Footer scripts - script tags to add to end of body
 */
function bfnest_footer_scripts() {
	$template_directory = get_template_directory_uri();
	// paste <script> tags within function
?>
<?php
}
add_action( 'wp_footer', 'bfnest_footer_scripts' );

/**
 * Scripts to include immediately after opening body tag
 */
add_action( 'wp_body_open', 'bfnest_nojs_script' );
function bfnest_nojs_script() {
?>
<script>document.body.classList.remove('no-js');</script>
<?php
}

/**
 * Add defer attributes to scripts
 */
add_filter( 'script_loader_tag', 'bfnest_add_defer_atts_to_scripts', 10, 2 );
function bfnest_add_defer_atts_to_scripts( $tag, $handle ) {
	if ( is_user_logged_in() ) return $tag;
	$defers = [
		'bfnest-scripts',
		'jquery-core',
	];
	if ( ! in_array( $handle, $defers ) || strpos( $tag, 'defer' ) ) return $tag;
	return str_replace( ' src', ' defer src', $tag );
}

/**
 * Add async attributes to scripts
 */
add_filter( 'script_loader_tag', 'bfnest_add_async_atts_to_scripts', 10, 2 );
function bfnest_add_async_atts_to_scripts( $tag, $handle ) {
	if ( is_user_logged_in() ) return $tag;
	$asyncs = [];
	if ( ! in_array( $handle, $asyncs ) || strpos( $tag, 'async' ) ) return $tag;
	return str_replace( ' src', ' async src', $tag );
}

/**
 * Add preload attributes to stylesheets
 */
add_filter( 'style_loader_tag', 'bfnest_add_preload_link_to_styles', 10, 3 );
function bfnest_add_preload_link_to_styles( $html, $handle, $href ) {
    if ( is_user_logged_in() ) return $html;
	$handles = [
		'bfnest-style'
	];
	if ( ! in_array( $handle, $handles ) ) return $html;
	return '<link rel="preload" href="' . $href . '" as="style" />' . "\n"  . $html;
}

/**
 * Add preconnect links for typekit
 */
// add_filter( 'style_loader_tag', 'bfnest_add_preconnect_links_for_typekit', 10, 2 );
function bfnest_add_preconnect_links_for_typekit( $html, $handle ) {
	if ( 'bfnest-typekit' !== $handle ) return $html;
	$pre = '<link rel="preconnect" href="https://use.typekit.net" crossorigin />' . "\n";
	$pre .= '<link rel="preconnect" href="https://p.typekit.net" crossorigin />' . "\n";
	return $pre . $html;
}

/**
 * remove Emoji css and js calls from head
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


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
function bfnest_scripts() {
	$template_directory = get_template_directory_uri();

	// Fetch the version number of the theme, which can be appended on css/js files for debugging/cacheing issues
	$version = bfnest_get_theme_version();
	$suffix = bfnest_is_debug() ? '' : '.min';

	// move jQuery to footer
	wp_script_add_data( 'jquery-core', 'group', 1 );
    wp_script_add_data( 'jquery-migrate', 'group', 1 );
	wp_script_add_data( 'jquery', 'group', 1 );

	// Enqueue styles.
	wp_enqueue_style( 'bfnest-style', $template_directory . '/css/theme' . $suffix . '.css', [], $version );

	// Enqueue scripts.
	// if using jQuery, add 'jquery' to dependencies array
	wp_enqueue_script( 'bfnest-scripts', $template_directory . '/js/theme' . $suffix . '.js', [], $version, true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'bfnest_scripts' );

/**
 * Head scripts - script and link tags to add to head
 */
function bfnest_head_scripts() {
	$template_directory = get_template_directory_uri();

	$fonts = [];
	foreach ( $fonts as $font ) {
		echo '<link rel="preload" as="font" href="' . esc_url( $template_directory . '/fonts/' . $font . '.woff2' ) . '" type="font/woff2" crossorigin="anonymous">' . "\n";
	}
	// paste <script> tags within function
?>
<?php
}
add_action( 'wp_head', 'bfnest_head_scripts' );

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
function bfnest_body_open_scripts() {
?>
<script>document.body.classList.remove('no-js');</script>
<?php
}
add_action( 'wp_body_open', 'bfnest_body_open_scripts' );

/**
 * Remove jQuery migrate and move jQuery to footer
 */
function bfnest_remove_jquery_migrate( $scripts ) {
    if ( !is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];

        if ( $script->deps ) {
            $script->deps = array_diff( $script->deps, [ 'jquery-migrate' ] );
        }
    }
}
add_action( 'wp_default_scripts', 'bfnest_remove_jquery_migrate' );

/**
 * remove Emoji css and js calls from head
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


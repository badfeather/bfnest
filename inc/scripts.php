<?php
/**
 * Enqueue scripts and styles
 */
function nest_scripts() {
	$template_directory = get_template_directory_uri();
	/**
	 * If WP is in script debug, or we pass ?script_debug in a URL - set debug to true.
	 */
	$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) || ( isset( $_GET['script_debug'] ) ) ? true : false;

	/**
	 * If we are debugging the site, use a unique version every page load so as to ensure no cache issues.
	 */
	$my_theme = wp_get_theme();
	$version = $my_theme->get( 'Version' );

	/**
	 * Should we load minified files?
	 */
	$suffix = ( true === $debug ) ? '' : '.min';

	// Enqueue styles.
	wp_enqueue_style( 'nest-style', $template_directory . '/style' . $suffix . '.css', array(), $version );

	// Enqueue scripts.
	wp_enqueue_script( 'nest-scripts', $template_directory . '/assets/js/build/theme' . $suffix . '.js', array( 'jquery' ), $version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'nest_scripts' );

/**
 * Header scripts - any external scripts that should be loaded in the <head> via wp_head(), ie. analytics, typekit, favicons, polyfills, etc.
 */
function nest_header_scripts() {
	$template_directory = get_template_directory_uri();
	// paste <script> tags within function
?>
<link rel="shortcut icon" href="<?php echo esc_url( $template_directory . '/assets/img/favicon.ico' ); ?>">
<link rel="apple-touch-icon" href="<?php echo esc_url( $template_directory . '/assets/img/apple-touch-icon.png' ); ?>" />
<?php
} // close function
add_action( 'wp_head', 'nest_header_scripts' );

/**
 * Footer scripts - any external scripts that should be loaded at the bottom of the <body> via wp_footer()
 */
function nest_footer_scripts() {
	$template_directory = get_template_directory_uri();
	// paste <script> tags within function
?>

<?php
} // close function
add_action( 'wp_footer', 'nest_footer_scripts' );

/**
 * Scripts to include immediately after opening body tag
 * Utilizes 'body-before-scripts' action hook
 */
function nest_body_before_scripts() {
?>
<?php
}
add_action( 'body-before-scripts', 'nest_body_before_scripts' );

/**
 * Add SVG definitions immediately after opening body tag
 * Utilizes 'body-before-scripts' action hook
 */
function nest_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/img/svg-icons.svg';

	// If it exsists, include it.
	if ( file_exists( $svg_icons ) ) {
		echo '<span class="svg-defs">';
		require_once( $svg_icons );
		echo '</span>' . "\n";
	}
}
add_action( 'body-before-scripts', 'nest_include_svg_icons' );

/**
 * remove Emoji css and js calls from head
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


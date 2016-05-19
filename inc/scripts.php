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
	wp_enqueue_style( 'nest-style', get_stylesheet_directory_uri() . '/style' . $suffix . '.css', array(), $version );

	// Enqueue scripts.
	wp_enqueue_script( 'nest-scripts', $template_directory . '/assets/js/project' . $suffix . '.js', array( 'jquery' ), $version, true );

	wp_enqueue_script( 'nest-modernizr', $template_directory . '/assets/js/modernizr' . $suffix . '.js', array(), $version, false );

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
	// paste <script> tags within function
?>

<?php
} // close function
add_action( 'wp_footer', 'nest_footer_scripts' );

/**
 * Add SVG definitions to <head>.
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

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

	// Load non-minified files if 'SCRIPT_DEBUG' is set to TRUE, otherwise, use minified files in production
	$debug = bfnest_is_debug();
	$suffix = ( true === $debug ) ? '' : '.min';
	
	// Fetch the version number of the theme, which can be appended on css/js files for debugging/cacheing issues
	$version = bfnest_get_theme_version();	

	// Enqueue styles.
	wp_enqueue_style( 'bfnest-style', $template_directory . '/assets/dist/css/theme' . $suffix . '.css', array(), $version );

	// Enqueue scripts.
	wp_enqueue_script( 'bfnest-scripts', $template_directory . '/assets/dist/js/build/theme' . $suffix . '.js', array( 'jquery' ), $version, true );
	
	// Dequeue Gutenberg CSS on front-end
	//wp_dequeue_style( 'wp-block-library' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'bfnest_scripts' );

/**
 * Registers an editor stylesheet for the theme.
 */
function bfnest_editor_style() {
	$debug = bfnest_is_debug();
	$suffix = ( true === $debug ) ? '' : '.min';
    add_editor_style( get_template_directory_uri() . '/assets/dist/css/editor-style' . $suffix . '.css' );
}
add_action( 'admin_init', 'bfnest_editor_style' );

/**
* Enqueue editor styles for Gutenberg
*/
// 
//function bfnest_block_editor_style() {
//	$debug = bfnest_is_debug();
//	$suffix = ( true === $debug ) ? '' : '.min';
//	$version = bfnest_get_theme_version();	
//	
//    wp_enqueue_style( 'bfnest-block-editor-style', get_template_directory_uri() . '/assets/dist/css/block-editor' . $suffix . '.css', array(), $version );
//}
//add_action( 'enqueue_block_editor_assets', 'bfnest_block_editor_style' );

/**
 * Header scripts - any external scripts that should be loaded in the <head> via wp_head(), ie. analytics, typekit, favicons, polyfills, etc.
 */
function bfnest_header_scripts() {
	$template_directory = get_template_directory_uri();
	// paste <script> tags within function
?>
<link rel="shortcut icon" href="<?php echo esc_url( $template_directory . '/assets/dist/img/favicon.ico' ); ?>">
<link rel="apple-touch-icon" href="<?php echo esc_url( $template_directory . '/assets/dist/img/apple-touch-icon.png' ); ?>" />
<?php
} // close function
add_action( 'wp_head', 'bfnest_header_scripts' );

/**
 * Footer scripts - any external scripts that should be loaded at the bottom of the <body> via wp_footer()
 */
function bfnest_footer_scripts() {
	$template_directory = get_template_directory_uri();
	// paste <script> tags within function
?>

<?php
} // close function
add_action( 'wp_footer', 'bfnest_footer_scripts' );

/**
 * Scripts to include immediately after opening body tag
 * Utilizes 'body-before-scripts' action hook
 */
function bfnest_body_before_scripts() {
?>
<?php
}
add_action( 'body-before-scripts', 'bfnest_body_before_scripts' );

/**
 * Add SVG definitions immediately after opening body tag
 * Utilizes 'body-before-scripts' action hook
 */
function bfnest_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/dist/img/svg-icons.svg';

	// If it exsists, include it.
	if ( file_exists( $svg_icons ) ) {
		echo '<span class="svg-defs">';
		get_template_part( $svg_icons );
		echo '</span>' . "\n";
	}
}
add_action( 'body-before-scripts', 'bfnest_include_svg_icons' );

/**
 * Load Jquery in footer
 */
function bfnest_move_jquery_to_footer( $wp_scripts ) {
	if( is_admin() ) {
		return;
	}
	$wp_scripts->add_data( 'jquery', 'group', 1 );
	$wp_scripts->add_data( 'jquery-core', 'group', 1 );
	$wp_scripts->add_data( 'jquery-migrate', 'group', 1 );
}
add_action( 'wp_default_scripts', 'bfnest_move_jquery_to_footer' );

/**
 * remove Emoji css and js calls from head
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


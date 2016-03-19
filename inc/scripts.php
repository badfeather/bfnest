<?php
/**
 * Enqueue scripts and styles
 */
function nest_scripts() {
	$template_directory = get_template_directory_uri();

	wp_enqueue_style( 'nest-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'nest-modernizr', $template_directory . '/js/modernizr.min.js', array(), null, false );

	// Scripts file. Use gruntfile.php to prepend any required plugins, which hopefully are included via bower. Comment/uncomment for prod/dev versions.
	//wp_enqueue_script( 'nest-scripts-dev', $template_directory . '/js/scripts.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'nest-scripts', $template_directory . '/js/scripts.min.js', array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'nest_scripts' );

/**
 * Header scripts - any external scripts that should be loaded in the <head> via wp_head(), ie. analytics, typekit, favicons, polyfills, etc.
 */
function nest_header_scripts() {
	$template_directory = get_template_directory_uri();
	// paste <script> tags within function
?>
<link rel="shortcut icon" href="<?php echo esc_url( $template_directory . '/img/favicon.ico' ); ?>">
<link rel="apple-touch-icon" href="<?php echo esc_url( $template_directory . '/img/apple-touch-icon.png' ); ?>" />
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

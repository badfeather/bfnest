<?php
/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'nest_scripts' );

function nest_scripts() {
	wp_enqueue_style( 'nest-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'nest-modernizr', get_template_directory_uri() . '/js/modernizr.min.js', array(), null, false );

	// use grunt to prepend any required plugins, which hopefully are available via bower
	//wp_enqueue_script( 'nest-scripts-dev', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'nest-scripts', get_template_directory_uri() . '/js/scripts.min.js', array( 'jquery' ), null, true );
}

/**
 * Header scripts - any external scripts that should be loaded in the <head> via wp_head(), ie. analytics, typekit, favicons, polyfills, etc.
 */
add_action( 'wp_head', 'nest_header_scripts' );

// paste <script> tags within function
function nest_header_scripts() {
	$template_directory = get_template_directory_uri();
?>
<link rel="shortcut icon" href="<?php echo esc_url( $template_directory . '/img/favicon.ico' ); ?>">
<link rel="apple-touch-icon" href="<?php echo esc_url( $template_directory . '/img/apple-touch-icon.png' ); ?>" />
<?php }

/**
 * Footer scripts - any external scripts that should be loaded at the bottom of the <body> via wp_footer()
 */
add_action( 'wp_footer', 'nest_footer_scripts' );

// paste <script> tags within function
function nest_footer_scripts() { ?>

<?php } // function bf_header_scripts

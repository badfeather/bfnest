<?php
/**
 * Enqueue scripts and styles
 */
function _bfn_scripts() {
	wp_enqueue_style( 'bfn-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}



}
add_action( 'wp_enqueue_scripts', '_bfn_scripts' );

/**
 * Enqueue scripts and styles
 */
function bfn_scripts() {
	wp_enqueue_style( 'bfn-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'bfn-modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', array(), null, false );

	wp_enqueue_script( 'bfn-plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'bfn-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'bfn-plugins' ), null, true );

}
add_action( 'wp_enqueue_scripts', 'bfn_scripts' );

/**
 * Header scripts - async external scripts and IE-conditional scripts
 */
add_action( 'wp_head', 'bfn_header_scripts' );

// paste any <script> tags, ie. typekit, google analytics, etc that you'd like to go in the header within the function area
function bf_header_scripts() { ?>

<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/respond-1.4.1.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-1.0.2.	min.js"></script>
<![endif]-->
<?php } // function bf_header_scripts

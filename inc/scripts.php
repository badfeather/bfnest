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

	// including modernizr and whatever else you might need via codekit prepend, calling from bower_components
	wp_enqueue_script( 'bfn-vendor', get_template_directory_uri() . '/js/min/vendor-ck.js', array(), null, false );

	// use codekit to prepend any required plugins, which hopefully are available via bower
	wp_enqueue_script( 'bfn-scripts', get_template_directory_uri() . '/js/min/scripts-ck.js', array( 'jquery' ), null, true );

}
add_action( 'wp_enqueue_scripts', 'bfn_scripts' );

/**
 * Header scripts - async external scripts and IE-conditional scripts
 */
add_action( 'wp_head', 'bfn_header_scripts' );

// paste any <script> tags, ie. polyfills typekit, google analytics, etc that you'd like to go in the header within the function area
// ie conditional script include is calling compiled combo of selectivizr.js and respond.js from bower_components
function bfn_header_scripts() { ?>

<!--[if (gte IE 6)&(lte IE 8)]>
  <script src="<?php echo get_template_directory_uri(); ?>/js/min/ie-polyfills-ck.js"></script>
<![endif]-->
<?php } // function bf_header_scripts

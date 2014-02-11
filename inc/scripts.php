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
function bfn_header_scripts( $gag = '', $tkid = '' ) {
	if ( $tkid ) {
?>
<script type="text/javascript">
  (function() {
    var config = {
      kitId: <?php echo $tkid; ?>,
      scriptTimeout: 3000
    };
    var h=document.getElementsByTagName("html")[0];h.className+=" wf-loading";var t=setTimeout(function(){h.className=h.className.replace(/(\s|^)wf-loading(\s|$)/g," ");h.className+=" wf-inactive"},config.scriptTimeout);var tk=document.createElement("script"),d=false;tk.src='//use.typekit.net/'+config.kitId+'.js';tk.type="text/javascript";tk.async="true";tk.onload=tk.onreadystatechange=function(){var a=this.readyState;if(d||a&&a!="complete"&&a!="loaded")return;d=true;clearTimeout(t);try{Typekit.load(config)}catch(b){}};var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(tk,s)
  })();
</script>
<?php
	} // endif $tkid
	if ( $gag ) {
?>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', <?php echo $gag; ?>);
ga('send', 'pageview');
</script>
<?php
	} // endif $gag
?>
<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/respond-1.4.1.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-1.0.2.	min.js"></script>
<![endif]-->
<?php } // function bfn_header_scripts

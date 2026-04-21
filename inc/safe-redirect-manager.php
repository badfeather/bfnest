<?php
add_filter( 'srm_max_redirects',
	/**
	 * Up limit for wp safe redirect plugin
	 */
	function() {
		return 1000;
	}
);


add_filter(
	'srm_default_direct_status',
	/**
	 * Set the default redirect status to 301 (Moved Permanently).
	 */
	function() {
		return 301;
	}
);

add_filter( 'srm_redirect_only_on_404', '__return_true' );

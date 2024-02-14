<?php
/**
 * Move Yoast meta box to bottom
 */
add_filter( 'wpseo_metabox_prio', 'bfnest_yoast_to_bottom' );
function bfnest_yoast_to_bottom() {
	return 'low';
}

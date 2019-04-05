<?php

/**
 * Returns mailto link, where the linked text is the email address enclosed in the shortcode
 * Example usage: [email]you@you.com[/email]
 */
function bfnest_get_encoded_email_link( $atts, $content ) {
	return '<a href="'. antispambot( 'mailto:'. $content ) .'">'. antispambot( $content ) .'</a>';
}
add_shortcode( 'email', 'bfnest_get_encoded_email_link' );

/**
 * Returns the encoded mailto address only
 * For use with links having custom text (not the email address) as the linked text
 * Example usage: <a href="[mailto]you@you.com[/mailto]">Example link</a>
 */
function bfnest_get_encoded_email_url( $atts, $content ) {
	return antispambot( 'mailto:'. $content );
}
add_shortcode( 'mailto', 'bfnest_get_encoded_email_url' );



<?php 
/**
 * Get BEM classes
 * Accepts 2 arguments:
 * $blocks (required) expects an array, e.g. array( 'doc', doc--standard' )
 * $element (optional) expects child element string, e.g. 'title'
 */
function bfnest_get_bem_classes( $blocks = array(), $element = '' ) {
	if ( empty( $blocks ) ) {
		return false;
	}
	
	$element_suffix = $element ? '__' . $element : '';
	
	$classes_array = array();
	
	foreach ( $blocks as $block ) {
		$classes_array[] = $block . $element_suffix;
	} 
	
	return esc_attr( implode( ' ', array_filter( $classes_array ) ) );
}

/**
 * Echo BEM classes
 * Uses bfnest_get_bem_classes()
 */
function bfnest_bem_classes( $blocks = array(), $element = '' ) {
	echo bfnest_get_bem_classes( $blocks, $element );
}
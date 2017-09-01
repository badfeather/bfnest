<?php

/**
 * Postnav single
 */
function nest_postnav_single( $in_same_term = false, $excluded_terms = array(), $taxonomy = 'category', $newer_title = '&larr; %title', $older_title = '%title &rarr;' ) {
	if ( ! is_single() ) {
		return false;
	}

	$newer = get_next_post_link( '<div class="postnav__link postnav__link--newer">%link</div>', $newer_title, $in_same_term, $excluded_terms, $taxonomy );
	$older = get_previous_post_link( '<div class="postnav__link postnav__link--older">%link</div>', $older_title, $in_same_term, $excluded_terms, $taxonomy );
	$postnav = array();

	if ( $newer ) {
		$postnav[] = $newer;
	}

	if ( $older ) {
		$postnav[] = $older;
	}

	if ( ! empty( $postnav ) ) {
		echo '<nav class="postnav doc--single__postnav">' . "\n" . implode( '', $postnav ) . '</nav>';
	}
}

/**
 * Postnav archives
 */
function nest_postnav_archive( $newer_title = null, $older_title = null ) {
	if ( ! is_archive() ) {
		return false;
	}

	if ( null === $newer_title ) {
		$newer_title = __( '&larr; Newer Entries', 'nest' );
	}

	if ( null === $older_title ) {
		$older_title =	__( 'Older Entries &rarr;', 'nest' );
	}

	$newer = get_previous_posts_link( $newer_title );
	$older = get_next_posts_link( $older_title );
	$postnav = array();

	if ( $newer ) {
		$postnav[] = '<div class="postnav__link postnav__link--newer">' . $newer . '</div>' . "\n";
	}

	if ( $older ) {
		$postnav[] = '<div class="postnav__link postnav__link--older">' . $older . '</div>' . "\n";
	}

	if ( ! empty( $postnav ) ) {
		echo '<nav class="postnav doc--archive__postnav">' . "\n" . implode( '', $postnav ) . '</nav>';
	}
}

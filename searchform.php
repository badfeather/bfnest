<?php
$svg = bfnest_get_svg( get_template_directory_uri() . '/img/ui-icons/search.svg' );
$button_before = $button_after = $button_add_class = '';
if ( $svg ) {
	$button_before = '<span class="search-icon" aria-hidden="true">' . $svg . '</span><span class="sr-only">';
	$button_after = '</span>';
	$button_add_class = ' . button--icon';
}
$form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '">' . "\n";
$form .= '<div class="form-row row--inline">' . "\n";
$form .= '<div class="col--auto">' . "\n";
$form .= '<input type="search" class="search-field input" placeholder="' . esc_attr_x( 'Search for: ', 'placeholder', 'bfnest' ) . '" value="' . get_search_query() . '" name="s" aria-label="' . esc_attr_x( 'Search for: ', 'aria-label', 'bfnest' ) . '" />' . "\n";
$form .= '</div>' . "\n";
$form .= '<div class="col--auto">' . "\n";
$form .= '<button type="submit" class="search-submit btn' . $button_add_class . '">' . $button_before . esc_html( __( 'Search', 'bfnest' ) ) . $button_after . '</button>' . "\n";
$form .= '</div>' . "\n";
$form .= '</div>' . "\n";
$form .= '</form>' . "\n";
echo $form;

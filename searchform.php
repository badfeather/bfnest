<?php
$svg = bfnest_get_svg( get_template_directory_uri() . '/img/ui-icons/search.svg' );
$button_before = $button_after = $button_add_class = '';
if ( $svg ) {
	$button_before = '<span class="search-icon" aria-hidden="true">' . $svg . '</span><span class="visually-hidden">';
	$button_after = '</span>';
	$button_add_class = ' . button--icon';
}
?>
<form role="search" method="get" class="search-form row row--inline row--form" action="<?php echo home_url( '/' ); ?>">
	<div>
		<input type="search" class="search-field input input--constrained" placeholder="<?php echo esc_attr_x( 'Search for: ', 'placeholder', 'bfnest' ); ?>" value="<?php echo get_search_query(); ?>" name="s" aria-label="<?php echo esc_attr_x( 'Search for: ', 'aria-label', 'bfnest' ); ?>" />
	</div>
	<div>
		<button type="submit" class="search-submit btn<?php echo esc_attr( $button_add_class ); ?>"><?php echo $button_before . esc_html( __( 'Search', 'bfnest' ) ) . $button_after; ?></button>
	</div>
</form>

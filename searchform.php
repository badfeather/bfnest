<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="form-row--inline">
		<label for="s" class="sr-only">Search</label>
		<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search for: ', 'placeholder', 'bfnest' ) ?>" value="<?php echo get_search_query() ?>" name="s" id="s" />

		<input type="submit" class="search-submit button" value="<?php echo esc_attr_x( 'Search', 'submit button', 'bfnest' ) ?>" />
	</div>
</form>

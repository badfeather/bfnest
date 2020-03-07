wp.domReady( function() {
	wp.blocks.unregisterBlockType( 'core/archives' );
	wp.blocks.unregisterBlockType( 'core/categories' );
	wp.blocks.unregisterBlockType( 'core/calendar' );
	wp.blocks.unregisterBlockType( 'core/tag-cloud' );
	wp.blocks.unregisterBlockType( 'core/rss' );
	wp.blocks.unregisterBlockType( 'core/verse' );
	wp.blocks.unregisterBlockType( 'core/latest-comments' );
	wp.blocks.unregisterBlockType( 'core/latest-posts' );
	wp.blocks.unregisterBlockType( 'core/social-links' );

	wp.blocks.unregisterBlockStyle( 'core/quote', 'default' );
	wp.blocks.unregisterBlockStyle( 'core/quote', 'large' );
	wp.blocks.unregisterBlockStyle( 'core/button', [ 'default', 'outline', 'squared', 'fill' ] ),
	wp.blocks.unregisterBlockStyle( 'core/pullquote', 'solid-color' );
	wp.blocks.unregisterBlockStyle( 'core/separator', [ 'default', 'wide', 'dots' ] );
	//wp.blocks.unregisterBlockStyle( 'core/table', 'stripes' );

	wp.blocks.registerBlockStyle(
		'core/button',
		[
			{
				name: 'default',
				label: 'Default',
				isDefault: true,
			},
			{
				name: 'block',
				label: 'Full Width',
			},
			{
				name: 'outline',
				label: 'Outline',
			},
			{
				name: 'outline-block',
				label: 'Full Width Outline',
			}
		]
	);
} );



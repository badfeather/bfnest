var allowedBlocks = [
	'core/archives',
	'core/audio',
	'core/button',
	'core/categories',
	'core/code',
	'core/column',
	'core/columns',
	'core/coverImage',
	'core/embed',
	'core/file',
	'core/freeform',
	'core/gallery',
	'core/heading',
	'core/html',
	'core/image',
	'core/latestComments',
	'core/latestPosts',
	'core/list',
	'core/more',
	'core/nextpage',
	'core/paragraph',
	'core/preformatted',
	'core/pullquote',
	'core/quote',
	'core/reusableBlock',
	'core/separator',
	'core/shortcode',
	'core/spacer',
	'core/subhead',
	'core/table',
	'core/textColumns'
];

wp.blocks.getBlockTypes().forEach( function( blockType ) {
    if ( allowedBlocks.indexOf( blockType.name ) === -1 ) {
        wp.blocks.unregisterBlockType( blockType.name );
    }
} );

wp.domReady( function() {
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

	wp.blocks.unregisterBlockStyle(
		'core/button',
		[ 'default', 'outline', 'squared', 'fill' ]
	);

	wp.blocks.registerBlockStyle(
		'core/button',
		[
			{
				name: 'default',
				label: 'Default',
				isDefault: true,
			},
			{
				name: 'full',
				label: 'Full Width',
			}
		]
	);



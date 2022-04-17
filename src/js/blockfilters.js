wp.domReady(() => {
	let coreBlocks = wp.blocks.getBlockTypes().filter((block) => {return block.name.indexOf('core') !== -1});
	coreBlocks.sort();
	let blockTypes = [];
	for (let block of coreBlocks) {
		blockTypes.push(block.name);
	}
	// view all registered core blocks
	// console.log(blockTypes.join("\r\n")); // prints list of all core blocks

	// core blocks as of 20220324
	// ---------------------------
	// core/paragraph
	// core/image
	// core/heading
	// core/gallery
	// core/list
	// core/quote
	// core/archives
	// core/audio
	// core/button
	// core/buttons
	// core/calendar
	// core/categories
	// core/freeform
	// core/code
	// core/column
	// core/columns
	// core/cover
	// core/embed
	// core/file
	// core/group
	// core/html
	// core/latest-comments
	// core/latest-posts
	// core/media-text
	// core/missing
	// core/more
	// core/nextpage
	// core/page-list
	// core/pattern
	// core/preformatted
	// core/pullquote
	// core/block
	// core/rss
	// core/search
	// core/separator
	// core/shortcode
	// core/social-link
	// core/social-links
	// core/spacer
	// core/table
	// core/tag-cloud
	// core/text-columns
	// core/verse
	// core/video
	// core/navigation
	// core/navigation-link
	// core/navigation-submenu
	// core/site-logo
	// core/site-title
	// core/site-tagline
	// core/query
	// core/template-part
	// core/post-title
	// core/post-excerpt
	// core/post-featured-image
	// core/post-content
	// core/post-author
	// core/post-date
	// core/post-terms
	// core/post-navigation-link
	// core/post-template
	// core/query-pagination
	// core/query-pagination-next
	// core/query-pagination-numbers
	// core/query-pagination-previous
	// core/post-comments
	// core/loginout
	// core/term-description
	// core/query-title

	let allowedTypes = [
		'core/audio',
		'core/block',
		'core/button',
		'core/buttons',
		'core/code',
		'core/column',
		'core/columns',
		'core/embed',
		'core/file',
		'core/gallery',
		'core/group',
		'core/heading',
		'core/html',
		'core/image',
		'core/list',
		'core/paragraph',
		'core/preformatted',
		'core/pullquote',
		'core/quote',
		'core/separator',
		'core/shortcode',
		'core/spacer',
		'core/table',
		'core/textColumns',
		'core/video'
	];

	// unregister all blocks not in allowedTypes
	coreBlocks.forEach(function (block) {
		if (!allowedTypes.includes(block.name)) {
			wp.blocks.unregisterBlockType(block.name);
		}
	});

	// unregister block styles on all blocks
	coreBlocks.forEach(function (block) {
		let styles = block.styles;
		if (!styles.length) return;
		// console.log(JSON.stringify(styles));

		for (let style of styles) {
			wp.blocks.unregisterBlockStyle(block.name, style.name);
		}
	});
});

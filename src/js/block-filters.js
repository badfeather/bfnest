wp.domReady(() => {
	let coreBlocks = wp.blocks.getBlockTypes().filter((block) => {return block.name.indexOf('core') !== -1});
	let blockTypes = [];
	for (let block of coreBlocks) {
		blockTypes.push(block.name);
	}

	// list all registered core blocks in console
	console.log("'" + blockTypes.sort().join("',\r\n'") + "'");

	// core blocks from gutenberg 22.8.0
	let allowedTypes = [
		// 'core/accordion',
		// 'core/accordion-heading',
		// 'core/accordion-item',
		// 'core/accordion-panel',
		// 'core/archives',
		'core/audio',
		// 'core/avatar',
		// 'core/block',
		'core/button',
		'core/buttons',
		// 'core/calendar',
		// 'core/categories',
		'core/code',
		'core/column',
		'core/columns',
		// 'core/comment-author-name',
		// 'core/comment-content',
		// 'core/comment-date',
		// 'core/comment-edit-link',
		// 'core/comment-reply-link',
		// 'core/comment-template',
		// 'core/comments',
		// 'core/comments-pagination',
		// 'core/comments-pagination-next',
		// 'core/comments-pagination-numbers',
		// 'core/comments-pagination-previous',
		// 'core/comments-title',
		'core/cover',
		'core/details',
		'core/embed',
		'core/file',
		'core/footnotes',
		'core/freeform',
		'core/gallery',
		'core/group',
		// 'core/heading',
		// 'core/home-link',
		'core/html',
		'core/image',
		// 'core/latest-comments',
		// 'core/latest-posts',
		// 'core/legacy-widget',
		'core/list',
		'core/list-item',
		// 'core/loginout',
		'core/math',
		'core/media-text',
		'core/missing',
		// 'core/more',
		// 'core/navigation',
		// 'core/navigation-link',
		// 'core/navigation-submenu',
		// 'core/nextpage',
		// 'core/page-list',
		// 'core/page-list-item',
		'core/paragraph',
		// 'core/pattern',
		// 'core/post-author',
		// 'core/post-author-biography',
		// 'core/post-author-name',
		// 'core/post-comments-count',
		// 'core/post-comments-form',
		// 'core/post-comments-link',
		// 'core/post-content',
		// 'core/post-date',
		// 'core/post-excerpt',
		// 'core/post-featured-image',
		// 'core/post-navigation-link',
		// 'core/post-template',
		// 'core/post-terms',
		// 'core/post-time-to-read',
		// 'core/post-title',
		'core/preformatted',
		'core/pullquote',
		// 'core/query',
		// 'core/query-no-results',
		// 'core/query-pagination',
		// 'core/query-pagination-next',
		// 'core/query-pagination-numbers',
		// 'core/query-pagination-previous',
		// 'core/query-title',
		// 'core/query-total',
		'core/quote',
		'core/read-more',
		// 'core/rss',
		// 'core/search',
		'core/separator',
		'core/shortcode',
		// 'core/site-logo',
		// 'core/site-tagline',
		// 'core/site-title',
		// 'core/social-link',
		// 'core/social-links',
		'core/spacer',
		'core/table',
		// 'core/tag-cloud',
		// 'core/template-part',
		// 'core/term-count',
		// 'core/term-description',
		// 'core/term-name',
		// 'core/term-template',
		// 'core/terms-query',
		'core/text-columns',
		// 'core/verse',
		'core/video',
		// 'core/widget-group'
	];



	// unregister block styles on all blocks
	coreBlocks.forEach(function (block) {
		let styles = block.styles;
		if (!styles.length) return;
		console.log([block.name, JSON.stringify(styles)]);

		// nuclear option: unregister all styles
		// for (let style of styles) {
		// 	wp.blocks.unregisterBlockStyle(block.name, style.name);
		// }
	});

	// unregister specific blocks\ styles
	wp.blocks.unregisterBlockStyle('core/image', ['rounded']);
	wp.blocks.unregisterBlockStyle('core/quote', ['plain']);
	wp.blocks.unregisterBlockStyle('core/button', ['outline']);
	wp.blocks.unregisterBlockStyle('core/table', ['stripes']);

	// unregister all blocks not in allowedTypes
	coreBlocks.forEach(function (block) {
		if (!allowedTypes.includes(block.name)) {
			wp.blocks.unregisterBlockType(block.name);
		}
	});
});

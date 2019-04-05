/**
 * File share-popup.js.
 *
 * Opens share links in new popup window
 */
( function() {

	
	var shareLinks = document.querySelectorAll('.share-link:not(.share-link-email)');
	if ( ! shareLinks ) {
		return;
	}

	[].forEach.call(shareLinks, function(anchor) {
		anchor.addEventListener('click', function(e) {

			var url = this.href,
				width = 500,
				height = 300,
				left = (screen.width / 2) - (width / 2),
				top = (screen.height / 2) - (height / 2);

			if(/^(f|ht)tps?:\/\//i.test(url) || /^mailto/i.test(url)) {
				e.preventDefault();
				window.open(
					url,
					'',
					'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=' + width + ',height=' + height + ',top=' + top + ',left=' + left
				);
			}

		});
	});
} )();
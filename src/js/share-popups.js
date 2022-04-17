/**
 * Opens share links in new popup window
 */
function sharePopups() {
	const links = document.querySelectorAll('.share-link:not(.share-link-email)');
	if (!links.length) return;

	function popup(event) {
		if (!event.target.closest('.share-link:not(.share-link-email)')) return;
		const url = this.href;
		if (!/^(f|ht)tps?:\/\//i.test(url) && !/^mailto/i.test(url)) return;
		event.preventDefault();
		const w = 500;
		const h = 300;
		const left = ( screen.width / 2 ) - ( w / 2 );
		const top = ( screen.height / 2 ) - ( h / 2 );
		window.open(
			url,
			'',
			'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=' + w + ',height=' + h + ',top=' + top + ',left=' + left
		);

	}

	document.addEventListener('click', popup, false);
}

document.addEventListener('DOMContentLoaded', sharePopups, false);


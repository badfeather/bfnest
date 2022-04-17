( function() {
	let btn = document.querySelector('[data-toggle-color-scheme]');
	if (!btn) return;
	let prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
	let localScheme = localStorage.getItem('color-scheme');
	let scheme = document.body.getAttribute('data-color-scheme');
	scheme = scheme ? scheme : 'light';
	if (localScheme) {
		scheme = localScheme;

	} else if (prefersDark.matches) {
		scheme = 'dark';
	}
	btn.setAttribute('data-toggle-color-scheme', scheme);
	document.body.setAttribute('data-color-scheme', scheme);

	function toggleScheme (event) {
		let btn = event.target.closest('[data-toggle-color-scheme]');
		if (!btn) return;
		if (scheme === 'dark') {
			scheme = 'light';
		} else {
			scheme = 'dark';
		}
		btn.setAttribute('data-toggle-color-scheme', scheme);
		document.body.setAttribute('data-color-scheme', scheme);
		localStorage.setItem('color-scheme', scheme);
	}
	document.addEventListener('click', toggleScheme, false);
} )();

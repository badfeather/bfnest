/**
 * Toggle 'focus' class on menu links on focus/blur events
 * Toggle 'focus' and preventDefault on parent menu item touch events
 */
( function() {
	let links = document.querySelectorAll('.menu-item a');
	if (!links.length) return;
	let menus = document.querySelectorAll('.menu');

	function toggleFocus (event) {
		let link = event.target.closest('.menu-item a');
		if (!link) return;
		let item = link.closest('.menu-item');
		let menu = link.closest('.menu');
		if (!item || !menu) return;
		let items = menu.querySelectorAll('.menu-item');
		item.classList.toggle('focus');

		if (!event.type === 'touchstart') return;
		if (item.classList.contains('menu-item-has-children') || item.classList.contains('page_item_has_children')) {
			event.preventDefault();

			for (let li of items) {
				if (li === item) continue;
				li.classList.remove('focus');
			}
		}
	}
	for (let menu of menus) {
		menu.addEventListener('focus', toggleFocus, true);
		menu.addEventListener('blur', toggleFocus, true);
		menu.addEventListener('touchstart', toggleFocus, false);
	}
} )();

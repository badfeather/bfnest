function setupExpanderMenu(menu) {
	// Select only the direct <li> children that actually have a submenu
	// const parents = menu.querySelectorAll('li:has(> ul)');
	const parents = [];
	const submenus = menu.querySelectorAll('ul');
	for (const submenu of submenus) {
		parents.push(submenu.parentElement);
	}

	parents.forEach((li) => {
		const submenu = li.querySelector('ul');
		const link = li.querySelector(':scope > a');
		if (!submenu || !link) return;

		// 1. Ensure the submenu has a unique ID
		submenu.id ||= li.id ? `${li.id}_submenu` : `expander-${crypto.randomUUID()}`;

		// 2. Create the btn button
		const btn = document.createElement('button');
		btn.classList.add('btn--link');
		btn.dataset.expand = submenu.id;
		btn.classList.add('expander-toggle');

		const linkHref = link.getAttribute('href');
		const isPlaceholder = !linkHref || linkHref === '#';

		if (isPlaceholder) {
	    	// Transfer all attributes (except href) from link to button
	  	  	[...link.attributes].forEach(attr => {
				if (attr.name !== 'href') btn.setAttribute(attr.name, attr.value);
			});
			btn.innerHTML = link.innerHTML.trim();
			link.replaceWith(btn);
		} else {
			// Link is a real URL: add a separate button
			btn.ariaLabel = `Toggle ${link.textContent.trim()} submenu`;
			li.append(btn);
		}
	});
}

const menu = document.getElementById('primary-menu');
if (menu) setupExpanderMenu(menu);

export { setupExpanderMenu }




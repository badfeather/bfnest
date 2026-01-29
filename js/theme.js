(function () {
	'use strict';

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

	class Expander {
		constructor(button, options = {}) {
			const contentId = button.getAttribute('data-expand');
			this.content = document.getElementById(contentId);
			if (!this.content) return;

			this.button = button;
			this.parent = button.parentElement;
			this.settings = Object.freeze({ collapseOnOutsideClick: true, ...options });

			this.init();
		}

		get isOpen() {
			return this.button.getAttribute('aria-expanded') === 'true';
		}

		set isOpen(value) {
			this.button.setAttribute('aria-expanded', !!value);
			this.content.setAttribute('aria-hidden', !value);
		}

		init() {
			this.button.setAttribute('aria-controls', this.content.id);
			this.isOpen = false; // Initial state

			document.addEventListener('click', this.handleEvents);
			this.parent.addEventListener('keydown', this.handleEvents);
			this.parent.addEventListener('focusout', this.handleEvents);
		}

		handleEvents = (e) => {
			// 1. Handle Escape key
			if (e.type === 'keydown' && e.key === 'Escape' && this.isOpen) {
				e.stopPropagation();
				if (this.content.contains(document.activeElement)) {
					this.button.focus();
				}
				this.isOpen = false;
			}

			// 2. Handle Clicks (Toggle or Outside Click)
			if (e.type === 'click') {
				if (this.button.contains(e.target)) {
					this.isOpen = !this.isOpen;
				} else if (this.settings.collapseOnOutsideClick && !this.parent.contains(e.target)) {
					this.isOpen = false;
				}
			}

			// 3. Handle Focus Leaving the component (Replaces Blur)
			if (e.type === 'focusout' && e.relatedTarget && !this.parent.contains(e.relatedTarget)) {
				this.isOpen = false;
			}
		}
	}

	function instantiateExpanders () {
		const expanders = document.querySelectorAll('[data-expand]');
		if (!expanders.length) return;
		for (const expander of expanders) {
			new Expander(expander);
		}
	}
	instantiateExpanders();

})();
//# sourceMappingURL=theme.js.map

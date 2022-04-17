import emitEvent from './events.js';

function isPrintableChar (str) {
	return str.length === 1 && str.match(/\S/);
}

// TODO - test (natch), add hover/click focus classes
/**
 * For WP Nav items, use:
 * let itemSelector = '.menu-item a';
 *
 * For all focusable elements, use:
 * let itemSelector = [
 * 	'a[href]:not([tabindex^="-"])',
 * 	'area[href]:not([tabindex^="-"])',
 * 	'input:not([type="hidden"]):not([type="radio"]):not([disabled]):not([tabindex^="-"])',
 * 	'input[type="radio"]:not([disabled]):not([tabindex^="-"])',
 * 	'select:not([disabled]):not([tabindex^="-"])',
 * 	'textarea:not([disabled]):not([tabindex^="-"])',
 * 	'Toggle:not([disabled]):not([tabindex^="-"])',
 * 	'iframe:not([tabindex^="-"])',
 * 	'audio[controls]:not([tabindex^="-"])',
 * 	'video[controls]:not([tabindex^="-"])',
 * 	'[contenteditable]:not([tabindex^="-"])',
 * 	'[tabindex]:not([tabindex^="-"])'
 * ].join(',');
 */
function MenuToggle (toggle, itemSelector = 'a', options = {}) {
	if (!toggle) return;
	if (!(toggle instanceof Element)) {
		throw new Error("No toggle element passed in.");
	}

	let menuId = toggle.getAttribute('data-expand');
	if (!menuId) return;

	let menu = document.getElementById(menuId);
	if (!menu) return;

	let settings = Object.assign({
		setMaxHeight: false,
		setAriaHidden: true,
		onOutsideClick: false,
		shiftFocus: true,
		accordion: false
	}, options);
	Object.freeze(settings);

	this.toggle = toggle;
	this.menuId = menuId;
	this.menu = menu;
	this.parent = toggle.closest('[data-expand-parent]');
	this.settings = settings;
	this.expanded = menu.getAttribute('data-expand-open') ? true : false;
	this.firstMenuItem = false;
	this.lastMenuItem = false;
	this.currentMenuItem = false;
	this.firstChars = [];
	this.menuItems = [];

	this.expand = this.expand.bind(this);
	this.collapse = this.collapse.bind(this);
	this.setFocusToItem = this.setFocusToItem.bind(this);
	this.setFocusToFirstItem = this.setFocusToFirstItem.bind(this);
	this.setFocusToLastItem = this.setFocusToLastItem.bind(this);
	this.setFocusToPrevItem = this.setFocusToPrevItem.bind(this);
	this.setFocusToNextItem = this.setFocusToNextItem.bind(this);
	this.setFocusByFirstChar = this.setFocusByFirstChar.bind(this);
	this.onOutsideClick = this.onOutsideClick.bind(this);
	this.onToggleClick = this.onToggleClick.bind(this);
	this.onToggleKeydown = this.onToggleKeydown.bind(this);
	this.onMenuKeydown = this.onMenuKeydown.bind(this);

	let menuItems = menu.querySelectorAll(itemSelector);
	if (menuItems.length) {
		for (let menuItem of menuItems) {
			this.menuItems.push(menuItem);
			menuItem.tabIndex = -1;
			this.firstChars.push(menuItem.textContent.trim()[0].toLowerCase());
			if (!this.firstMenuItem) this.firstMenuItem = menuItem;
			this.lastMenuItem = menuItem;
		}
	}

	this.toggle.setAttribute('aria-controls', this.menuId);
	this.menu.hasAttribute('aria-labelledby') || this.menu.setAttribute('aria-label', this.toggle.innerText);

	if (this.expanded) {
		this.expand();

	} else {
		this.collapse();
	}

	this.toggle.addEventListener('click', this.onToggleClick, false);
	this.toggle.addEventListener('keydown', this.onToggleKeydown, false);

	if (this.parent && this.settings.onOutsideClick) {
		document.addEventListener('click', this.onOutsideClick, false);
	}

	emitEvent('MenuToggle:ready', {
		MenuToggle: this,
		expanded: this.expanded
	});
}

MenuToggle.prototype.expand = function () {
	this.toggle.setAttribute('aria-expanded', 'true');
	if (this.parent) this.parent.setAttribute('aria-expanded', 'true');
	if (this.settings.setAriaHidden) this.menu.removeAttribute('aria-hidden');
	if (this.settings.setMaxHeight) this.menu.style.maxHeight = this.menu.scrollHeight + "px";
	this.expanded = true;
	this.menu.addEventListener('keydown', this.onMenuKeydown, false);
	this.menu.addEventListener('focusin', this.onFocusin, false);
	this.menu.addEventListener('focusout', this.onFocusout, false);
	this.menu.addEventListener('mouseOver', this.onMenuMouseover, false);
	emitEvent('MenuToggle:expand', {
		MenuToggle: this,
		expanded: this.expanded
	});
	return this;
}

MenuToggle.prototype.collapse = function () {
	this.toggle.setAttribute('aria-expanded', 'false');
	this.expanded = false;
	this.currentMenuItem = false;
	if (this.parent) this.parent.setAttribute('aria-expanded', 'false');
	if (this.settings.setAriaHidden) this.menu.setAttribute('aria-hidden', '');
	if (this.settings.setMaxHeight) this.menu.style.maxHeight = null;
	this.menu.removeEventListener('keydown', this.onMenuKeydown, false);
	this.menu.removeEventListener('focusin', this.onFocusin, false);
	this.menu.removeEventListener('focusout', this.onFocusout, false);
	this.menu.removeEventListener('mouseOver', this.onMenuMouseover, false);
	emitEvent('MenuToggle:collapse', {
		MenuToggle: this,
		expanded: this.expanded
	});
	return this;
}

MenuToggle.prototype.setFocusToItem = function (item) {
	for (let menuItem of this.menuItems) {
		if (item === menuItem) {
			menuItem.tabIndex = 0;
			menuItem.focus();
			this.currentMenuItem = menuItem;
		} else {
			menuItem.tabIndex = -1;
		}
	}
}

MenuToggle.prototype.setFocusToFirstItem = function () {
	this.setFocusToItem(this.firstMenuItem);
}

MenuToggle.prototype.setFocusToLastItem = function () {
	this.setFocusToItem(this.LastMenuItem);
}

MenuToggle.prototype.setFocusToPrevItem = function () {
	if (!this.currentMenuItem) return;
	let prev, index;
	if (this.currentMenuItem === this.firstMenuItem) {
		prev = this.lastMenuItem;
	} else {
		index = this.menuItems.indexOf(this.currentMenuItem);
		prev = this.menuItems[index - 1];
	}
	this.setFocusToItem(prev);
}

MenuToggle.prototype.setFocusToNextItem = function () {
	if (!this.currentMenuItem) return;
	let next, index;
	if (this.currentMenuItem === this.lastMenuItem) {
		next = this.firstMenuItem;
	} else {
		index = this.menuItems.indexOf(this.currentMenuItem);
		next = this.menuItems[index + 1];
	}
	this.setFocusToItem(next);
}

MenuToggle.prototype.setFocusByFirstChar = function (char) {
	if (char.length > 1) return;
	char = char.toLowerCase();
	let start = this.menuItems.indexOf(this.currentMenuItem) + 1;
	let index = this.firstChars.indexOf(char, start);
	index = index === -1 ? this.firstChars.indexOf(char, 0) : index;
	if (index > -1) this.setFocusToMenuItem(this.menuItems[index]);
}

MenuToggle.prototype.onOutsideClick = function (event) {
	if (this.menu.contains(event.target) || !this.expanded) return;
	this.collapse();
	return this;
}

MenuToggle.prototype.onToggleKeydown = function (event) {
	let key = event.key,
		flag = false;

	switch (key) {
		case ' ':
		case 'Enter':
		case 'ArrowDown':
		case 'Down':
			this.expand();
			this.setFocusToFirstItem();
			flag = true;
			break;

		case 'Esc':
		case 'Escape':
			this.collapse();
			this.toggle.focus();
			flag = true;
			break;

		case 'Up':
		case 'ArrowUp':
			this.expand();
			this.setFocusToLastItem();
			flag = true;
			break;

		default:
			break;
	}

	if (flag) {
		event.stopPropagation();
		event.preventDefault();
	}
}

MenuToggle.prototype.onFocusin = function (event) {
	let a = event.target.closest('a');
	if (!a) return;
	a.classList.add('focus');
}

MenuToggle.prototype.onFocusout = function (event) {
	let a = event.target.closest('a');
	if (!a) return;
	a.classList.remove('focus');
}

MenuToggle.prototype.onToggleClick = function (event) {
	if (this.expanded) {
		this.collapse();
		this.toggle.focus();

	} else {
		this.expand();
		this.setFocusToFirstItem();
	}

	event.stopPropagation();
	event.preventDefault();
}

MenuToggle.prototype.onMenuMouseover = function (event) {
	let a = event.target.closest('a');
	if (!a) return;
	a.focus();
}

MenuToggle.prototype.onMenuKeydown = function (event) {
	if (!this.menu.contains(event.target)) return;
	let tgt = event.currentTarget,
		key = event.key,
		flag = false;

	if (event.ctrlKey || event.altKey || event.metaKey) {
		return;
	}

	if (event.shiftKey) {
		if (isPrintableChar(key)) {
			this.setFocusByFirstChar(tgt, key);
			flag = true;
		}

		if (key === 'Tab') {
			this.toggleEl.focus();
			this.collapse();
			flag = true;
		}

	} else {
		switch (key) {
			case ' ':
				window.location.href = tgt.href;
				break;

			case 'Esc':
			case 'Escape':
				this.collapse();
				this.toggleEl.focus();
				flag = true;
				break;

			case 'Up':
			case 'ArrowUp':
				this.setFocusToPrevItem(tgt);
				flag = true;
				break;

			case 'ArrowDown':
			case 'Down':
				this.setFocusToNextItem(tgt);
				flag = true;
				break;

			case 'Home':
			case 'PageUp':
				this.setFocusToFirstItem();
				flag = true;
				break;

			case 'End':
			case 'PageDown':
				this.setFocusToLastItem();
				flag = true;
				break;

			case 'Tab':
				this.collapse();
				break;

			default:
				if (isPrintableChar(key)) {
					this.setFocusByFirstChar(tgt, key);
					flag = true;
				}
				break;
		}
	}

	if (flag) {
		event.stopPropagation();
		event.preventDefault();
	}
	emitEvent('MenuToggle:menuKeydown', {
		MenuToggle: this
	});
}

function initToggles () {
	let toggles = document.querySelectorAll('[data-expand]');
	if (!toggles.length) return;
	for (let toggle of toggles) {
		new MenuToggle(toggle);
	}
}

document.addEventListener('DOMContentLoaded', initToggles, false);

export {MenuToggle as default};

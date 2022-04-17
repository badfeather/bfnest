function expander (toggleEl, options = {}) {
	const targetId = toggleEl.getAttribute('data-expand');
	if (!targetId) return;
	const targetEl = document.getElementById(targetId);
	if (!targetEl) return;

	const parentEl = toggleEl.closest('[data-expand-parent]');
	const focusSelectors = [
		'a[href]:not([tabindex^="-"])',
		'area[href]:not([tabindex^="-"])',
		'input:not([type="hidden"]):not([type="radio"]):not([disabled]):not([tabindex^="-"])',
		'input[type="radio"]:not([disabled]):not([tabindex^="-"])',
		'select:not([disabled]):not([tabindex^="-"])',
		'textarea:not([disabled]):not([tabindex^="-"])',
		'button:not([disabled]):not([tabindex^="-"])',
		'iframe:not([tabindex^="-"])',
		'audio[controls]:not([tabindex^="-"])',
		'video[controls]:not([tabindex^="-"])',
		'[contenteditable]:not([tabindex^="-"])',
		'[tabindex]:not([tabindex^="-"])'
	];
	let focusEls = targetEl.querySelectorAll(focusSelectors.join(','));
	focusEls = focusEls.length ? Array.prototype.slice.call(focusEls) : false;
	const firstFocusEl = focusEls.length ? focusEls[0] : targetEl;
	const lastFocusEl = focusEls.length ? focusEls[focusEls.length - 1] : targetEl;
	console.log(firstFocusEl, lastFocusEl);

	let expanded = targetEl.getAttribute('data-expand-open') ? true : false;
	const settings = Object.assign({
		setMaxHeight: false,
		setAriaHidden: true,
		collapseOnOutsideClick: false,
		shiftFocus: true,
		accordion: false
	}, options);

	function expand () {
		toggleEl.setAttribute('aria-expanded', 'true');
		if (parentEl) parentEl.setAttribute('aria-expanded', 'true');
		if (settings.setAriaHidden) targetEl.removeAttribute('aria-hidden');
		targetEl.focus();
		if (settings.setMaxHeight) targetEl.style.maxHeight = targetEl.scrollHeight + "px";
		expanded = true;
	}

	function collapse () {
		toggleEl.setAttribute('aria-expanded', 'false');
		if (parentEl) parentEl.setAttribute('aria-expanded', 'false');
		if (settings.setAriaHidden) targetEl.setAttribute('aria-hidden', '');
		toggleEl.focus();
		if (settings.setMaxHeight) targetEl.style.maxHeight = null;
		expanded = false;
	}

	function toggle (event) {
		let closestToggle = event.target.closest('[data-expand]');
		if (!closestToggle || closestToggle !== toggleEl) return;
		if (expanded) {
			collapse();

		} else {
			expand();
		}
	}

	function handleKeydown (event) {
		let target = event.target;
		let closestToggle = target.closest('[data-expand]');
		//let closestFocusable = target.closest(focusSelectors.join(','));
		if (!(closestToggle === toggleEl || focusEls.includes(target))) return;
		let key = event.key;

		// toggle
		if (closestToggle === toggleEl) {
			switch (key) {
				case 'Space':
				case 'Enter':
				case 'DownArrow':
					expand();
					firstFocusEl.focus();
					break;
				case 'UpArrow':
					expand();
					lastFocusEl.focus();
					break;
			}
			return;
		}

		if (!focusEls.includes(target)) return;

		let index = focusEls.indexOf(target);
		if (index === -1 && closestToggle !== toggleEl) return;

		// if alphabet key
		if (key.length === 1 && key.match(/\S/)) {
			for (const focusEl of focusEls) {
				const text = focusEl.textContent;
				const firstChar = text.length ? text[0] : false;
				if (firstChar.toUpperCase() === key.toUpperCase()) {
					focusEl.focus();
					break;
				}
			}
			return;
		}

		// actionable keys
		if (key === 'End' || (target === firstFocusEl && key === 'UpArrow')) {
			lastFocusEl.focus();
			return;
		}
		if (key === 'Home' || (target === lastFocusEl && key === 'DownArrow')) {
			firstFocusEl.focus();
			return;
		}

		switch (key) {
			case 'Enter':
			case 'Escape':
			case 'Tab':
				collapse();
				toggleEl.focus();
				break;
			case 'UpArrow':
				focusEls(index - 1).focus();
				break;
			case 'DownArrow':
				focusEls(index + 1).focus();
				break;
		}
	}

	function collapseOnOutsideClick (event) {
		const parent = parentEl ? parentEl : targetEl;
		if (parent.contains(event.target)) return;
		collapse();
		return this;
	}

	function setup () {
		toggleEl.setAttribute('aria-controls', targetId);
		targetEl.hasAttribute('aria-labelledby') || targetEl.setAttribute('aria-labelledby', targetId);
		targetEl.tabIndex = -1;

		if (expanded) {
			expand();

		} else {
			collapse();
		}
	}

	setup();
	document.addEventListener('click', toggle, false);
	document.addEventListener('keydown', handleKeydown, false);

	if (settings.collapseOnOutsideClick) {
		document.addEventListener('click', collapseOnOutsideClick, false);
	}
}

function initExpanders () {
	const toggles = document.querySelectorAll('[data-expand]');
	if (!toggles.length) return;
	for (const toggle of toggles) {
		expander(toggle);
	}
}

document.addEventListener('DOMContentLoaded', initExpanders, false);
export {expander};

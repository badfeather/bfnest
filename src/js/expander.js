import emitEvent from './events.js';

function Expander (toggleEl, options = {}) {
	let targetId = toggleEl.getAttribute('data-expand');
	if (!targetId) return;

	let targetEl = document.getElementById(targetId);
	if (!targetEl) return;

	let expanded = targetEl.getAttribute('data-expand-open') ? true : false;
	let parentEl = toggleEl.closest('[data-expand-parent]');

	let settings = Object.assign({
		setMaxHeight: false,
		setAriaHidden: true,
		collapseOnOutsideClick: false,
		shiftFocus: true,
		accordion: false
	}, options);
	Object.freeze(settings);

	this._toggleEl = toggleEl;
	this._targetId = targetId;
	this._targetEl = targetEl;
	this._parentEl = parentEl;
	this._settings = settings;
	this._expanded = expanded;

	this._expand = this._expand.bind(this);
	this._collapse = this._collapse.bind(this);
	this._toggle = this._toggle.bind(this);
	this._collapseOnOutsideClick = this._collapseOnOutsideClick.bind(this);

	this.create();
}

Expander.prototype._collapseOnOutsideClick = function (event) {
	if (this._parentEl.contains(event.target)) return;
	this._collapse();
	return this;
}

Expander.prototype._expand = function () {
	this._toggleEl.setAttribute('aria-expanded', 'true');
	if (this._parentEl) this._parentEl.setAttribute('aria-expanded', 'true');
	if (this._settings.setAriaHidden) this._targetEl.removeAttribute('aria-hidden');
	if (this._settings.setMaxHeight) this._targetEl.style.maxHeight = this._targetEl.scrollHeight + "px";
	this._expanded = true;
	emitEvent('expander:expand', {
		expander: this,
		expanded: this._expanded
	});
	return this;
}

Expander.prototype._collapse = function () {
	this._toggleEl.setAttribute('aria-expanded', 'false');
	if (this._parentEl) this._parentEl.setAttribute('aria-expanded', 'false');
	if (this._settings.setAriaHidden) this._targetEl.setAttribute('aria-hidden', '');
	if (this._settings.setMaxHeight) this._targetEl.style.maxHeight = null;
	this._expanded = false;
	emitEvent('expander:collapse', {
		expander: this,
		expanded: this._expanded
	});
	return this;
}

Expander.prototype._toggle = function () {
	if (this._expanded) {
		this._collapse();

	} else {
		this._expand();
	}
	return this;
}

Expander.prototype.create = function () {
	this._toggleEl.setAttribute('aria-controls', this._targetId);
	this._targetEl.hasAttribute('aria-labelledby') || this._targetEl.setAttribute('aria-labelledby', this._id);

	if (this._expanded) {
		this._expand();

	} else {
		this._collapse();
	}

	document.addEventListener('click', this._toggle, false);

	document.addEventListener('keyup', function (event) {
		if (!['Space', 'Enter'].includes(event.code)) return;
		let closestToggle = event.target.closest('[data-expand]');
		if (!closestToggle || closestToggle !== this._toggleEl) return;
		this._toggle(event);
	}, false);

	if (this._parentEl && this._settings._collapseOnOutsideClick) {
		document.addEventListener('click', this._collapseOnOutsideClick, false);
	}

	emitEvent('expander:ready', {
		expander: this,
		expanded: this._expanded
	});

	return this;
}

function initToggles () {
	let toggles = document.querySelectorAll('[data-expand]');
	if (!toggles.length) return;
	for (let toggle of toggles) {
		new Expander(toggle);
	}
}

document.addEventListener('DOMContentLoaded', initToggles, false);

export {Expander as default};

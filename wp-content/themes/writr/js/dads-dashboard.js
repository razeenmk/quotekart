(function () {
	'use strict';
	var dashboard = document.querySelector('.dads-dashboard');
	if (!dashboard) { return; }
	var button = dashboard.querySelector('.dads-menu-button');
	var scrim = dashboard.querySelector('.dads-scrim');
	var links = dashboard.querySelectorAll('.dads-nav a');
	function closeMenu() {
		dashboard.classList.remove('is-menu-open');
		button.setAttribute('aria-expanded', 'false');
	}
	button.addEventListener('click', function () {
		var isOpen = dashboard.classList.toggle('is-menu-open');
		button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
	});
	scrim.addEventListener('click', closeMenu);
	for (var i = 0; i < links.length; i++) {
		links[i].addEventListener('click', closeMenu);
	}
}());

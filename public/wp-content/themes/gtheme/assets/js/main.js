/*
* Custom Theme JS
*/

jQuery(function ($) {

	// $('body').hide();

	var scrollClassThreshold = 80;

	/*
	*
	* Custom Functions
	*
	*/

	function updateScrollClassThreshold() {
		scrollClassThreshold = $('.home-menu-container').offset().top;
	}

	function updateScrollTopPosition() {
		if (g.scrollPos > 300) {
			$('html').addClass('past-top');
		}
		else {
			$('html').removeClass('past-top');
		}
	}


	/*
	*
	*	Place items in here to have them run after the Dom is ready
	*
	*/
	$(document).ready(function () {

		if ($('.home-menu-container').length) {
			updateScrollClassThreshold();
		}

		g.filterLinks();
		g.setHeightVars();
		g.setScrollVars();
		g.addDropDownsToSubMenus();
		g.addListenerToMobileMenuButton();
		g.wrapInputItems();
		g.updateOverflown();
		g.removeTelLinksForNonMobile();

		updateScrollTopPosition();
	});

	/*
	*
	*	Place items in here to have them run the page is loaded
	*
	*/
	$(window).on('load', function () {
		g.setHeightVars();
		g.updateScrollClasses(scrollClassThreshold);
		updateScrollTopPosition();
		if ($('.home-menu-container').length) {
			updateScrollClassThreshold();
		}
	});

	/*
	*
	*	Place items in here to have them run when the window is scrolled
	*
	*/
	$(window).on('scroll', function () {
		g.setScrollVars();
		g.updateScrollClasses(scrollClassThreshold);
		updateScrollTopPosition();
	});

	/*
	*
	*	Place items in here to have them run when the window is resized
	*
	*/
	$(window).on('resize', function () {
		g.setHeightVars();
		g.setScrollVars();
		g.updateScrollClasses(scrollClassThreshold);
		updateScrollTopPosition();
		if ($('.home-menu-container').length) {
			updateScrollClassThreshold();
		}
	});


});

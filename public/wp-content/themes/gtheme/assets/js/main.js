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

	function formsRender() {

		var mdForm = $('.md-form');
		if (mdForm.length) {
			mdForm.find('.custom-select').each(function(){
				$(this).removeClass('custom-select').addClass('mdb-select').materialSelect();
			});
			mdForm.find('input, select, textarea').trigger('change');
		}

		$('.ginput_container_name input, .ginput_container_address input').each(function(){
			if ($(this).val()) {
				$(this).closest('li.gfield').find('label').addClass('active');
			}
		})
		$('.ginput_container_name input, .ginput_container_address input').on('focus', function(){
			$(this).closest('li.gfield').find('label').addClass('active');
		});

		if (typeof bsCustomFileInput !== 'undefined') {
			bsCustomFileInput.init();
		}
	}

	$(document).on('gform_post_render', function(event, form_id, current_page){
		formsRender();
	});


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
		// g.wrapInputItems();
		g.updateOverflown();
		g.removeTelLinksForNonMobile();

		updateScrollTopPosition();

		formsRender();
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

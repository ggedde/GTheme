/*
* Custom Theme JS
*/

jQuery(function ($) {

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

	function autoGrow(element) {
		if (element && typeof element.scrollHeight !== 'undefined') {
			if (element.scrollHeight > 90) {
				element.style.height = "5px";
				element.style.height = element.scrollHeight+"px";
			}
		}
	}

	// function MdbformsRender() {

	// 	var mdForm = $('.md-form');
	// 	if (mdForm.length) {
	// 		mdForm.find('.custom-select').each(function(){
	// 			$(this).removeClass('custom-select').addClass('mdb-select').materialSelect();
	// 		});
	// 		mdForm.find('input, select, textarea').trigger('change');
	// 	}

	// 	$('.ginput_container_name input, .ginput_container_address input').each(function(){
	// 		if ($(this).val()) {
	// 			$(this).closest('li.gfield').find('label').addClass('active');
	// 		}
	// 	})
	// 	$('.ginput_container_name input, .ginput_container_address input').on('focus', function(){
	// 		$(this).closest('li.gfield').find('label').addClass('active');
	// 	});

	// 	if (typeof bsCustomFileInput !== 'undefined') {
	// 		bsCustomFileInput.init();
	// 	}

	// 	var inputs = [
	// 		'form.bootstrap.nested-labels .ginput_container_text input',
	// 		'form.bootstrap.nested-labels .ginput_container_email input',
	// 		'form.bootstrap.nested-labels .ginput_container_phone input',
	// 		'form.bootstrap.nested-labels .ginput_container_number input',
	// 		'form.bootstrap.nested-labels .ginput_container_textarea textarea',
	// 		'form.bootstrap.nested-labels .ginput_container_select select',
	// 	];

	// 	$(inputs.join(', ')).on('focus', function(){
	// 		$(this).closest('.gfield').find('.gfield_label').addClass('active');
			
	// 	}).on('blur', function(){
	// 		if (!$(this).val()){
	// 			$(this).closest('.gfield').find('.gfield_label').removeClass('active');
	// 		}
	// 	});
	// }

	// $(document).on('gform_post_render', function(event, form_id, current_page){
	// 	MdbformsRender();
	// });


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

		$('textarea').on('input', function(){
			$(this).attr('rows', 0);
			autoGrow($(this)[0]);
			
		});
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

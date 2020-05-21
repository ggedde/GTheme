<?php

/*
*
* GBlock
*
* Available Variables:
* $block 					= Name of Block Folder
* $block_backgrounds 		= Array for Background Options
* $block_background_image = Array for Background Image Option
*
* This file must return an array();
*
*/

$block_fields = array(
	array (
		'key' => 'field_'.$block.'_hide_title',
		'label' => 'Hide Title',
		'name' => $block.'_hide_title',
		'type' => 'true_false',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'message' => '',
		'ui' => 1,
		'ui_on_text' => 'Yes',
		'ui_off_text' => 'No',
		'default_value' => 0,
	 ),
	array (
	   'key' => 'field_'.$block.'_use_alternate_title',
	   'label' => 'Use Alternate Title',
	   'name' => $block.'_use_alternate_title',
	   'type' => 'true_false',
	   'instructions' => 'Otherwise use the Title of the Page',
	   'required' => 0,
	   'conditional_logic' => array (
		array (
			array (
				'field' => 'field_'.$block.'_hide_title',
				'operator' => '==',
				'value' => 0,
			),
		),
	),
	   'wrapper' => array (
	       'width' => '50',
	       'class' => '',
	       'id' => '',
	   ),
	   'message' => '',
	   'ui' => 1,
	   'ui_on_text' => 'Yes',
	   'ui_off_text' => 'No',
	   'default_value' => 0,
	),
	array (
		'key' => 'field_'.$block.'_title',
		'label' => 'Alternate Title',
		'name' => $block.'_title',
		'type' => 'text',
		'column_width' => '',
		'default_value' => '',
		'instructions' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'none', 		// none | html
		'maxlength' => '',
		'conditional_logic' => array (
		    array (
		        array (
		            'field' => 'field_'.$block.'_use_alternate_title',
		            'operator' => '==',
		            'value' => 1,
		        ),
		    ),
		),
	),
	array (
		'key' => 'field_'.$block.'_sub_title',
		'label' => 'Sub Title',
		'name' => $block.'_sub_title',
		'type' => 'text',
		'column_width' => '',
		'default_value' => '',
		'instructions' => '(Optional)',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'none', 		// none | html
		'maxlength' => '',
	),
	array (
		'key' => 'field_'.$block.'_intro',
		'label' => 'Intro Text',
		'name' => $block.'_intro',
		'type' => 'wysiwyg',
	    'instructions' => 'Short Description of the page. (Optional)',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => '',
	    'tabs' => 'all',         // all | visual | text
	    'toolbar' => 'full',     // full | basic
	    'media_upload' => 1,
	),
	array (
		'key' => 'field_'.$block.'_3',
		'label' => 'Buttons',
		'name' => $block.'_buttons',
		'type' => 'repeater',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'collapsed' => '',
		'min' => '1',
		'max' => '',
		'layout' => 'block',
		'button_label' => 'Add Button',
		'sub_fields' => array(
			GBLOCKS::get_link_fields(array('name' => 'button', 'styles' => array('btn btn-primary' => 'Primary', 'btn btn-secondary' => 'Secondary')))
		),
	),
	array (
	    'key' => 'field_'.$block.'_content_alignment',
	    'label' => 'Content Alignment',
	    'name' => $block.'_content_alignment',
	    'type' => 'radio',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => array (
	        'text-left' => 'Left',
	        'text-center d-flex justify-content-center' => 'Center',
	        'text-right  d-flex justify-content-right' => 'Right',
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => 'text-center d-flex justify-content-center',
	    'layout' => 'horizontal',
		'block_options' => 1,
	),
);

return array (
	'label' => 'Banner',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'gblocks_settings' => array(
		'repeater' => false,
		'repeater_label' => 'Banners',
		'icon' => 'dashicons-welcome-view-site',
		'description' => ''
	),
);

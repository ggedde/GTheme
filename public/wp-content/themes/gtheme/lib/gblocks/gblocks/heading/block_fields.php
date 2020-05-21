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
		'key' => 'field_'.$block.'_heading',
		'label' => 'Heading',
		'name' => $block.'_heading',
		'type' => 'textarea',
		'instructions' => '',
		'required' => 1,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'maxlength' => '',
		'rows' => '2',
		'new_lines' => 'br',        // wpautop | br | ''
		'readonly' => 0,
		'disabled' => 0,
	),
	array (
		'key' => 'field_'.$block.'_sub_heading',
		'label' => 'Sub Heading',
		'name' => $block.'_sub_heading',
		'type' => 'textarea',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'maxlength' => '',
		'rows' => '2',
		'new_lines' => 'br',        // wpautop | br | ''
		'readonly' => 0,
		'disabled' => 0,
	),
	array (
		'key' => 'field_'.$block.'_alignment',
		'label' => 'Alignment',
		'name' => $block.'_alignment',
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
		'default_value' => 'text-left',
		'layout' => 'horizontal',
	)
);

return array (
	'label' => 'Heading',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'gblocks_settings' => array(
		'icon' => 'dashicons-editor-textcolor',
		'description' => ''
	),
);

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

$gforms = array(0 => '- None');

foreach(GBLOCKS::get_gravity_forms() as $gform)
{
	$gforms[$gform['id']] = $gform['title'];
}

$block_fields = array(
	array (
		'key' => 'field_'.$block.'_title',
		'label' => 'Title',
		'name' => $block.'_title',
		'type' => 'text',
		'conditional_logic' => 0,
		'column_width' => '',
		'default_value' => '',
		'instructions' => '(optional)',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'none', 		// none | html
		'maxlength' => '',
	), 
	array (
		'key' => 'field_'.$block.'_description',
		'label' => 'Description',
		'name' => $block.'_description',
		'type' => 'wysiwyg',
		'conditional_logic' => 0,
		'instructions' => '(optional)',
		'default_value' => '',
		'tabs' => 'all',         // all | visual | text
		'toolbar' => 'full',     // full | basic
		'media_upload' => 1,
	), 
	array (
		'key' => 'field_'.$block.'_buttons',
		'label' => 'Buttons',
		'name' => $block.'_buttons',
		'type' => 'repeater',
		'instructions' => '(optional)',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'collapsed' => '',
		'min' => '',
		'max' => '',
		'layout' => 'block',
		'button_label' => 'Add Button',
		'sub_fields' => array(
			GBLOCKS::get_link_fields(array('name' => 'button', 'styles' => array('btn btn-primary' => 'Primary', 'btn btn-secondary' => 'Secondary')))
		),
	), 
	array (
		'key' => 'field_'.$block.'_form',
		'label' => 'Form',
		'name' => $block.'_form',
		'type' => 'select',
		'instructions' => '(optional)',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => $gforms,
		'default_value' => array (
		),
		'allow_null' => 0,
		'multiple' => 0,         // allows for multi-select
		'ui' => 0,               // creates a more stylized UI
		'ajax' => 0,
		'placeholder' => '',
		'disabled' => 0,
		'readonly' => 0,
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
		'default_value' => 'text-center d-flex justify-content-center',
		'layout' => 'horizontal',
	)
);

return array (
	'label' => '<span class="dashicons-before dashicons-megaphone gblock-acf-icon">Call to Action</span>',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields
);

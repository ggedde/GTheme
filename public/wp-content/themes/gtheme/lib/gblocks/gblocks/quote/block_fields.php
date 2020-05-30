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
		'key' => 'field_'.$block.'_quote',
		'label' => 'Quote',
		'name' => $block.'_quote',
		'type' => 'textarea',
		'column_width' => '',
		'default_value' => '',
		'placeholder' => '',
		'maxlength' => '',
		'rows' => '',
		'formatting' => 'none',
	),
	array (
		'key' => 'field_'.$block.'_image',
		'label' => 'Image',
		'name' => $block.'_image',
		'type' => 'image',
		'instructions' => '(Optional)',
		'column_width' => '',
		'save_format' => 'object',
		'preview_size' => 'thumbnail',
		'library' => 'all',
	),
	array (
		'key' => 'field_'.$block.'_attribution_title',
		'label' => 'Attribution Title',
		'name' => $block.'_attribution_title',
		'type' => 'text',
		'instructions' => '(Optional)',
		'column_width' => '',
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'none',
		'maxlength' => '',
	),
	array (
		'key' => 'field_'.$block.'_attribution_sub_title',
		'label' => 'Attribution Sub Title',
		'name' => $block.'_attribution_sub_title',
		'type' => 'text',
		'instructions' => '(Optional)',
		'column_width' => '',
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'none',
		'maxlength' => '',
	),
	
);

return array (
	'label' => '<span class="dashicons-before dashicons-editor-quote gblock-acf-icon">Quote</span>',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields
);

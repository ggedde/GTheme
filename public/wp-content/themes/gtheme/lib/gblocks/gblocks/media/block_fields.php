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
		'key' => 'field_'.$block.'_image',
		'label' => 'Full Width Image',
		'name' => $block.'_image',
		'type' => 'image',
		'column_width' => '',
		'save_format' => 'object',
		'preview_size' => 'medium',
		'library' => 'all',
	),
	array (
		'key' => 'field_'.$block.'_padding',
		'label' => 'Add Padding',
		'name' => $block.'_padding',
		'type' => 'true_false',
		'column_width' => '',
		'message' => '',
		'default_value' => 0,
	),
	GBLOCKS::get_link_fields( $block.'_link', 'Link', null, false),
);

return array (
	'label' => '<span class="dashicons-before dashicons-format-image gblock-acf-icon">Media</span>',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields
);

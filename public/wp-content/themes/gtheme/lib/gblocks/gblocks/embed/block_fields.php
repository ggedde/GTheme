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
		'key' => 'field_'.$block.'_custom_embed',
		'label' => 'Embed Code',
		'name' => 'custom_embed',
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
		'rows' => '',
		'new_lines' => '',        // wpautop | br | ''
		'readonly' => 0,
		'disabled' => 0,
	),
);

return array (
	'label' => 'Embed',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'gblocks_settings' => array(
		'repeater' => false,
		'repeater_label' => '',
		'icon' => 'gblockicon-content',
		'description' => ''
	),
);

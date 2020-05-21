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
        'key' => 'field_'.$block.'_columns',
        'label' => 'Columns',
        'name' => $block.'_columns',
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
        'max' => apply_filters('gblocks_content_columns_max', 100),
        'layout' => 'block',         // table | block | row
        'button_label' => 'Add Column',
        'sub_fields' => array (
            array (
                'key' => 'field_'.$block.'_column_content',
                'label' => 'Content',
                'name' => 'content',
                'type' => 'wysiwyg',
                'instructions' => '',
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
        ),
    ),
);

return array (
	'label' => 'Content',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'gblocks_settings' => array(
		'version' => '1.0',
		'icon' => 'dashicons-editor-alignleft',
		'description' => ''
	),
);

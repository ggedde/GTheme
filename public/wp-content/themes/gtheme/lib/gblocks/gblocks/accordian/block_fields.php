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
	   'key' => 'field_'.$block.'_expand_first_item',
	   'label' => 'Expand First Item',
	   'name' => $block.'_expand_first_item',
	   'type' => 'true_false',
	   'instructions' => '',
	   'required' => 0,
	   'conditional_logic' => 0,
	   'wrapper' => array (
		   'width' => '',
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
        'key' => 'field_'.$block.'_accordion',
        'label' => 'Accordion Items',
        'name' => $block.'_accordion',
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
        'layout' => 'block',         // table | block | row
        'button_label' => 'Add Item',
        'sub_fields' => array (
            array (
                'key' => 'field_'.$block.'_title',
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
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
                'formatting' => 'none',       // none | html
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
            ),
            array (
                'key' => 'field_'.$block.'_text',
                'label' => 'Text',
                'name' => 'text',
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
                'tabs' => 'visual',         // all | visual | text
                'toolbar' => 'full',     // full | basic
                'media_upload' => 0,
            ),
        ),
    ),
);

return array (
	'label' => '<span class="dashicons-before dashicons-menu gblock-acf-icon">Accordion</span>',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields
);

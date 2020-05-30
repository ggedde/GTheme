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
	    'key' => 'field_'.$block.'_format',
	    'label' => 'Format',
	    'name' => 'format',
	    'type' => 'radio',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => apply_filters('gblocks_grid_format_choices', GBLOCKS::get_grid_format_choices()),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => '',
	    'layout' => 'horizontal',
	),
	array (
	    'key' => 'field_'.$block.'_num_columns_small',
	    'label' => 'Number of Columns on Small Screens',
	    'name' => 'num_columns_small',
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
	        '1' => '1',
	        '2' => '2',
	        '3' => '3',
	        '4' => '4',
	        '5' => '5',
	        '6' => '6',
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => '1',
	    'layout' => 'horizontal',
		'block_options' => 1,
	),
	array (
	    'key' => 'field_'.$block.'_num_columns_medium',
	    'label' => 'Number of Columns on Medium Screens',
	    'name' => 'num_columns_medium',
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
	        '1' => '1',
	        '2' => '2',
	        '3' => '3',
	        '4' => '4',
	        '5' => '5',
	        '6' => '6',
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => '2',
	    'layout' => 'horizontal',
		'block_options' => 1,
	),
	array (
	    'key' => 'field_'.$block.'_num_columns_large',
	    'label' => 'Number of Columns on Large Screens',
	    'name' => 'num_columns_large',
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
	        '1' => '1',
	        '2' => '2',
	        '3' => '3',
	        '4' => '4',
	        '5' => '5',
	        '6' => '6',
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => '4',
	    'layout' => 'horizontal',
		'block_options' => 1,
	),
	array (
	    'key' => 'field_'.$block.'_num_columns_xlarge',
	    'label' => 'Number of Columns on Extra Large Screens',
	    'name' => 'num_columns_xlarge',
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
	        '1' => '1',
	        '2' => '2',
	        '3' => '3',
	        '4' => '4',
	        '5' => '5',
	        '6' => '6',
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => '6',
	    'layout' => 'horizontal',
		'block_options' => 1,
	),
	array (
		'key' => 'field_'.$block.'_2',
		'label' => 'Gallery Items',
		'name' => 'gallery_items',
		'type' => 'repeater',
		'column_width' => '',
		'instructions' => '',
		'sub_fields' => array (
			array (
				'key' => 'field_'.$block.'_8',
				'label' => 'Item Title',
				'name' => 'item_title',
				'type' => 'text',
				'column_width' => '',
				'default_value' => '',
				'instructions' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
				'conditional_logic' => array (
				    array (
				        array (
				            'field' => 'field_'.$block.'_format',
				            'operator' => '!=',
				            'value' => 'logos',
				        ),
						array (
				            'field' => 'field_'.$block.'_format',
				            'operator' => '!=',
				            'value' => 'gallery',
				        ),
				    ),
				),
			),
			array (
				'key' => 'field_'.$block.'_9',
				'label' => 'Image',
				'name' => 'item_image',
				'instructions' => '',
				'type' => 'image',
				'column_width' => '',
				'save_format' => 'object',
				'library' => 'all',
				'preview_size' => 'medium',
			),
			GBLOCKS::get_link_fields(array('name' => 'link', 'show_text' => false, 'conditional_logic' => array('field' => 'field_'.$block.'_format','operator' => '!=','value' => 'gallery'))),
			array (
				'key' => 'field_'.$block.'_10',
				'label' => 'Content',
				'name' => 'item_content',
				'type' => 'textarea',
				'column_width' => '',
				'default_value' => '',
				'conditional_logic' => array (
				    array (
				        array (
				            'field' => 'field_'.$block.'_format',
				            'operator' => '!=',
				            'value' => 'logos',
				        ),
						array (
				            'field' => 'field_'.$block.'_format',
				            'operator' => '!=',
				            'value' => 'gallery',
				        ),
				    ),
				),
			),
		),
		'min' => '1',
		'max' => '',
		'layout' => 'row',
		'button_label' => 'Add Grid Item',
	),
);

return array (
	'label' => '<span class="dashicons-before dashicons-screenoptions gblock-acf-icon">Grid</span>',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields
);

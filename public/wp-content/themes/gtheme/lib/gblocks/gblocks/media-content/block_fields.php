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
	    'key' => 'field_'.$block.'_media_type',
	    'label' => 'Media Type',
	    'name' => $block.'_media_type',
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
	        'image' => 'Image', // Leave this blank to allow for older versions to work.
			'video' => 'MP4 Video',
			'embed' => 'Embed'
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => 'image',
	    'layout' => 'horizontal',
	),
	array (
		'key' => 'field_'.$block.'_video_type',
		'label' => 'MP4 Video Type',
		'name' => $block.'_video_type',
		'type' => 'radio',
		'instructions' => 'It is best to use the URL as uploading videos can take up a lot of your hosting disk space and bandwidth.',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'video',
		        ),
			),
		),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => array (
			'url' => 'Url',
			'file' => 'File'
		),
		'other_choice' => 0,
		'save_other_choice' => 0,
		'default_value' => 'url',
		'layout' => 'horizontal',
	),
	array (
		'key' => 'field_'.$block.'_video_url',
		'label' => 'Video URL',
		'name' => $block.'_video_url',
		'type' => 'text',
		'instructions' => 'Video must be a MP4 Format. <br><br>Use the Background Image below for a Placeholder',
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_video_type',
					'operator' => '==',
					'value' => 'url',
				),
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'video',
		        ),
			),
		),
		'column_width' => '',
		'save_format' => 'object',
		'preview_size' => 'medium',
		'library' => 'all',
	),
	array (
		'key' => 'field_'.$block.'_video_file',
		'label' => 'Video File',
		'name' => $block.'_video_file',
		'type' => 'file',
		'instructions' => 'Uploads may not work if the file is too large.',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_video_type',
					'operator' => '==',
					'value' => 'file',
				),
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'video',
		        ),
			),
		),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'return_format' => 'url',      // array | url | id
		'library' => 'all',              // all | uploadedTo
		'min_size' => '',
		'max_size' => '',
		'mime_types' => '',
	),
	array (
	    'key' => 'field_'.$block.'_video_attributes',
	    'label' => 'Video Attributes',
	    'name' => $block.'_video_attributes',
	    'type' => 'checkbox',
	    'instructions' => '',
	    'required' => 0,
		'conditional_logic' => array (
			array (
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'video',
		        ),
			),
		),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => array (
	        'autoplay' => 'Autoplay',
			'loop' => 'Loop',
	        'controls' => 'Controls',
	        'muted' => 'Muted',
	    ),
	    'default_value' => array (
			'controls'
	    ),
	    'layout' => 'horizontal',
	    'toggle' => 0,
	),
	array (
	    'key' => 'field_'.$block.'_embed',
	    'label' => 'Embed',
	    'name' => $block.'_embed',
	    'type' => 'textarea',
	    'instructions' => '',
	    'required' => 0,
		'conditional_logic' => array (
			array (
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'embed',
		        ),
			),
		),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => '',
	    'placeholder' => '',
	    'maxlength' => '',
	    'rows' => '',
	    'new_lines' => 'wpautop',        // wpautop | br | ''
	    'readonly' => 0,
	    'disabled' => 0,
	),
	array (
		'key' => 'field_'.$block.'_image',
		'label' => 'Image',
		'name' => $block.'_image',
		'prefix' => '',
		'type' => 'image',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => array (
		    array (
		        array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'image',
		        ),
		    ),
		),
		'column_width' => '',
		'return_format' => 'array',
		'preview_size' => 'medium',
		'library' => 'all',
	),
	array (
		'key' => 'field_'.$block.'_image_style',
		'label' => 'Image Style',
		'name' => $block.'_image_style',
		'type' => 'select',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_media_type',
					'operator' => '==',
					'value' => 'image',
				),
			),
		),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => array (
			'padded' => 'Padded',
			'cover' => 'Cover',
			'bottom' => 'Bottom Aligned',
		),
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
		'key' => 'field_'.$block.'_media_placement',
		'label' => 'Media Placement',
		'name' => $block.'_media_placement',
		'prefix' => '',
		'type' => 'radio',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'column_width' => '',
		'choices' => array (
			'left' => 'Left',
			'right' => 'Right',
		),
		'other_choice' => 0,
		'save_other_choice' => 0,
		'default_value' => 'left',
		'layout' => 'horizontal',
	),
	array (
		'key' => 'field_'.$block.'_media_size',
		'label' => 'Media Size',
		'name' => $block.'_media_size',
		'prefix' => '',
		'type' => 'radio',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'column_width' => '',
		'choices' => GBLOCKS::column_width_options(),
		'other_choice' => 0,
		'save_other_choice' => 0,
		'default_value' => '4',
		'layout' => 'horizontal',
		'block_options' => 1
	),
	GBLOCKS::get_link_fields($block.'_link', 'Media Link', '', false, null, array (
		array (
			'field' => 'field_'.$block.'_media_type',
			'operator' => '==',
			'value' => 'image',
		),
	)),
	array (
		'key' => 'field_'.$block.'_media_buttons',
		'label' => 'Buttons',
		'name' => $block.'_media_buttons',
		'type' => 'repeater',
		'instructions' => '(optional)',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_media_type',
					'operator' => '==',
					'value' => '',
				),
				array (
					'field' => 'field_'.$block.'_image_style',
					'operator' => '==',
					'value' => 'buttons',
				),
			),
		),
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
			GBLOCKS::get_link_fields('button')
		),
	),
	array (
		'key' => 'field_'.$block.'_content',
		'label' => 'Content',
		'name' => $block.'_content',
		'prefix' => '',
		'type' => 'wysiwyg',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'column_width' => '',
		'default_value' => '',
		'tabs' => 'all',
		'toolbar' => 'full',
		'media_upload' => 0,
	),
);

return array (
	'name' => $block,
	'label' => 'Media with Content',
	'display' => 'row',
	'sub_fields' => $block_fields,
	'min' => '',
	'max' => '',
	'gblocks_settings' => array(
		'icon' => 'dashicons-align-left',
		'description' => ''
	),
);

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
		'name' => 'hide_title',
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
	   'name' => 'use_alternate_title',
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
		'name' => 'title',
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
		'name' => 'sub_title',
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
		'name' => 'intro',
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
		'name' => 'buttons',
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
			GBLOCKS::get_link_fields( 'button' )
		),
	),
	array (
	    'key' => 'field_'.$block.'_content_alignment',
	    'label' => 'Content Alignment',
	    'name' => 'content_alignment',
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
	        'left' => 'Left',
	        'center' => 'Center',
	        'right' => 'Right',
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => 'center',
	    'layout' => 'horizontal',
		'block_options' => 1,
	),
	array (
	   'key' => 'field_'.$block.'_audio',
	   'label' => 'Add Audio File',
	   'name' => 'audio',
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
		'key' => 'field_'.$block.'_audio_title',
		'label' => 'Audio File Title',
		'name' => 'audio_title',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_audio',
					'operator' => '==',
					'value' => 1,
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
		'formatting' => 'none',       // none | html
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
		'readonly' => 0,
		'disabled' => 0,
	),
	array (
		'key' => 'field_'.$block.'_audio_file_type',
		'label' => 'File Type',
		'name' => 'audio_file_type',
		'type' => 'radio',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_audio',
					'operator' => '==',
					'value' => 1,
				),
			),
		),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => array (
			'file' => 'MP3 File',
			'url' => 'MP3 Url'
		),
		'other_choice' => 0,
		'save_other_choice' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
	),
	array (
		'key' => 'field_'.$block.'_audio_file',
		'label' => 'MP3 Audio File',
		'name' => 'audio_file',
		'type' => 'file',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_audio',
					'operator' => '==',
					'value' => 1,
				),
				array (
					'field' => 'field_'.$block.'_audio_file_type',
					'operator' => '==',
					'value' => 'file',
				),
			),
		),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'return_format' => 'array',      // array | url | id
		'library' => 'all',              // all | uploadedTo
		'min_size' => '',
		'max_size' => '',
		'mime_types' => '',
	),
	array ( 
		'key' => 'field_'.$block.'_audio_file_url',
		'label' => 'MP3 Url',
		'name' => 'audio_url',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_audio',
					'operator' => '==',
					'value' => 1,
				),
				array (
					'field' => 'field_'.$block.'_audio_file_type',
					'operator' => '==',
					'value' => 'url',
				),
			),
		),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => 'https://',
		'formatting' => 'none',       // none | html
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
		'readonly' => 0,
		'disabled' => 0,
	),
	array (
		'key' => 'field_'.$block.'_banner_slider_timeout',
		'label' => 'Slider Timeout',
		'name' => 'slider_timeout',
		'type' => 'number',
		'instructions' => 'Timeout in Seconds to change to the next slide. 0 = off',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '6',
		'placeholder' => '',
		'prepend' => '',
		'append' => 'seconds',
		'min' => '',
		'max' => '',
		'step' => '',
		'readonly' => 0,
		'disabled' => 0,
		'block_option' => 1,
		'block_data_attribute' => 1
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
		'repeater' => true,
		'repeater_label' => 'Banners',
		'icon' => 'gblockicon-cta',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gblocks/gblocks/calltoactionv2/cta.svg">
				</div>
				<div class="columns medium-6">
					<p>With this block, you can create buttons&nbsp;for any needed conversion. Whether it’s to direct the user to the contact page or download a white-paper, this block will allow multiple buttons, each with the ability to link to a current page on the site, a specified URL, a file to download, or video to play in a modal.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Title</li>
						<li>Description</li>
						<li>Background</li>
						<li>Buttons <em>( Multiple )</em></li>
					</ul>
				</div>
			</div>'
	),
);

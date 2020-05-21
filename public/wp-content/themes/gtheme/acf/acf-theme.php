<?php

$acf_group = 'theme_options';
acf_add_local_field_group(array (
    'key' => 'group_'.$acf_group,
    'title' => 'Theme Options',
    'fields' => array (
        array (
            'key' => 'field_'.$acf_group.'_globals',
            'label' => 'Globals',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'placement' => 'top',
            'endpoint' => 0,
        ),
		// array (
		//     'key' => 'field_'.$acf_group.'_contact_phone',
		//     'label' => 'Contact Phone',
		//     'name' => 'contact_phone',
		//     'type' => 'text',
		//     'instructions' => '',
		//     'required' => 0,
		//     'conditional_logic' => 0,
		//     'wrapper' => array (
		//         'width' => '',
		//         'class' => '',
		//         'id' => '',
		//     ),
		//     'default_value' => '',
		//     'placeholder' => '',
		//     'formatting' => 'none',       // none | html
		//     'prepend' => '',
		//     'append' => '',
		//     'maxlength' => '',
		//     'readonly' => 0,
		//     'disabled' => 0,
		// ),
		// array (
		//     'key' => 'field_'.$acf_group.'_contact_email',
		//     'label' => 'Contact Email',
		//     'name' => 'contact_email',
		//     'type' => 'text',
		//     'instructions' => '',
		//     'required' => 0,
		//     'conditional_logic' => 0,
		//     'wrapper' => array (
		//         'width' => '',
		//         'class' => '',
		//         'id' => '',
		//     ),
		//     'default_value' => '',
		//     'placeholder' => '',
		//     'formatting' => 'none',       // none | html
		//     'prepend' => '',
		//     'append' => '',
		//     'maxlength' => '',
		//     'readonly' => 0,
		//     'disabled' => 0,
		// ),
		// array (
		// 	'key' => 'field_'.$acf_group.'_contact_address',
		// 	'label' => 'Contact Address',
		// 	'name' => 'contact_address',
		// 	'type' => 'textarea',
		// 	'instructions' => '',
		// 	'required' => 0,
		// 	'conditional_logic' => 0,
		// 	'wrapper' => array (
		// 		'width' => '',
		// 		'class' => '',
		// 		'id' => '',
		// 	),
		// 	'default_value' => '',
		// 	'placeholder' => '',
		// 	'maxlength' => '',
		// 	'rows' => '',
		// 	'new_lines' => 'br',        // wpautop | br | ''
		// 	'readonly' => 0,
		// 	'disabled' => 0,
		// ),
        array (
            'key' => 'field_'.$acf_group.'_copyright_text',
            'label' => 'Copyright Text',
            'name' => 'copyright_text',
            'type' => 'text',
            'instructions' => 'The Year is automatically added at the front of the text.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => get_bloginfo('name').'. All Rights Reserved.',
            'placeholder' => '',
            'formatting' => 'none',       // none | html
            'prepend' => '© '.date('Y').' ',
            'append' => '',
            'maxlength' => '',
            'readonly' => 0,
            'disabled' => 0,
		),
		array (
		   'key' => 'field_'.$acf_group.'_popup_enabled',
		   'label' => 'Enable Popup',
		   'name' => 'popup_enabled',
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
			'key' => 'field_'.$acf_group.'_popup_image',
			'label' => 'Popup Image',
			'name' => 'popup_image',
			'instructions' => '',
			'type' => 'image',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_'.$acf_group.'_popup_enabled',
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
			'return_format' => 'object',       // array | url | id
			'preview_size' => 'medium',
			'library' => 'all',       // all | uploadedTo
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_'.$acf_group.'_popup_title',
			'label' => 'Popup Title',
			'name' => 'popup_title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_'.$acf_group.'_popup_enabled',
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
			'key' => 'field_'.$acf_group.'_popup_logo',
			'label' => 'Popup Logo',
			'name' => 'popup_logo',
			'instructions' => '',
			'type' => 'image',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_'.$acf_group.'_popup_enabled',
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
			'return_format' => 'object',       // array | url | id
			'preview_size' => 'medium',
			'library' => 'all',       // all | uploadedTo
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_'.$acf_group.'_popup_embed_title',
			'label' => 'Embed Title',
			'name' => 'popup_embed_title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_'.$acf_group.'_popup_enabled',
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
			'key' => 'field_'.$acf_group.'_popup_embed',
			'label' => 'Popup Embed Code',
			'name' => 'popup_embed',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_'.$acf_group.'_popup_enabled',
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
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',        // wpautop | br | ''
			'readonly' => 0,
			'disabled' => 0,
		),
        array (
            'key' => 'field_'.$acf_group.'_logo_tab',
            'label' => 'Logo',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array (
            'key' => 'field_'.$acf_group.'_logo',
            'label' => 'Logo Image',
            'name' => $acf_group.'_logo',
            'instructions' => '',
            'type' => 'image',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'object',       // array | url | id
            'preview_size' => 'medium',
            'library' => 'all',       // all | uploadedTo
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
		),
		array (
            'key' => 'field_'.$acf_group.'_footer_logo',
            'label' => 'Footer Logo Image',
            'name' => $acf_group.'_footer_logo',
            'instructions' => '',
            'type' => 'image',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'object',       // array | url | id
            'preview_size' => 'medium',
            'library' => 'all',       // all | uploadedTo
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
        array (
            'key' => 'field_'.$acf_group.'_social_tab',
            'label' => 'Social Links',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'placement' => 'top',
            'endpoint' => 0,
		),
		array ( 
			'key' => 'field_'.$acf_group.'_footer_social_title',
			'label' => 'Footer Social Title',
			'name' => 'footer_social_title',
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
            'key' => 'field_'.$acf_group.'_social_links',
            'label' => 'Social Links',
            'name' => $acf_group.'_social_links',
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
            'layout' => 'table',         // table | block | row
            'button_label' => 'Add Social Icon',
            'sub_fields' => array (
                array (
                    'key' => 'field_'.$acf_group.'_social_title',
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
                    'key' => 'field_'.$acf_group.'_social_link',
                    'label' => 'Link',
                    'name' => 'link',
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
                    'placeholder' => 'https://',
                    'formatting' => 'none',       // none | html
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 0,
                    'disabled' => 0,
                ),
                array (
                    'key' => 'field_'.$acf_group.'_social_icon',
                    'label' => 'Icon Class',
                    'name' => 'icon',
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
            ),
        ),
        array (
            'key' => 'field_'.$acf_group.'_default_images_tab',
            'label' => 'Default Images',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array (
            'key' => 'field_'.$acf_group.'_default_banner_image',
            'label' => 'Default Banner Image',
            'name' => $acf_group.'_default_banner_image',
            'instructions' => '',
            'type' => 'image',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'object',       // array | url | id
            'preview_size' => 'medium',
            'library' => 'all',       // all | uploadedTo
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
        array (
            'key' => 'field_'.$acf_group.'_default_post_image',
            'label' => 'Default Post Image',
            'name' => $acf_group.'_default_post_image',
            'instructions' => '',
            'type' => 'image',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'object',       // array | url | id
            'preview_size' => 'medium',
            'library' => 'all',       // all | uploadedTo
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
		array (
            'key' => 'field_'.$acf_group.'_post_banner_image',
            'label' => 'Blog Banner Image',
            'name' => $acf_group.'_post_banner_image',
            'instructions' => '',
            'type' => 'image',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'object',       // array | url | id
            'preview_size' => 'medium',
            'library' => 'all',       // all | uploadedTo
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
        array (
            'key' => 'field_'.$acf_group.'_global_scripts',
            'label' => 'Scripts',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array (
            'key' => 'field_'.$acf_group.'_global_head_top_content',
            'label' => 'Top &lt;head&gt; Tag Content',
            'name' => 'global_head_top_content',
            'type' => 'textarea',
            'instructions' => 'This will be inserted at the top of the &lt;head&gt; tag on all pages.<br>Warning! This must be formatted correctly or could break the website.',
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
        array (
            'key' => 'field_'.$acf_group.'_global_head_bottom_content',
            'label' => 'Bottom &lt;head&gt; Tag Content',
            'name' => 'global_head_bottom_content',
            'type' => 'textarea',
            'instructions' => 'This will be inserted at the end of the &lt;head&gt; tag on all pages.<br>Warning! This must be formatted correctly or could break the website.',
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
        array (
            'key' => 'field_'.$acf_group.'_global_body_top_content',
            'label' => 'Top &lt;body&gt; Tag Content',
            'name' => 'global_body_top_content',
            'type' => 'textarea',
            'instructions' => 'This will be inserted at the top of the &lt;body&gt; tag on all pages.<br>Warning! This must be formatted correctly or could break the website.',
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
        array (
            'key' => 'field_'.$acf_group.'_global_body_bottom_content',
            'label' => 'Bottom &lt;body&gt; Tag Content',
            'name' => 'global_body_bottom_content',
            'type' => 'textarea',
            'instructions' => 'This will be inserted at the end of the &lt;body&gt; tag on all pages.<br>Warning! This must be formatted correctly or could break the website.',
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
    ),
    'location' => array (
        array (
            array (
                'param' => 'block', // post_type | post | page | page_template | post_category | taxonomy | options_page
                'operator' => '==',
                'value' => 'theme',        // if options_page then use: acf-options  | if page_template then use:  template-example.php
                'order_no' => 0,
                'group_no' => 1,
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',                 // side | normal | acf_after_title
    'style' => 'default',                    // default | seamless
    'label_placement' => 'top',                // top | left
    'instruction_placement' => 'label',     // label | field
    'hide_on_screen' => array (
      //    0 => 'permalink',
      //    1 => 'the_content',
      //    2 => 'excerpt',
      //    3 => 'custom_fields',
      //    4 => 'discussion',
      //    5 => 'comments',
      //    6 => 'revisions',
      //    7 => 'slug',
      //    8 => 'author',
      //    9 => 'format',
      //    10 => 'featured_image',
      //    11 => 'categories',
      //    12 => 'tags',
      //    13 => 'send-trackbacks',
    ),
    'active' => 1,
    'description' => '',
));
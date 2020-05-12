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

$block_fields = array();

$block_fields[] = array (
	'key' => 'field_'.$block.'_title',
	'label' => 'Title',
	'name' => 'title',
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
);
$block_fields[] = array (
	'key' => 'field_'.$block.'_description',
	'label' => 'Description',
	'name' => 'description',
	'type' => 'wysiwyg',
	'conditional_logic' => 0,
	'instructions' => '(optional)',
	'default_value' => '',
	'tabs' => 'all',         // all | visual | text
    'toolbar' => 'full',     // full | basic
    'media_upload' => 1,
);
$block_fields[] = array (
	'key' => 'field_'.$block.'_buttons',
	'label' => 'Buttons',
	'name' => 'buttons',
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
		GBLOCKS::get_link_fields( 'button')
	),
);
$block_fields[] = array (
    'key' => 'field_'.$block.'_form',
    'label' => 'Form',
    'name' => 'form',
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
);
$block_fields[] = array (
    'key' => 'field_'.$block.'_alignment',
    'label' => 'Alignment',
    'name' => 'alignment',
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
        'right' => 'Right ',
    ),
    'other_choice' => 0,
    'save_other_choice' => 0,
    'default_value' => 'left',
    'layout' => 'horizontal',
);

return array (
	'label' => 'Call to Action',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'gblocks_settings' => array(
		'version' => '2.0',
		// 'repeater' => [
		// 	'label' => 'Columns',
		// 	'max' => '',
		// 	'min' => '',
		// ],
		'icon' => 'gblockicon-cta',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gblocks/gblocks/calltoaction/cta.svg">
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

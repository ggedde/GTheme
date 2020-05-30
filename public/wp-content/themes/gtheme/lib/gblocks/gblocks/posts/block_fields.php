<?php

$authors = array();
foreach (get_users() as $user)
{
   $authors[$user->ID] = $user->display_name;
}

$taxonomies = array();

foreach(get_taxonomies(array('public' => true)) as $taxonomy)
{
	foreach(get_terms($taxonomy, array('hide_empty' => false)) as $term)
	{
		$taxonomies[$taxonomy.'::'.$term->term_id] = ucwords(str_replace(array('_','-'), ' ', $taxonomy)).' - '.ucwords($term->name).' ('.$term->count.')';
	}
}

$block_fields = array(
    array (
        'key' => 'field_'.$block.'_filter',
        'label' => 'Filter by',
        'name' => $block.'_filter',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => array (
            'tags' => 'Closest Match (by Related Tags and Categories)',
            'post_type' => 'Most Recent from Post Type',
            'taxonomy' => 'Most Recent from Category',
            'author' => 'Most Recent from Author',
            'custom' => 'Custom',
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
        'key' => 'field_'.$block.'_by_post_type',
        'label' => 'Choose Post Type',
        'name' => $block.'_post_type',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array (
            array (
                array (
                    'field' => 'field_'.$block.'_filter',
                    'operator' => '==',
                    'value' => 'post_type',
                ),
            ),
        ),
        'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => get_post_types(array('public' => true)),
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
        'key' => 'field_'.$block.'_by_taxonomy',
        'label' => 'Choose Taxonomy',
        'name' => $block.'_taxonomy',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array (
            array (
                array (
                    'field' => 'field_'.$block.'_filter',
                    'operator' => '==',
                    'value' => 'taxonomy',
                ),
            ),
        ),
        'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => $taxonomies,
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
        'key' => 'field_'.$block.'_by_author',
        'label' => 'Choose Author',
        'name' => $block.'_author',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array (
            array (
                array (
                    'field' => 'field_'.$block.'_filter',
                    'operator' => '==',
                    'value' => 'author',
                ),
            ),
        ),
        'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => $authors,
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
	    'key' => 'field_'.$block.'_custom',
	    'label' => 'Choose Custom',
	    'name' => $block.'_custom',
	    'type' => 'relationship',
	    'instructions' => '',
	    'required' => 0,
		'conditional_logic' => array (
            array (
                array (
                    'field' => 'field_'.$block.'_filter',
                    'operator' => '==',
                    'value' => 'custom',
                ),
            ),
        ),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'post_type' => array (
	    ),
	    'taxonomy' => array (
	    ),
	    'filters' => array (
	        0 => 'search',
	        1 => 'post_type',
	        2 => 'taxonomy',
	    ),
	    'elements' => '',
	    'min' => '',
	    'max' => '',
	    'return_format' => 'id',     // object | id
	),
	array (
	    'key' => 'field_'.$block.'_limit',
	    'label' => 'Limit',
	    'name' => $block.'_limit',
	    'type' => 'number',
	    'instructions' => '0 = Unlimited',
	    'required' => 0,
		'conditional_logic' => array (
            array (
                array (
                    'field' => 'field_'.$block.'_filter',
                    'operator' => '!=',
                    'value' => 'custom',
                ),
            ),
        ),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => '3',
	    'placeholder' => '',
	    'prepend' => '',
	    'append' => '',
	    'min' => '',
	    'max' => '',
	    'step' => '1',
	    'readonly' => 0,
	    'disabled' => 0,
	),
	GBLOCKS::get_link_fields($block.'_view_more_link', 'View More Link')
);

return array (
	'label' => '<span class="dashicons-before dashicons-admin-post gblock-acf-icon">Posts</span>',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
    'sub_fields' => $block_fields
);

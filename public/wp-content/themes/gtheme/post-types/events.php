<?php
add_action( 'init', 'gblock_custom_post_type_events' );
function gblock_custom_post_type_events()
{
	$single_label = 'Event';
	$plural_label = $single_label.'s';
	$name = strtolower(str_replace(' ', '-', $single_label));
	$slug = $name;

	// Case Studies
	register_post_type($name, array(
	  'label' => $plural_label,
	  'description' => '',
	  'public' => true,
	  'publicly_queryable'  => false,
	  'show_ui' => true,
	  'show_in_menu' => true,
	  'capability_type' => 'post',
	  'map_meta_cap' => true,
	  'hierarchical' => false,
	  'rewrite' => array('with_front' => false, 'slug' => $slug),
	  'query_var' => true,
	  'exclude_from_search' => false,
	  'can_export'          => true,
	  'has_archive'         => false,
	  'menu_icon'			=> 'dashicons-calendar-alt',
	  'menu_icon'		=> 'dashicons-calendar-alt',
	  'supports' => array('title','editor','excerpt','thumbnail'),
	  'labels' => array (
		  'name' => $plural_label,
		  'singular_name' => $single_label,
		  'menu_name' => $plural_label,
		  'add_new' => 'Add '.$single_label,
		  'add_new_item' => 'Add New '.$single_label,
		  'edit' => 'Edit',
		  'edit_item' => 'Edit '.$single_label,
		  'new_item' => 'New '.$single_label,
		  'view' => 'View '.$single_label,
		  'view_item' => 'View '.$single_label,
		  'search_items' => 'Search '.$plural_label,
		  'not_found' => 'No '.$plural_label.' Found',
		  'not_found_in_trash' => 'No '.$plural_label.' Found in Trash',
		  'parent' => 'Parent '.$single_label,
	)));

	register_taxonomy( 'event_types', 
		array($name), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true it acts like categories  */             
			'labels' => array(
				'name' => __( 'Types' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Event Type' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Event Types' ), /* search title for taxomony */
				'all_items' => __( 'All Event Types' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Event Type' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Event Type:' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Event Type' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Event Type' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Event Type' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Event Type Name' ) /* name title for taxonomy */
			),
			'show_ui' => true,
			'query_var' => true,
		)
	);

	register_taxonomy( 'event_locations', 
		array($name), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true it acts like categories  */             
			'labels' => array(
				'name' => __( 'Locations' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Event Location' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Event Locations' ), /* search title for taxomony */
				'all_items' => __( 'All Event Locations' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Event Location' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Event Location:' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Event Location' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Event Location' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Event Location' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Event Location Name' ) /* name title for taxonomy */
			),
			'show_ui' => true,
			'query_var' => true,
		)
	);

	register_taxonomy( 'event_campaigns', 
		array($name), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true it acts like categories  */             
			'labels' => array(
				'name' => __( 'Campaigns' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Event Campaign' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Event Campaigns' ), /* search title for taxomony */
				'all_items' => __( 'All Event Campaigns' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Event Campaign' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Event Campaign:' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Event Campaign' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Event Campaign' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Event Campaign' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Event Campaign Name' ) /* name title for taxonomy */
			),
			'show_ui' => true,
			'query_var' => true,
		)
	);
}
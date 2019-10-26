<?php
add_action( 'init', 'grav_custom_post_type_team' );
function grav_custom_post_type_team()
{
	$single_label = 'Team Member';
	$plural_label = $single_label.'s';
	$name = 'team';
	$slug = $name;

	// Case Studies
	register_post_type($name, array(
	  'label' => $plural_label,
	  'description' => '',
	  'public' => true,
	  'publicly_queryable'  => true,
	  'show_ui' => true,
	  'show_in_menu' => true,
	  'capability_type' => 'page',
	  'map_meta_cap' => true,
	  'hierarchical' => false,
	  'rewrite' => array('with_front' => false, 'slug' => $slug),
	  'query_var' => true,
	  'exclude_from_search' => false,
	  'can_export'          => true,
	  'has_archive'         => false,
	  'menu_icon'			=> 'dashicons-groups',
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
}

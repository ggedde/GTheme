<?php
get_header();

if (have_posts()) { while (have_posts()) { the_post();

	if(!class_exists('GRAV_BLOCKS') || (!GRAV_BLOCKS::has_block('banner') && !GRAV_BLOCKS::has_block('custom-presentation-video')))
	{
		get_template_part('parts/single-banner');
	}

	if(class_exists('GRAV_BLOCKS'))
	{
		GRAV_BLOCKS::display();
	}
}}

get_footer();

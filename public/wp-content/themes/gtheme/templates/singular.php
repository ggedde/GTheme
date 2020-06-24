<?php
get_header();

if (have_posts()) { while (have_posts()) { the_post();

	if(!GBLOCKS::has_block('banner'))
	{
		get_template_part('parts/default-banner');
	}
	
    the_content();
  
}}

get_footer();

<?php
get_header();

if (have_posts()) { while (have_posts()) { the_post();

	if(!GBLOCKS::has_block('banner'))
	{
		get_template_part('parts/single-banner');
	}

	echo get_field('sub_title');

	?>
	
	<?php the_content(); ?>
	<?php
}}

get_footer();

<?php
get_header();

if (have_posts()) { while (have_posts()) { the_post();

	if(!GBLOCKS::has_block('banner'))
	{
		get_template_part('parts/single-banner');
	}

	?>
	<div class="row">
		<div class="col">
			<?php the_content(); ?>
		</div>
	</div>
	<?php
}}

get_footer();

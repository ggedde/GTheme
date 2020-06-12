<?php
/*
*	Template Name: Styles
*/
get_header();

if (have_posts()) { while (have_posts()) { the_post();

	if(!GBLOCKS::has_block('banner'))
	{
		get_template_part('parts/default-banner');
	}

	GBLOCKS::display();

	?>
	<section class="section-container">
		<div class="row section-inner">
			<div class="col p-5">
				<?php get_template_part( 'parts/styles' ); ?>
			</div>
			<div class="col p-4 bg-dark text-light">
				<?php get_template_part( 'parts/styles' ); ?>
			</div>
		</div>
	</section>

	<?php
}}

get_footer();

<?php
/*
*	Template Name: Blog
*/
get_header();
?>
	<h1><?php echo FUNC::get_current_page_title();?></h1>

		<?php

		if(have_posts())
		{
			while(have_posts())
			{
				the_post();
				get_template_part('entry');
			}

			?>

			<div class="page-navi">
				<?php FUNC::pagination(); ?>
			</div>

		<?php
		}
		else
		{
		?>

			<div class="post">
		    	<?php get_template_part('parts/not-found');?>
			</div>

		<?php
		}
		
get_footer();
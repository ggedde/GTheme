<?php
/*
*	Template Name: Blog
*/
get_header();

get_template_part('parts/default-banner');

?>
<div class="row section-container archive-items">
	<div class="col">
		<?php
		if (have_posts())
		{ 
			while(have_posts()) { the_post();
				get_template_part('parts/post');
			} 
			?>
			<div class="page-navi">
				<?php FUNC::pagination(); ?>
			</div>

			<?php } else { ?>

			<div class="post">
				<?php get_template_part('parts/not-found');?>
			</div>
		<?php
		}
		?>
	</div>
</div>

<?php
get_footer();

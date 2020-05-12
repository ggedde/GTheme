<?php
/*
*	Template Name: Archive
*/
get_header();

$blog_page_id = get_option('page_for_posts');

if(is_home())
{
	if($blog_page_id)
	{
		$image = (has_post_thumbnail($blog_page_id) ? get_post_thumbnail_id($blog_page_id) : 0);
	}

	if(function_exists('get_field'))
	{
		if(empty($image))
		{
			$image = get_field('theme_options_post_banner_image', 'option');
		}
		if(empty($image))
		{
			$image = get_field('theme_options_default_banner_image', 'option');
		}
	}
}

if(!empty($image))
{
	?>
	<div class="single-banner-container">
	    <div class="single-banner" <?= GBLOCKS::image_sources($image);?>>
	    </div>
	</div>
	<?php
}
?>


<section class="block-bg-none block-container block-title block-options-padding-remove-top" aria-label="Title">

	<div class="block-inner">
		<div class="row">
			<div class="columns small-12">
				<h1 class="page-title" style="text-align:center;"><?= FUNC::get_current_page_title();?></h1>
			</div>
		</div>
	</div>

</section>

<?php
if(is_home() && $blog_page_id)
{
	GBLOCKS::display(array(
		'object' => $blog_page_id
	));
}
?>

<div class="archive-items">

	<?php 
	
	if (have_posts()) 
	{ 
		while (have_posts()) 
		{ 
			the_post(); 

			$image = (has_post_thumbnail() ? get_post_thumbnail_id() : (function_exists('get_field') ? get_field('theme_options_default_post_image', 'option') : ''));
			
			?>

			<div class="row item">

				<?php if(!empty($image)){ ?>
					<div class="item-image-container columns small-12 medium-5 large-4">
						<a href="<?php the_permalink();?>" title="<?php the_title();?>" aria-label="<?php the_title();?>">
							<div class="item-image" <?= GBLOCKS::image_sources($image);?>></div>
						</a>
					</div>
				<?php } ?>

				<div class="item-content-container columns small-12 medium-<?php echo (!empty($image) ? 7 : 12);?> large-<?php echo (!empty($image) ? 8 : 12);?>">
					<h3><a class="item-title" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
					<p class="item-content"><?php echo wp_trim_words( get_the_excerpt());?></p>
					<div class="read-more">
						<a href="<?php the_permalink();?>" aria-label="Go to <?php the_title();?>">Read the Full Article ></a>
					</div>
				</div>

			</div>

			<?php 
		} 

		get_template_part( 'parts/pagination' );

	}
	else
	{
		?>

		<div class="post">

			<?php get_template_part('parts/not-found');?>

		</div>

		<?php 
	}
?>

</div>

<?php 

get_footer();
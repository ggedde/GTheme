<?php

$image = get_field('custom_banner_image');

if(!$image)
{
	$image = (has_post_thumbnail() ? get_post_thumbnail_id() : get_field('theme_options_default_banner_image', 'option'));
}

?>
<div class="single-banner-container">
    <div class="single-banner" <?php echo GRAV_BLOCKS::image_sources($image);?>>
		<h1 class="single-banner-title"><?php the_title();?></h1>
	</div>
</div>

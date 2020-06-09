<?php

$image = function_exists('get_field') ? get_field('custom_banner_image') : '';

if(!$image)
{
	$image = (has_post_thumbnail() ? get_post_thumbnail_id() : (function_exists('get_field') ? get_field('theme_options_default_banner_image', 'option') : ''));
}

if(!empty($image['sizes']['xlarge'])) {
	$image = $image['sizes']['xlarge'];
} else if (!empty($image[0])) {
	$image = $image[0];
}

?>
<div class="single-banner-container">
    <div class="single-banner" style="background-image: url('<?= $image;?>');">
		<h1 class="single-banner-title"><?php the_title();?></h1>
	</div>
</div>

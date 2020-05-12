<?php
/*
GBlock Handler Template

Available Variables:
$block_name
$block_attributes
$block_container_attributes
$block_background_image_src_preload

*/

?>

<section <?php echo $block_container_attributes; ?>>

	<?php
	if(!empty($block_background_image_src_preload))
	{
		?>
		<img class="block-image-preloader" src="<?php echo $block_background_image_src_preload;?>" style="width:0;height:0;display:none;"/>
		<?php
	}
	?>

	<?php GBLOCKS::get_block($block_name, $block_variables, $block_attributes); ?>

</section>

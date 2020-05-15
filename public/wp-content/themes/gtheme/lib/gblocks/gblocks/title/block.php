<?php

$heading = !empty($block_attributes['is_wp_block']) ? get_field('title') : get_sub_field('title');
$sub_heading = !empty($block_attributes['is_wp_block']) ? get_field('sub-title') : get_sub_field('sub-title');
$center = !empty($block_attributes['is_wp_block']) ? get_field('center') : get_sub_field('center');

if($heading || $sub_heading)
{
?>
	<div class="block-inner">
		<div class="<?php echo GBLOCKS::css()->row()->get();?><?php if($center){?> justify-content-center<?php } ?>">
			<div class="<?php echo GBLOCKS::css()->col()->get();?>">
				<?php if($heading){ ?>
				<div class="item-title h2 <?= $sub_heading ? 'has-sub-title' : '';?>"<?php if($center){?> style="text-align:center;"<?php } ?>>
					<?php echo $heading; ?>
				</div>
				<?php } ?>
				<?php if($sub_heading){ ?>
					<div class="item-sub-title h3"<?php if($center){?> style="text-align:center;"<?php } ?>>
						<?php echo $sub_heading; ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
}

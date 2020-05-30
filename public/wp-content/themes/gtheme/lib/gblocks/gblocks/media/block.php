<?php
$image = isset($image) ? $image : GBLOCKS::getField($block.'_image');
$padding = isset($padding) ? $padding : GBLOCKS::getField($block.'_padding');
$link = isset($link) ? $link : GBLOCKS::get_link_url($block.'_link');
$link_type = isset($link_type) ? $link_type : GBLOCKS::getField($block.'_link_type');
?>
<?php if ($image){ ?>
	<div class="block-inner <?= $padding ? 'p-4 p-md-5' : 'p-0';?>">
		<div class="<?= $padding ? 'row' : 'full-width-image';?>">
			<?php if($padding){ ?><div class="colfull-width-image-padded"><?php } ?>
				<?php if($link){ ?><a class="block-link-<?php echo esc_attr($link_type);?>" href="<?php echo esc_url($link); ?>"><?php } ?>
					<?php echo GBLOCKS::image($image);?>
				<?php if($link){ ?></a><?php } ?>
			<?php if($padding){ ?></div><?php } ?>
		</div>
	</div>
<?php 
}
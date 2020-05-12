<?php
$padding = get_sub_field('padding');
?>
<?php if($image = get_sub_field('full_width_image')){ ?>
	<div class="block-inner">
		<div class="<?php if($padding){ echo GBLOCKS::css()->row()->get(); } else { echo "block-full-width-image"; } ?>">
			<?php if($padding){ ?><div class="columns small-12 padded"><?php } ?>
				<?php if($link = GBLOCKS::get_link_url('link')){ ?>
					<a class="block-link-<?php echo esc_attr(get_sub_field('link_type'));?>" href="<?php echo esc_url($link); ?>">
				<?php } ?>

					<?php echo GBLOCKS::image($image);?>

				<?php if($link){ ?>
					</a>
				<?php } ?>
			<?php if($padding){ ?></div><?php } ?>
		</div>
	</div>
<?php } ?>

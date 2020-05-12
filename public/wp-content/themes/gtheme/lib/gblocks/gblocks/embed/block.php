<?php

if($embed = get_sub_field('custom_embed'))
{
	?>
	<div class="block-inner">
		<div class="<?php echo GBLOCKS::css()->row()->get();?>">
			<div class="<?php echo GBLOCKS::css()->col(12)->get();?>">
				<?php echo $embed; ?>
			</div>
		</div>
	</div>
	<?php
}
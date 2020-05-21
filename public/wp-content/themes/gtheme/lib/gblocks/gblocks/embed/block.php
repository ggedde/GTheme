<?php

if($embed = GBLOCKS::getField($block.'_custom_embed'))
{
	?>
	<div class="block-inner">
		<div class="row">
			<div class="col">
				<?php echo $embed; ?>
			</div>
		</div>
	</div>
	<?php
}
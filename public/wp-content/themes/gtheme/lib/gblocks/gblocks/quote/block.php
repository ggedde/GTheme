<?php

$quote = isset($quote) ? $quote : GBLOCKS::getField($block.'_quote');
$image = isset($image) ? $image : GBLOCKS::getField($block.'_image');
$attribution_title = isset($attribution_title) ? $attribution_title : GBLOCKS::getField($block.'_attribution_title');
$attribution_sub_title = isset($attribution_sub_title) ? $attribution_sub_title : GBLOCKS::getField($block.'_attribution_sub_title');

if($quote) 
{ 
	?>
	<div class="block-inner">
		<div class="row <?= $image ? 'has-image' : 'no-image';?>">
			<?php if($image){?>
			<div class="col col-3 col-image d-flex align-items-center">
				<?= GBLOCKS::image($image, array(), 'img', 'large');?>
			</div>
			<?php } ?>
			<div class="col col-content">
				<blockquote class="blockquote">
					<p><?= $quote;?></p>
					<div class="item-attribution blockquote-footer">
						<cite class="item-attribution-title"><?= $attribution_title;?></cite>
						<?php if($attribution_sub_title){ ?>
							<cite class="item-attribution-sub-title"><?= $attribution_sub_title;?></cite>
						<?php } ?>
					</div>
				</blockquote>
				
			</div>
		</div>	
	</div>
	<?php
}

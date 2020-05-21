<?php

$media_type = isset($media_type) ? $media_type : GBLOCKS::getField($block.'_media_type');
$image_style = isset($image_style) ? $image_style : GBLOCKS::getField($block.'_image_style');
$image = isset($image) ? $image : GBLOCKS::getField($block.'_image');
$media_buttons = isset($media_buttons) ? $media_buttons : GBLOCKS::getField($block.'_media_buttons');
$video_url = isset($video_url) ? $video_url : GBLOCKS::getField($block.'_video_url');
$embed = isset($embed) ? $embed : GBLOCKS::getField($block.'_embed');
$video_attributes = isset($video_attributes) ? $video_attributes : GBLOCKS::getField($block.'_video_attributes');
$placement = isset($placement) ? $placement : GBLOCKS::getField($block.'_media_placement');
$media_size = isset($media_size) ? $media_size : GBLOCKS::getField($block.'_media_size');
$content = isset($content) ? $content : GBLOCKS::getField($block.'_content');
$link = isset($link) ? $link : GBLOCKS::get_link_url(str_replace('-','_',$block).'_link');
$link_type = isset($link_type) ? $link_type : GBLOCKS::getField(str_replace('-','_',$block).'_link_type');

?>

<div class="block-inner media-placement-<?= $placement;?> media-type-<?= $media_type;?> media-size-<?= $media_size;?>">
	<div class="row">
		<div class="col-12 col-md-<?= $media_size;?> d-flex align-items-center <?= $placement === 'right' ? 'order-md-1' : '';?> col-media<?= (!empty($image_style) ? ' image-style-'.$image_style : '');?>">
			<?php if($link){ ?>
				<a class="block-link-<?= esc_attr($link_type);?>" href="<?= esc_url($link); ?>">
			<?php } ?>

			<div class="media-container">
				<?php if($media_type === 'video' && $video_url){ ?>
					<video src="<?= $video_url;?>" <?= implode(' ', $video_attributes);?>></video>
				<?php } ?>

				<?php if($media_type === 'embed'){ ?>
					<?= $embed;?>
				<?php } ?>

				<?php if($media_type === 'image'){ ?>
					<?= GBLOCKS::image($image, array(), 'img', 'large');?>
				<?php } ?>

				<?php
				if($media_buttons)
				{
					?>
					<div class="block-media-buttons block-buttons">
						<?php
						foreach($media_buttons as $button)
						{
							if(!empty($button['button_'.$button['button_type']]))
							{
								$link = $button['button_'.$button['button_type']];

								if($button['button_type'] === 'video')
								{
									$link = GBLOCKS::get_video_url($link);
								}
							}
							else
							{
								$link = '#';
							}

							if($button['button_type'] && $button['button_type'] != 'none'){
							?>

							<a class="<?= (!empty($button['button_style']) ? $button['button_style'].' ' : '');?>block-link-<?= esc_attr($button['button_type']);?>" href="<?= esc_url($link);?>"><?= esc_html($button['button_text']);?></a>

							<?php
							}
						}

						?>
					</div>
					<?php
				}
				?>

			</div>

			<?php if($link){ ?>
				</a>
			<?php } ?>
		</div>
		<div class="col col-content d-flex align-items-center">
			<?= $content; ?>
		</div>
	</div>
</div>

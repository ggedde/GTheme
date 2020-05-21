<?php

$buttons = isset($buttons) ? $buttons :GBLOCKS::getField($block.'_buttons');
$title = isset($title) ? $title :GBLOCKS::getField($block.'_title');
$description = isset($description) ? $description :GBLOCKS::getField($block.'_description');
$form = isset($form) ? $form :GBLOCKS::getField($block.'_form');
$alignment = isset($alignment) ? $alignment :GBLOCKS::getField($block.'_alignment');

if($title || $description || $buttons || $form){ ?>

	<div class="block-inner">
		<div class="row <?= $alignment;?>">
			<div class="col block-calltoaction-content">
				<?php if($title){ ?>
					<h2 class="block-title"><?= esc_html($title); ?></h2>
				<?php } ?>
				<?php if($description){ ?>
					<div class="block-description"><?= $description; ?></div>
				<?php } ?>
				<?php

				if($buttons)
				{
					?>
					<div class="block-buttons">
						<?php
						foreach($buttons as $button)
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

				if($form)
				{
					?>
					<div class="block-form">
						<?php if(function_exists('gravity_form')){ gravity_form($form, false, false, false, null, true); } ?>
					</div>
					<?php
				}

				?>
			</div>
		</div>
	</div>

<?php
}

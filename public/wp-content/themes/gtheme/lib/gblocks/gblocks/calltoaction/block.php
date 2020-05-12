<?php

$buttons = isset($buttons) ? $buttons : get_sub_field('buttons');
$title = isset($title) ? $title : get_sub_field('title');
$description = isset($description) ? $description : get_sub_field('description');
$form = isset($form) ? $form : get_sub_field('form');
$alignment = isset($alignment) ? $alignment : get_sub_field('alignment');

if($title || $description || $buttons || $form){ ?>

	<div class="block-inner">
		<div class="<?php echo GBLOCKS::css()->row()->get();?> align-center">
			<div class="<?php
					echo GBLOCKS::css()->add('block-calltoaction-content')->col(12, 8)->col_center(false, true)->text_align($alignment)->get();
				?>">
				<?php if($title){ ?>
					<h2 class="block-title"><?php echo esc_html($title); ?></h2>
				<?php } ?>
				<?php if($description){ ?>
					<div class="block-description"><?php echo $description; ?></div>
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

							<a class="button <?php echo (!empty($button['button_style']) ? $button['button_style'].' ' : '');?>block-link-<?php echo esc_attr($button['button_type']);?>" href="<?php echo esc_url($link);?>"><?php echo esc_html($button['button_text']);?></a>

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

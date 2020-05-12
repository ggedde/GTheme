<?php

$buttons = isset($buttons) ? $buttons : get_sub_field('buttons');
$title = isset($title) ? $title : (get_sub_field('use_alternate_title') ? get_sub_field('title') : get_the_title());
$sub_title = isset($sub_title) ? $sub_title : get_sub_field('sub_title');
$hide_title = isset($hide_title) ? $hide_title : get_sub_field('hide_title');
$intro = isset($intro) ? $intro : get_sub_field('intro');
$content_alignment = isset($content_alignment) ? $content_alignment : get_sub_field('content_alignment');

$audio = isset($audio) ? $audio : get_sub_field('audio');
$audio_title = isset($audio_title) ? $audio_title : get_sub_field('audio_title');
$audio_file_type = isset($audio_file_type) ? $audio_file_type : get_sub_field('audio_file_type');

$audio_url = isset($audio_url) ? $audio_url : get_sub_field('audio_'.$audio_file_type);

if (!empty($audio_url['url'])) $audio_url = $audio_url['url'];

if($title || $intro || $buttons){ ?>
<div class="block-inner">
	<div class="<?php echo GBLOCKS::css()->add('block-inner text-center')->get(); ?>">
		<div class="<?php echo GBLOCKS::css()->add('block-banner-inner-container')->row()->text_align($content_alignment)->align($content_alignment)->get();?>">
			<div class="<?php
					echo GBLOCKS::css()->add('block-banner-content')->col(12, 8)->col_center(false, true)->get();
				?>">
				<?php if($title && empty($hide_title)){ ?>
					<h1 class="block-title text-uppercase text-border-blue title"><?php echo GBLOCKS::allow_br(esc_html($title)); ?></h1>
				<?php if($sub_title){ ?><br/><?php } ?>
				<?php } ?>
				<?php if($sub_title){ ?>
					<h2 class="title block-sub-title"><?php echo GBLOCKS::allow_br(esc_html($sub_title)); ?></h2>
				<?php } ?>
				<?php if($intro){ ?>
					<div class="block-intro"><?php echo $intro; ?></div>
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
									<a class="btn btn-lg btn-white-border btn-blue-light-border-bg-transparent mt-4 <?php echo (!empty($button['button_style']) ? $button['button_style'].' ' : '');?>block-link-<?php echo esc_attr($button['button_type']);?>" href="<?php echo esc_url($link);?>"><?php echo esc_html($button['button_text']);?></a>
								<?php
								}
							}

							?>
						</div>
						<?php
					}
					?>
			</div>

		</div>
	</div>
</div>

<?php
}

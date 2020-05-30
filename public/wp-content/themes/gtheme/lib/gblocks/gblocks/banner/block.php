<?php

if(get_the_ID()) {
	$postId = get_the_ID();
} elseif (!empty($_POST['post_id'])) {
	$postId = $_POST['post_id'];
}

$buttons = isset($buttons) ? $buttons : GBLOCKS::getField($block.'_buttons');
$use_alternate_title = isset($use_alternate_title) ? $use_alternate_title : GBLOCKS::getField($block.'_use_alternate_title');
$title = isset($title) ? $title : GBLOCKS::getField($block.'_title');
$title = !empty($title) ? $title : get_the_title($postId);

$sub_title = isset($sub_title) ? $sub_title : GBLOCKS::getField($block.'_sub_title');
$hide_title = isset($hide_title) ? $hide_title : GBLOCKS::getField($block.'_hide_title');
$intro = isset($intro) ? $intro : GBLOCKS::getField($block.'_intro');
$content_alignment = isset($content_alignment) ? $content_alignment : GBLOCKS::getField($block.'_content_alignment');

if($title || $intro || $buttons){ ?>
<div class="block-inner">
	<div class="row block-banner-inner-container <?= $content_alignment;?> py-5 align-items-center min-vh-25">
		<div class="col block-banner-content">
			<?php if($title && empty($hide_title)){ ?>
				<h1 class="block-title text-uppercase"><?= GBLOCKS::allow_br(esc_html($title)); ?></h1>
			<?php } ?>
			<?php if($sub_title){ ?>
				<h2 class="block-sub-title mt-3"><?= GBLOCKS::allow_br(esc_html($sub_title)); ?></h2>
			<?php } ?>
			<?php if($intro){ ?>
				<div class="block-intro mt-3"><?= $intro; ?></div>
			<?php } ?>

			<?php if($buttons){ ?>
				<div class="block-buttons mt-4">
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
			<?php } ?>
		</div>
	</div>
</div>

<?php
}

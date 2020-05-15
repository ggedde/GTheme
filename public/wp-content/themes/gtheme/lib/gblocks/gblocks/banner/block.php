<?php

global $post;

if(get_the_ID()) {
	$postId = get_the_ID();
} elseif (!empty($_POST['post_id'])) {
	$postId = $_POST['post_id'];
}



$buttons = isset($buttons) ? $buttons : (!empty($block_attributes['is_wp_block']) ? get_field('expand_first_item') : get_sub_field('buttons'));
$use_alternate_title = isset($use_alternate_title) ? $use_alternate_title : (!empty($block_attributes['is_wp_block']) ? get_field('use_alternate_title') : get_sub_field('use_alternate_title'));
$title = isset($title) ? $title : ($use_alternate_title ? (!empty($block_attributes['is_wp_block']) ? get_field('title') : get_sub_field('title')) : get_the_title($postId));
$sub_title = isset($sub_title) ? $sub_title : (!empty($block_attributes['is_wp_block']) ? get_field('sub_title') : get_sub_field('sub_title'));
$hide_title = isset($hide_title) ? $hide_title : (!empty($block_attributes['is_wp_block']) ? get_field('hide_title') : get_sub_field('hide_title'));
$intro = isset($intro) ? $intro : (!empty($block_attributes['is_wp_block']) ? get_field('intro') : get_sub_field('intro'));
$content_alignment = isset($content_alignment) ? $content_alignment : (!empty($block_attributes['is_wp_block']) ? get_field('content_alignment') : get_sub_field('content_alignment'));

if($title || $intro || $buttons){ ?>
<div class="block-inner">
	<div class="<?= GBLOCKS::css()->add('block-inner text-center')->get(); ?>">
		<div class="<?= GBLOCKS::css()->add('block-banner-inner-container')->row()->text_align($content_alignment)->align($content_alignment)->get();?>">
			<div class="<?= GBLOCKS::css()->add('block-banner-content')->col(12, 8)->col_center(false, true)->get();?>">
				<?php if($title && empty($hide_title)){ ?>
					<h1 class="block-title text-uppercase text-border-blue title"><?= GBLOCKS::allow_br(esc_html($title)); ?></h1>
				<?php if($sub_title){ ?><br/><?php } ?>
				<?php } ?>
				<?php if($sub_title){ ?>
					<h2 class="title block-sub-title"><?= GBLOCKS::allow_br(esc_html($sub_title)); ?></h2>
				<?php } ?>
				<?php if($intro){ ?>
					<div class="block-intro"><?= $intro; ?></div>
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
									<a class="btn btn-lg btn-white-border btn-blue-light-border-bg-transparent mt-4 <?= (!empty($button['button_style']) ? $button['button_style'].' ' : '');?>block-link-<?= esc_attr($button['button_type']);?>" href="<?= esc_url($link);?>"><?= esc_html($button['button_text']);?></a>
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

<?php
$foundation_version = GBLOCKS::get_foundation_version();
$f6 = (strpos($foundation_version, 'f6') === false) ? false: true;

$block_format = isset($block_format) ? $block_format : get_sub_field('format');
$block_format = $block_format ? $block_format : 'grid'; // Set Defualt

$block_title = get_sub_field('grid_title');

$num_columns_small =  isset($num_columns_small)  ? $num_columns_small  : (get_sub_field('num_columns_small')  ? get_sub_field('num_columns_small')  : 1); // Set Defaults for older Plugin Versions
$num_columns_medium = isset($num_columns_medium) ? $num_columns_medium : (get_sub_field('num_columns_medium') ? get_sub_field('num_columns_medium') : 2); // Set Defaults for older Plugin Versions
$num_columns_large =  isset($num_columns_large)  ? $num_columns_large  : (get_sub_field('num_columns_large')  ? get_sub_field('num_columns_large')  : 4); // Set Defaults for older Plugin Versions
$num_columns_xlarge = isset($num_columns_xlarge) ? $num_columns_xlarge : (get_sub_field('num_columns_xlarge') ? get_sub_field('num_columns_xlarge') : 6); // Set Defaults for older Plugin Versions

$grid_class = '';
if($block_format !== 'slider')
{
	$grid_class = ' ';
}

if($gallery_items = get_sub_field('gallery_items')){ ?>
	<div class="block-inner block-grid-format-<?php echo $block_format;?>">

		<?php if($block_title){?>
			<div class="block-title"><?php echo $block_title;?></div>
		<?php } ?>
		
		<div class="block-media-items-container"
			data-columns-small="<?php echo $num_columns_small;?>"
			data-columns-medium="<?php echo $num_columns_medium;?>"
			data-columns-large="<?php echo $num_columns_large;?>"
			data-columns-xlarge="<?php echo $num_columns_xlarge;?>">

			<div class="row">
				<div class="col">
					<ul class="media-items <?= $grid_class;?>">
						<?php
						if($gallery_items)
						{
							while(has_sub_field('gallery_items'))
							{
								$image = get_sub_field('item_image');
								$title = get_sub_field('item_title');

								$link = GBLOCKS::get_link_url('link');

								$link_type = get_sub_field('link_type');


								if(!empty($image['url']) && $block_format === 'gallery')
								{
									$link = (!empty($image['sizes']['xlarge']) ? $image['sizes']['xlarge'] : $image['url']);
									$link_type = 'gallery';
								}

								?>
								<?php if($f6){ ?><div class="columns media-item"><?php } else { ?><li><?php } ?>
									<?php if($link){ ?>
										<a class="block-link-<?php echo esc_attr($link_type);?> item-link gallery-<?php echo GBLOCKS::$block_index;?>" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($image['alt']); ?>">
									<?php } ?>
									<div class="media-item-container">

										<?php if($image){ ?>
											<div class="item-image-container">
												<div class="item-image">
													<?php echo GBLOCKS::image($image);?>
												</div>
											</div>
										<?php } ?>

										<?php if($title){ ?>
											<h3 class="item-title"><span><?php echo $title; ?></span></h3>
										<?php } ?>
										<?php if($content = get_sub_field('item_content')){ ?>
											<p class="item-content"><span><?php echo $content; ?></span></p>
										<?php } ?>
									</div>
									<?php if($link){ ?>
										</a>
									<?php } ?>
								<?php if($f6){ ?></div><?php } else { ?></li><?php } ?>
							<?php }
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>

<?php
}

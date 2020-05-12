<?php
if($quotes = get_sub_field('quotes'))
{
	$count = count($quotes);
	?>
	<div class="block-inner">
		<div class="<?php echo GBLOCKS::css()->row()->get();?>">
			<div class="<?php echo GBLOCKS::css()->col()->add('items-container')->add('items-count-'.$count)->get();?>">
				<div class="<?php echo GBLOCKS::css()->add('items')->get();?>">

					<?php
					while(has_sub_field('quotes'))
					{
						$image = get_sub_field('image');
						?>
						<div class="<?php echo GBLOCKS::css()->add('item')->get();?>">
							<div class="<?php echo GBLOCKS::css()->add(($image ? 'has-image' : 'no-image'))->row()->get();?>">
								<?php if($image){?>
								<div class="<?php echo GBLOCKS::css()->add('item-image, flex, align-middle, align-center')->col(12, 6)->get();?>">
									<?php //echo GBLOCKS::image($image);?>
									<img src="<?php echo esc_attr($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
								</div>
								<?php } ?>
								<div class="<?php echo GBLOCKS::css()->add('item-content')->col(12, 6)->get();?>">
									<blockquote>
										<p><?php the_sub_field('quote');?></p>
									</blockquote>
									<div class="<?php echo GBLOCKS::css()->add('item-attribution')->get();?>">
										<cite class="<?php echo GBLOCKS::css()->add('item-attribution-title')->get();?>"><?php the_sub_field('attribution');?></cite>
										<?php if($attribution_sub_title = get_sub_field('attribution_sub_title')){ ?>
											<cite class="<?php echo GBLOCKS::css()->add('item-attribution-sub-title')->get();?>"><?php echo $attribution_sub_title;?></cite>
										<?php } ?>
									</div>
								</div>
							</div>
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

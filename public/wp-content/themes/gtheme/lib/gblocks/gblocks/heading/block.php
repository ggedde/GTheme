<?php

$heading = isset($alignment) ? $alignment : GBLOCKS::getField($block.'_heading');
$sub_heading = isset($alignment) ? $alignment : GBLOCKS::getField($block.'_sub_heading');
$alignment = isset($alignment) ? $alignment : GBLOCKS::getField($block.'_alignment');

if($heading || $sub_heading)
{
?>
	<div class="block-inner">
		<div class="row <?= $alignment;?>">
			<div class="col">
				<?php if($heading){ ?>
				<div class="block-title h2 <?= $sub_heading ? 'has-sub-title' : '';?>">
					<?php echo $heading; ?>
				</div>
				<?php } ?>
				<?php if($sub_heading){ ?>
					<div class="block-sub-title h4">
						<?php echo $sub_heading; ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
}

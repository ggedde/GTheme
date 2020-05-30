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
				<h2 class="block-title<?= $sub_heading ? ' has-sub-title mb-2' : '';?>">
					<?php echo $heading; ?>
				</h2>
				<?php } ?>
				<?php if($sub_heading){ ?>
					<h4 class="block-sub-title">
						<?php echo $sub_heading; ?>
					</h4>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
}

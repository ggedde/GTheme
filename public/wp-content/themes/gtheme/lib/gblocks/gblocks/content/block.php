<?php

$columns = GBLOCKS::getField($block.'_columns');

?>
<div class="block-inner num-col-<?= count($columns); ?>">
	<div class="row">
		<?php foreach ($columns as $column) { ?>
			<div class="col-sm">
				<?= $column['content']; ?>
			</div>
		<?php } ?>
	</div>
</div>


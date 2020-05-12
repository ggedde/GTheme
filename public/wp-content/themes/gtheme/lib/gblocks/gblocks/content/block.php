<?php

if($column_num = get_sub_field('num_columns')){
	$cols_span = (12/$column_num);
	$cols_span = apply_filters('gblock_content_columns', $cols_span);
	$medium_col = $column_num < 3 ? $cols_span : 12;
	$large_col = $column_num >= 2 ? $cols_span : 12;
	$xlarge_col = $column_num >= 2 ? $cols_span : 12;

	$offset_small = null;
	$offset_medium = null;
	$offset_large = null;
	$offset_xlarge = null;

	if($column_num == 2)
	{
		$xlarge_col-= 2;
		$large_col-= 1;
		$offset_large = 1;
		$offset_xlarge = 1;
	}

	if($column_num == 1)
	{
		$xlarge_col-= 4;
		$large_col-= 2;
		$offset_large = 2;
		$offset_xlarge = 2;
	}

	$sidebar = ($column_num == 2) ? get_sub_field('format') : '';

?>
	<div class="block-inner num-col-<?php echo $column_num; ?> <?php echo $sidebar; ?>">
		<div class="<?php echo GBLOCKS::css()->row()->add('justify-content-center')->get();?>">
		<?php
			for( $i = 1; $i <= $column_num; $i++ ) {
				if($sidebar != '' && $column_num == 2){
					if($i == 1){
						$medium_col = ($sidebar == 'format-sidebar-left') ? 4 : 12;
						$large_col = ($sidebar == 'format-sidebar-left') ? 4 : 8;

					} else {
						$medium_col = ($sidebar == 'format-sidebar-left') ? 12 : 4;
						$large_col = ($sidebar == 'format-sidebar-left') ? 8 : 4;
					}
				}
				?>
				<div class="<?php echo GBLOCKS::css()->col(12, $medium_col, $large_col, $xlarge_col)->col_offset($offset_small, $offset_medium, ($i == 1 ? $offset_large : null), ($i == 1 ? $offset_xlarge : null))->add('col-content')->get(); ?>">
					<?php the_sub_field('column_'.$i); ?>
				</div>
		<?php } ?>
		</div>
	</div>
<?php
}

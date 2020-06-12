<div class="row page-navi-container">
	<div>
		<?php if (class_exists('FUNC') && method_exists('FUNC', 'page_navi')) {?>
		<div class="col-12">
			<div class="page-navi"><?php FUNC::pagination();?></div>
		</div>
		<?php } else { ?>
		<div class="col-12">
			<div class="page-navi">
				<ul>
					<li class="next-link"><?php next_posts_link(__('&laquo; Older Entries'))?></li>
					<li class="prev-link"><?php previous_posts_link(__('Newer Entries &raquo;'))?></li>
				</ul>
			</div>
		</div>
		<?php }?>
	</div>
</div>
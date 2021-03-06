<?php get_header(); 

if(!GBLOCKS::has_block('banner'))
	{
		get_template_part('parts/default-banner');
	}
	?>

	<section class="section-container">
		<div class="section-inner">
			<div class="row">
				<div class="col">
					<p>We're sorry, the page you requested cannot be found.</p>

					<p>If you typed the URL yourself, please make sure that the spelling is correct. <br />

					If you clicked on a link to get here, there may be a problem with the link. <br />

					Try using your browser's "Back" button or the "Return to previous page" link below to choose a different link on that page, or use search to find what you are looking for.</p>

					<p>We apologize for the inconvenience!</p>

					<p><a href="javascript:history.back();">&raquo; Return to previous page</a></p>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>

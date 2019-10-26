		</main> <?php // end .global-content ?>

		<footer class="global-footer bg-gray-dark">
			<div class="row">
				<div class="columns small-12 medium-5 large-6 col-logo">
					<?php if($logo = (function_exists('get_field') ? get_field('theme_options_footer_logo', 'option') : '')){?>
						<img class="footer-logo" src="<?php echo $logo['sizes']['large'];?>" alt="<?php echo $logo['alt'];?>">
					<?php } ?>
					<div class="footer-social-links">
						<h3 class="footer-social-title">
							<?php if(function_exists('the_field')){the_field('footer_social_title', 'option', false);} ?>
						</h3>
						<?php get_template_part('parts/social-links');?>
					</div>
				</div>
				<div class="columns small-12 medium-7 large-6 col-menu">
					<nav class="global-footer-main-menu">
						<?php FUNC::menu('footer-menu'); ?>
					</nav>
				</div>
			</div>

			<div class="copyright-row">
				<div class="copyright-container">
					<div class="row">
						<div class="columns small-12 medium-7 col-copyright">
							<p>&copy; <?php echo date('Y');?> <?php if(function_exists('the_field')){the_field('copyright_text', 'option', false);} ?></p>
						</div>
					</div>
				</div>
			</div>

		</footer>

	</section>

	<?php wp_footer(); ?>

	<?php if(function_exists('the_field')){the_field('global_body_bottom_content', 'option', false);} ?>

</body>
</html>

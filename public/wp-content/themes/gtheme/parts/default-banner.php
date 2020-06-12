<?php

global $post;

if(is_singular())
{
	if ($attachment_id = get_post_thumbnail_id(get_the_ID())) {
		if ($headerimg = wp_get_attachment_image_url( $attachment_id, 'large' )) {
			$headerimg_srcset = wp_get_attachment_image_srcset( $attachment_id, 'large' );
		}
	}
}

if(is_home() && get_option('page_for_posts'))
{
	if ($attachment_id = get_post_thumbnail_id(get_option('page_for_posts'))) {
		if ($headerimg = wp_get_attachment_image_url( $attachment_id, 'large' )) {
			$headerimg_srcset = wp_get_attachment_image_srcset( $attachment_id, 'large' );
		}
	}
}

if (empty($headerimg)) {
	if ($defaultBannerImage = get_field('theme_options_default_banner_image', 'option')) {			
		$headerimg = $defaultBannerImage['sizes']['large'];
	}
}

?>

<section class="banner-container block-bg-blur block-bg-overlay position-relative overflow-hidden d-flex justify-content-center align-items-center <?php echo (get_field('hide_banner_image') && is_singular() ? ' hide-banner-image' : '');?>">
	<div class="block-bg-image-container">
		<img src="<?php echo esc_url( $headerimg ); ?>" class="img-responsive fit-image" <?php if (!empty($headerimg_srcset)){ ?>srcset="<?php echo esc_attr( $headerimg_srcset ); ?>"<?php } ?> alt="<?php get_the_title();?>">
	</div>
 	<div class="heading">
	 	<div class="row">
			<div class="col text-center text-light">
				<?php if (is_home() || is_singular('post')) { ?>
					<h1>Blog</h1>
				<?php } elseif (is_singular('glossary')) { ?>
					<h1>Term</h1>
				<?php } elseif (is_search()) { ?>
					<h1>Search Results: <?php echo the_search_query(); ?></h1>
				<?php } elseif (is_category()) { ?>
					<h1 class="archive-title">
						<?php _e('Category:'); ?> <?php single_cat_title(); ?>
					</h1>
				<?php } elseif (is_archive()) { ?>
					<h1 class="page-title"><?php echo post_type_archive_title();?></h1>
				<?php } elseif (is_tag()) { ?>
					<h1><?php _e('Posts Tagged:'); ?> <?php single_tag_title(); ?></h1>
				<?php } elseif (is_post_type_archive('testimonials')) { ?>
					<h1>Reviews &amp; Testimonials</h1>
				<?php } elseif (get_post_type() === 'products_myga') { ?>
					<h1>Multi-Year Guarantee Annuity Details</h1>
				<?php } elseif (get_post_type() === 'products_fixed') { ?>
					<h1>Traditional Fixed Annuity Details</h1>
				<?php } elseif (get_post_type() === 'products_indexed') { ?>
					<h1>Fixed Indexed Annuity Details</h1>
				<?php } elseif (get_post_type() === 'insurance-companies') { ?>
					<h1>Insurance Company Details</h1>
				<?php } elseif (is_404()) { ?>
					<h1>404 - Not Found</h1>
				<?php } elseif (is_front_page()) { ?>
					<h1 class="text-center">The Easy, Informed Way to Buy Annuities</h1>
				<?php } else { ?>
					<h1><?php the_title();?></h1>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="block-bg-overlay-container"></div>
</section>

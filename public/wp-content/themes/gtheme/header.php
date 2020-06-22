<!DOCTYPE html>
<html <?php language_attributes();?>>

<head>
	<?php
        if (function_exists('the_field')) {
            the_field('global_head_top_content', 'option', false);
        }
    ?>

	<title><?php bloginfo("name");?><?php wp_title('&bull;');?>
	</title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type');?>; charset=<?php bloginfo('charset');?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="application-name" content="<?php bloginfo('name');?>">

	<link rel="pingback" href="<?php bloginfo('pingback_url');?>">

	<?php wp_head();?>

	<?php
        if (function_exists('the_field')) {
            the_field('global_head_bottom_content', 'option', false);
        }
    ?>

</head>



<body id="body" <?php body_class('site-' . get_current_blog_id());?>>

	<?php
        if (function_exists('the_field')) {
            the_field('global_body_top_content', 'option', false);
        }
    ?>

	<section class="global-wrapper">
		<header class="global-header light-text">
			<div class="row h-100 m-auto">
				<div class="col-4 global-header-logo-col h-100">
					<a href="<?php echo site_url(); ?>" class="h-100" title="<?php echo bloginfo('name'); ?>">
						<div class="global-header-logo h-100">
							<?php if ($logo = (function_exists('get_field') ? get_field('theme_options_logo', 'option') : '')) {?>
							<img class="mh-100 m-0" src="<?php echo $logo['sizes']['large']; ?>" alt="<?php echo $logo['alt']; ?>">
							<?php }?>
						</div>
					</a>
				</div>
				<div class="col align-items-center justify-content-end d-none d-lg-flex">
					<nav class="nav global-header-main-menu">
						<?php FUNC::menu('main-menu');?>
					</nav>
				</div>
				<div class="col-8 d-flex align-items-center justify-content-end d-lg-none">
					<button class="button-mobile-menu">
						<span></span>
					</button>
				</div>
			</div>

		</header>

		<main class="global-content">
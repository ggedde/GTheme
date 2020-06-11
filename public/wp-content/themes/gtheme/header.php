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

		<header class="global-header bg-dark sticky-top z-depth-1">

			<div class="row h-100">
				<div class="col global-header-logo-col h-100">
					<a href="<?php echo site_url(); ?>" class="h-100" title="<?php echo bloginfo('name'); ?>">
						<div class="global-header-logo h-100">
							<?php if ($logo = (function_exists('get_field') ? get_field('theme_options_logo', 'option') : '')) {?>
							<img class="mh-100" src="<?php echo $logo['sizes']['large']; ?>" alt="<?php echo $logo['alt']; ?>">
							<?php }?>
						</div>
					</a>
				</div>
				<div class="col align-items-center justify-content-end d-none d-lg-flex">
					<nav class="nav global-header-main-menu">
						<?php FUNC::menu('main-menu');?>
					</nav>
				</div>
				<div class="col d-flex align-items-center justify-content-end d-lg-none">
					<button class="button-mobile-menu">
						<span></span>
					</button>
				</div>
			</div>

			<!-- <div class="row global-header-row">

				<div class="columns small-5 medium-4 global-header-logo-column">
					<div class="global-header-logo-container">
						<a href="<?php echo site_url(); ?>" title="<?php echo bloginfo('name'); ?>">
			<div class="global-header-logo">
				<?php if ($logo = (function_exists('get_field') ? get_field('theme_options_logo', 'option') : '')) {
                    ?>
				<img src="<?php echo $logo['sizes']['large']; ?>"
					alt="<?php echo $logo['alt']; ?>">
				<?php }?>
			</div>
			</a>
			</div>
			</div>

			<div class="columns small-7 medium-8 global-header-nav-column">

				<div class="global-header-main-nav-container show-for-large">
					<?php get_template_part('parts/social-links');?>
				</div>

				<div class="row auto text-right show-for-large global-header-main-menu-container collapse">
					<div class="columns small-12">
						<nav class="global-header-main-menu">
							<?php FUNC::menu('main-menu');?>
						</nav>
					</div>
				</div>

				<button class="button-mobile-menu hide-for-large">
					<span></span>
				</button>

				<div class="columns small-12 text-center global-header-mobile-nav-container hide-for-large">

					<nav class="global-header-mobile-menu">
						<?php FUNC::menu('main-menu');?>
					</nav>

					<div class="columns small-12 text-center global-header-callout">
						<?php FUNC::menu('main-links');?>
					</div>

				</div>

			</div>
			<div class="columns small-12 language-selector">
				<a class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/es/') === false ? 'current' : ''); ?>"
					href="/">English</a> |
				<a class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/es/') !== false ? 'current' : ''); ?>"
					href="/es">Español</a>
			</div>
			</div> -->

		</header>

		<main class="global-content">
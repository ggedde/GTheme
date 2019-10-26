<?php

if (!defined('ABSPATH')) {
    exit;
}

###############################################################################
##  Includes
###############################################################################

// Includes
include_once dirname(__FILE__) . '/lib/theme-functions.class.php'; // Grav Functions
FUNC::themeInit();

add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery-core');
    wp_register_script('jquery-core', get_template_directory_uri() . '/assets/js/lib/jquery-3.3.1.min.js', array(), '3.1.1');
});

FUNC::enqueue_file('Font_Awesome', 'https://use.fontawesome.com/releases/v5.6.1/css/all.css');
FUNC::enqueue_file('bootstrap_css', get_template_directory_uri() . '/assets/dist/bootstrap.min.css');
FUNC::enqueue_file('main_css', get_template_directory_uri() . '/assets/dist/main.min.css');
FUNC::enqueue_file('master_js', get_template_directory_uri() . '/assets/dist/main.min.js');
add_editor_style(get_template_directory_uri() . '/assets/css/min/editor-style.css');

// Add Custom Post Types
// include_once 'post-types/events.php';

###############################################################################
#######################   CUSTOM THEME FUNCTIONALITY  #########################
###############################################################################

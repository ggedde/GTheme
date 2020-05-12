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

add_action( 'wp_enqueue_scripts', function () {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/assets/dist/jquery.min.js', array(), '3.4.1' );
});

FUNC::enqueue_file('vendor_css', get_template_directory_uri() . '/assets/dist/vendor.min.css');
FUNC::enqueue_file('master_css', get_template_directory_uri() . '/assets/dist/main.min.css');

add_action( 'get_footer', function() {
    wp_enqueue_style( 'fontawesome_css', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css' );
    wp_enqueue_style( 'adobefont_css', 'https://use.typekit.net/amo4teb.css' );
});

if ( empty($GLOBALS['pagenow']) || $GLOBALS['pagenow'] !== 'wp-login.php' ) {
    FUNC::enqueue_file('vendor_js', get_template_directory_uri() . '/assets/dist/vendor.min.js');
    FUNC::enqueue_file('main_js', get_template_directory_uri() . '/assets/dist/main.min.js');
}

add_editor_style(get_template_directory_uri() . '/assets/css/min/editor-style.css');
    

// Add Custom Post Types
// include_once 'post-types/events.php';

###############################################################################
#######################   CUSTOM THEME FUNCTIONALITY  #########################
###############################################################################
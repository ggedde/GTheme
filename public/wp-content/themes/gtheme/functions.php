<?php

if (!defined('ABSPATH')) {
    exit;
}

###############################################################################
##  Includes
###############################################################################

// Includes
// include_once dirname(__FILE__) . '/lib/gravityforms-mdb-styles.php'; // G Functions
include_once dirname(__FILE__) . '/lib/gfunc.class.php'; // G Functions
include_once dirname(__FILE__) . '/lib/gblocks/gblocks.php'; // Gblocks Functions
FUNC::themeInit();

add_action( 'wp_enqueue_scripts', function () {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/assets/dist/jquery.min.js', array(), '3.4.1' );
});

add_action('wp_enqueue_scripts', function(){
    FUNC::enqueue_file('vendor_css', get_template_directory_uri() . '/assets/dist/vendor.min.css');
    FUNC::enqueue_file('master_css', get_template_directory_uri() . '/assets/dist/main.min.css');
});

add_action( 'get_footer', function() {
    wp_enqueue_style( 'fontawesome_css', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css' );
});

if ( empty($GLOBALS['pagenow']) || $GLOBALS['pagenow'] !== 'wp-login.php' ) {
    add_action('wp_enqueue_scripts', function(){
        FUNC::enqueue_file('vendor_js', get_template_directory_uri() . '/assets/dist/vendor.min.js');
        FUNC::enqueue_file('main_js', get_template_directory_uri() . '/assets/dist/main.min.js');
    });
}

add_editor_style(get_template_directory_uri() . '/assets/dist/editor-styles.css?d='.filemtime(get_template_directory() . '/assets/dist/editor-styles.css'));

add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_style( 'wp-block-library' ); // WordPress core
}, 100 );

if (GBLOCKS::isGutenbergEditor()) {
    add_action( 'enqueue_block_editor_assets', function() {
        wp_enqueue_style(
            'my-block-vendor-editor-css',
            get_template_directory_uri() . '/assets/dist/vendor.min.css',
            [ 'wp-edit-blocks' ]
        );
        wp_enqueue_style(
            'my-block-editor-css',
            get_template_directory_uri() . '/assets/dist/editor-styles.css?d='.filemtime(get_template_directory() . '/assets/dist/editor-styles.css'),
            [ 'wp-edit-blocks' ]
        );
    });
}

// Add Custom Post Types
// include_once 'post-types/events.php';

###############################################################################
#######################   CUSTOM THEME FUNCTIONALITY  #########################
###############################################################################
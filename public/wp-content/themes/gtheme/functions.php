<?php

if (!defined('ABSPATH')) {
    exit;
}

###############################################################################
##  Includes
###############################################################################

// Includes
include_once dirname(__FILE__) . '/lib/gfunc.class.php'; // G Functions
include_once dirname(__FILE__) . '/lib/gblocks/gblocks.php'; // Gblocks Functions
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

add_editor_style(get_template_directory_uri() . '/assets/dist/editor-style.css');

add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style(
        'my-block-vendor-editor-css',
        get_template_directory_uri() . '/assets/dist/vendor.min.css',
        [ 'wp-edit-blocks' ]
    );
    wp_enqueue_style(
        'my-block-editor-css',
        get_template_directory_uri() . '/assets/dist/editor-style.css',
        [ 'wp-edit-blocks' ]
    );
} );
    

// Add Custom Post Types
// include_once 'post-types/events.php';

###############################################################################
#######################   CUSTOM THEME FUNCTIONALITY  #########################
###############################################################################


add_theme_support( 'editor-color-palette', array() );

if ( !class_exists('Tinymce_Advanced') ) {
    add_filter('mce_buttons', function ($buttons) {
        return [
            'styleselect',
            'bullist',
            'numlist',
            'forecolor',
            'fontsizeselect',
            'wp_help',
        ];
    }, 9);

    add_filter('mce_buttons_2', function ($buttons) {
        return [];
    }, 9);

    add_filter('tiny_mce_before_init', function ($tinymce) {    
        $style_formats = array(
            [
                'title' => 'Bold',
                'icon' => 'bold',
                'format' => 'bold'
            ],
            [
                'title' => 'Italic',
                'icon' => 'italic',
                'format' => 'italic'
            ],
            [
                'title' => 'Underline',
                'icon' => 'underline',
                'format' => 'underline'
            ],
            [
                'title' => 'Strikethrough',
                'icon' => 'strikethrough',
                'format' => 'strikethrough'
            ],
            [
                'title' => 'Superscript',
                'icon' => 'superscript',
                'format' => 'superscript'
            ],
            [
                'title' => 'Subscript',
                'icon' => 'subscript',
                'format' => 'subscript'
            ],
            [
                'title' => 'Code',
                'icon' => 'code',
                'format' => 'code'
            ],
            [
                'title' => 'Headings',
                'icon' => 'forecolor',
                'items' => [
                    [
                        'title' => 'Heading 1',
                        'format' => 'h1'
                    ],
                    [
                        'title' => 'Heading 2',
                        'format' => 'h2'
                    ],
                    [
                        'title' => 'Heading 3',
                        'format' => 'h3'
                    ],
                    [
                        'title' => 'Heading 4',
                        'format' => 'h4'
                    ],
                    [
                        'title' => 'Heading 5',
                        'format' => 'h5'
                    ],
                    [
                        'title' => 'Heading 6',
                        'format' => 'h6'
                    ]
                ]
            ],
            [
                'title' => 'Blocks',
                'icon' => 'visualblocks',
                'items' => [
                    [
                        'title' => 'Paragraph',
                        'icon' => 'visualblocks',
                        'format' => 'p'
                    ],
                    [
                        'title' => 'Paragraph Large',
                        'icon' => 'visualblocks',
                        'selector' => 'p',
                        'classes' => 'large',
                    ],
                    [
                        'title' => 'Blockquote',
                        'icon' => 'blockquote',
                        'format' => 'blockquote'
                    ],
                    [
                        'title' => 'Pre',
                        'icon' => 'code',
                        'format' => 'pre'
                    ]
                ]
            ],
            [
                'title' => 'Alignment',
                'icon' => 'drag',
                'items' => [
                    [
                        'title' => 'Left',
                        'icon' => 'alignleft',
                        'format' => 'alignleft'
                    ],
                    [
                        'title' => 'Center',
                        'icon' => 'aligncenter',
                        'format' => 'aligncenter'
                    ],
                    [
                        'title' => 'Right',
                        'icon' => 'alignright',
                        'format' => 'alignright'
                    ],
                    [
                        'title' => 'Justify',
                        'icon' => 'alignjustify',
                        'format' => 'alignjustify'
                    ],
                    [
                        'title' => 'Indent',
                        'icon' => 'indent',
                        'selector' => 'p',
                        'styles' => ['padding-left' => '40px']
                    ]
                ]
            ],
            [
                'title' => 'Buttons',
                'icon' => 'removeformat',
                'items' => [
                    [
                        'title' => 'Primary',
                        'icon' => 'removeformat',
                        'selector' => 'a',
                        'classes' => 'btn btn-primary',
                    ],
                    [
                        'title' => 'Secondary',
                        'icon' => 'removeformat',
                        'selector' => 'a',
                        'classes' => 'btn btn-secondary',
                    ],
                ],
            ],
        );

        $tinymce['style_formats_merge'] = false;
        $tinymce['style_formats'] = json_encode($style_formats);
        $tinymce['fontsize_formats'] = "10px 11px 12px 14px 16px 18px 24px 36px 42px 48px";
        $tinymce['toolbar1'] = '';
        $tinymce['toolbar2'] = '';
        $tinymce['menubar'] = true;
        $tinymce['menu'] = json_encode([
            'edit' => [
                'title' => 'Edit',
                'items' => 'undo redo | cut copy paste pastetext removeformat | selectall | tableprops deletetable cell row column wp_help'
            ],
            'insert' => [
                'title' => 'Insert',
                'items' => 'link media inserttable charmap hr'
            ]
        ]);

        return $tinymce;
    }, 9);

    add_filter( 'mce_external_plugins', function($plugin_array) {
        $plugin_array['table'] = get_template_directory_uri() .'/tmce-table.js';
        return $plugin_array;
    });
}
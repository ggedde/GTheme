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
});

if ( empty($GLOBALS['pagenow']) || $GLOBALS['pagenow'] !== 'wp-login.php' ) {
    FUNC::enqueue_file('vendor_js', get_template_directory_uri() . '/assets/dist/vendor.min.js');
    FUNC::enqueue_file('main_js', get_template_directory_uri() . '/assets/dist/main.min.js');
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

if (!is_admin()) {
    add_filter( 'gform_field_content', function($content, $field, $value, $lead_id, $form_id){
        $input = 'input_'.$form_id.'_'.$field['id'];
        $name = 'input_'.$field['id'];

        if (in_array($field['type'], ['text', 'email', 'phone'])) {
            $content = '
                <div class="md-form ginput_container ginput_container_'.$field['type'].'">
                    <input name="'.$name.'" type="'.($field['type'] === 'phone' ? 'tel' : $field['type']).'" id="'.$input.'" class="form-control" aria-required="true" aria-invalid="false">
                    <label class="gfield_label" for="'.$input.'">'.$field['label'].'</label>
                </div>
            ';
        }

        if (in_array($field['type'], ['multiselect', 'select'])) {
            $content = str_replace('gfield_select', 'custom-select gfield_select', $content);
            if (count($field['choices']) > 12) {
                $content = str_replace('<select', '<select searchable="Search..."', $content);
            }
        }

        if ($field['type'] === 'consent') {
            $content = str_replace("type='checkbox'", "type='checkbox' class='form-check-input'", $content);
        }
        
        if ($field['type'] === 'fileupload') {
            if (empty($field['multipleFiles'])) {
                $content = '
                <label class="gfield_label" for="'.$input.'">'.$field['label'].'</label>
                <div class="md-form mt-0">
                    <div class="file-field">
                        <div class="btn btn-outline-info waves-effect btn-sm float-left">
                            <span>Choose file</span>
                            '.$content.'
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload one or more files" readonly>
                        </div>
                    </div>
                </div>';
            } else {
                $content = str_replace("class='button ", "class='button btn btn-outline-info ml-2 ", $content);
            }
        }

        if ($field['type'] === 'textarea') {
            $content = '
            <div class="md-form">
                <label class="gfield_label" for="'.$input.'">'.$field['label'].'</label>
                <textarea name="'.$name.'" id="'.$input.'" class="form-control md-textarea pt-2" rows="3"></textarea>
            </div>
            ';
        }

        if ($field['type'] === 'name') {
            $content = str_replace("class='name_first'", "class='name_first md-form'", $content);
            $content = str_replace("class='name_last'", "class='name_last md-form'", $content);
            $content = '<div class="md-form">'.$content.'</div>';
        }

        if ($field['type'] === 'address') {
            $content = str_replace("address_line_1", "address_line_1 md-form", $content);
            $content = str_replace("address_line_2", "address_line_2 md-form", $content);
            $content = str_replace("address_city", "address_city md-form", $content);
            $content = str_replace("address_state", "address_state md-form d-inline-block", $content);
            $content = str_replace("address_zip", "address_zip md-form", $content);
            $content = str_replace("address_country", "address_country md-form d-inline-block", $content);
            $content = str_replace("<select", "<select class='custom-select'", $content);
            $content = '<div class="md-form">'.$content.'</div>';
        }


        if (in_array($field['type'], ['checkbox', 'radio'])) {
            $content = str_replace("<li class='", "<li class='form-check ", $content);
            $content = str_replace("type='checkbox'", "type='checkbox' class='form-check-input'", $content);
            $content = str_replace("type='radio'", "type='radio' class='form-check-input'", $content);
        }

        

        return  $content;
        
    }, 10, 5 );
}
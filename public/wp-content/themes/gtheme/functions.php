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

function updateGformButtonsWithMDB($button) {
    return str_replace("class='", "class='btn btn-primary ", $button);
};

if (!is_admin()) {
    add_filter( 'gform_field_container', function ($field_container, $field, $form, $css_class, $style, $field_content) {

        $classes = 'col-12';

        if (!empty($form['cssClass']) && strpos($form['cssClass'], 'md-form') !== false) {
            $classes.= ' form-group';
        }

        if (in_array($field['type'], ['text', 'email', 'phone', 'textarea', 'multiselect', 'select', 'number', 'website'])) {
            $classes.= $field['size'] === 'small' ? ' col-sm-4' : ($field['size'] === 'large' ? ' col-sm-12' : ' col-sm-6');
        }
        return str_replace("class='", "class='".$classes." gfield-type-".$field['type']." ", $field_container);
        
    }, 10, 6);

    add_filter( 'gform_next_button', 'updateGformButtonsWithMDB', 10 );
    add_filter( 'gform_previous_button', 'updateGformButtonsWithMDB', 10 );
    add_filter( 'gform_submit_button', 'updateGformButtonsWithMDB', 10 );

    add_filter( 'gform_field_content', function($content, $field, $value, $lead_id, $form_id){
        $id = 'input_'.$form_id.'_'.$field['id'];
        $name = 'input_'.$field['id'];
        $hasMdForm = false;

        if (class_exists('GFAPI')) {
            $form = GFAPI::get_form( $form_id );
            if (!empty($form['cssClass']) && strpos($form['cssClass'], 'md-form') !== false) {
                $hasMdForm = true;
            }
        }

        preg_match('/\<label.*\<\/label\>/m', $content, $matches);
        if (!empty($matches[0])) {
            $label = $matches[0];
        }

        preg_match('/\<input.*\>/m', $content, $matches);
        if (!empty($matches[0])) {
            $input = $matches[0];
        }

        if (in_array($field['type'], ['text', 'email', 'phone', 'number', 'website'])) {
            if (!empty($label)) {
                $content = str_replace($label, '', $content);
            }
            if (!empty($input)) {
                $content = str_replace('<input', $label.'<input', $content);
                $content = str_replace($input, str_replace("class='", "class='form-control ", $input), $content);
            }
        }

        if (in_array($field['type'], ['multiselect', 'select'])) {
            $content = str_replace('gfield_select', 'custom-select gfield_select', $content);
            if (count($field['choices']) > 12) {
                $content = str_replace('<select', '<select searchable="Search..."', $content);
            }
            $content = str_replace($content, str_replace("class='gf_placeholder", "disabled selected class='gf_placeholder", $content), $content);
        }

        if ($field['type'] === 'consent') {
            $content = str_replace("type='checkbox'", "type='checkbox' class='form-check-input'", $content);
        }
        
        if ($field['type'] === 'fileupload') {
            if (empty($field['multipleFiles'])) {
                if ($hasMdForm) {
                    $content = $label.'
                    <div class="mt-0">
                        <div class="file-field">
                            <div class="btn btn-outline-info btn-sm float-left">
                                <span class="upload-file-label">Choose file</span>
                                '.$content.'
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload one or more files" readonly>
                            </div>
                        </div>
                    </div>';
                } else {
                    $content = $label.'
                    <div class="input-group">
                        <div class="custom-file">
                            '.str_replace([$label, "type='file' class='"], ['', "type='file' class='custom-file-input "], str_replace("<span", "<label class='custom-file-label' for='".$id."'>Choose file</label><span", $content)).'
                        </div>
                    </div>';
                }
            } else {
                $content = str_replace("class='button ", "class='button btn btn-outline-info ml-2 ", $content);
            }
        }

        if ($field['type'] === 'textarea') {
            if ($hasMdForm) {
                $content = str_replace($label, '', $content);
                $content = str_replace('<textarea', $label.'<textarea', $content);
                $content = str_replace("class='textarea", "class='textarea md-textarea", $content);
            } else {
                $content = str_replace("class='textarea", "class='textarea form-control", $content);
            }
        }

        if (in_array($field['type'], ['name', 'address', 'list'])) {
            $content = str_replace("<select", "<select class='custom-select'", $content);
            if (!$hasMdForm) {
                $content = str_replace("type='text'", "type='text' class='form-control", $content);
            }
        }

        if (in_array($field['type'], ['checkbox', 'radio'])) {
            $content = str_replace("<li class='", "<li class='form-check ", $content);
            $content = str_replace("type='checkbox'", "type='checkbox' class='form-check-input'", $content);
            $content = str_replace("type='radio'", "type='radio' class='form-check-input'", $content);
        }

        

        return  $content;
        
    }, 10, 5 );
}
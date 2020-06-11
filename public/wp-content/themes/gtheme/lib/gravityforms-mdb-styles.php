<?php

function updateGformButtonsWithMDB($button) {
    return str_replace("class='", "class='btn btn-primary ", $button);
};

add_action('wp_head', function(){
    ?>
    <script>
        jQuery(document).ready(function($){
            function gFormsMdbformsRender(){

                var mdForm = $('.md-form');
                if (mdForm.length) {
                    mdForm.find('.custom-select').each(function(){
                        $(this).removeClass('custom-select').addClass('mdb-select').materialSelect();
                    });
                    mdForm.find('input, select, textarea').trigger('change');
                }

                $('.ginput_container_name input, .ginput_container_address input').each(function(){
                    if ($(this).val()) {
                        $(this).closest('li.gfield').find('label').addClass('active');
                    }
                })
                $('.ginput_container_name input, .ginput_container_address input').on('focus', function(){
                    $(this).closest('li.gfield').find('label').addClass('active');
                });

                if (typeof bsCustomFileInput !== 'undefined') {
                    bsCustomFileInput.init();
                }
        
                var inputs = [
                    'form.bootstrap.nested-labels .ginput_container_text input',
                    'form.bootstrap.nested-labels .ginput_container_email input',
                    'form.bootstrap.nested-labels .ginput_container_phone input',
                    'form.bootstrap.nested-labels .ginput_container_number input',
                    'form.bootstrap.nested-labels .ginput_container_textarea textarea',
                    'form.bootstrap.nested-labels .ginput_container_select select',
                ];

                $(inputs.join(', ')).off('focus.mbdGformStyles').on('focus.mbdGformStyles', function(){
                    $(this).closest('.gfield').find('.gfield_label').addClass('active');
                }).off('blur.mbdGformStyles').on('blur.mbdGformStyles', function(){
                    if (!$(this).val()){
                        $(this).closest('.gfield').find('.gfield_label').removeClass('active');
                    }
                });

                $('.ginput_container_address input, .ginput_container_name input, .ginput_container_address select, .ginput_container_name select').off('focus').on('focus.mbdGformStyles', function(){
                    $(this).closest('span').find('label').addClass('active');
                }).off('blur').on('blur.mbdGformStyles', function(){
                    if (!$(this).val()){
                        $(this).closest('span').find('label').removeClass('active');
                    }
                });

                $('.form-check-input').off('focus.mbdGformStyles').on('focus.mbdGformStyles', function(){
                    $(this).before('<div class="form-check-ripple"></div>');
                    setTimeout(function(){
                        $('.form-check-ripple').addClass('show');
                    }, 1);
                }).off('blur.mbdGformStyles').on('blur.mbdGformStyles', function(){
                    $(this).parent().find('.form-check-ripple').remove();
                });
            }

            $(document).on('gform_post_render', function(event, form_id, current_page){
                gFormsMdbformsRender();
            });

            gFormsMdbformsRender();
        });

        
    </script>
    <?php
});

if (!is_admin()) {
    add_filter( 'gform_pre_render', function($form){
        if (!empty($form['mdb_form_style'])) {
            $form['cssClass'].= ' '.$form['mdb_form_style'];
        }
        
        return $form;
    });
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
                $content = str_replace("class='textarea", "class='textarea form-control md-textarea", $content);
            }
            $content = str_replace("rows='10", "rows='0", $content);
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

add_filter('gform_tooltips', 'mdb_style_gform_tooltips');
add_filter('gform_pre_form_settings_save', 'mdb_style_gform_pre_form_settings_save');
add_filter('gform_form_settings', 'mdb_style_gform_form_settings', 10, 2);

// Filter to add a new tooltip
function mdb_style_gform_tooltips($tooltips)
{
   $tooltips["mdb_form_style_tooltip"] = "<h6>Custom API Calls</h6>If you want this form to be associated with a custom API Call then you need to specify the 'Name' of your Api Call. Leave blank to not associate this form. You can use commas to separate multiple calls.";
   return $tooltips;
}

function mdb_style_gform_form_settings($settings, $form)
{
	ob_start();
	gform_tooltip("mdb_form_style_tooltip");
	$tooltip = ob_get_contents();
    ob_end_clean();

    $settings['Form Layout']['mdb_form_style'] = '
        <tr>
            <th><label for="mdb_form_style">Form Style '.$tooltip.'</label></th>
            <td><select name="mdb_form_style">
                <option value="md-form" '.selected(rgar($form, 'mdb_form_style'), 'md-form').'>Material Design Bootstrap</option>
                <option value="bootstrap nested-labels" '.selected(rgar($form, 'mdb_form_style'), 'bootstrap nested-labels').'>Bootstrap with Nested Labels</option>
                <option value="bootstrap" '.selected(rgar($form, 'mdb_form_style'), 'bootstrap').'>Bootstrap</option>
            </select></td>
        </tr>';

    return $settings;
}

function mdb_style_gform_pre_form_settings_save($form)
{
    $form['mdb_form_style'] = rgpost('mdb_form_style');
    return $form;
}


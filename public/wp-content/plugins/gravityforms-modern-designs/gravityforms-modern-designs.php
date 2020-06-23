<?php
/**
 * Modern Designs for Gravity Forms
 *
 * Plugin Name: Modern Designs for Gravity Forms
 * Plugin URI:  https://wordpress.org/plugins/gravityforms-modern-designs/
 * Description: Enables Modern Designs for Gravity Forms.
 * Version:     1.0
 * Author:      WordPress Contributors
 * Author URI:  https://gedde.dev
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: gravityforms-modern-designs
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

 namespace MDFGF;

 /**    
  * Class for Modern Designs for Gravity Forms
  */
class MDFGF {



    /**
     * Array of Single Text Types for Gravity Forms
     */
    private static $singleTextFields = [
        'text', 
        'email', 
        'phone', 
        'textarea', 
        'multiselect', 
        'select', 
        'number', 
        'date', 
        'website'
    ];


    /**
     * Array of Complex Fields for Gravity Forms
     */
    private static $complexFields = [
        'name', 
        'address', 
    ];


    /**
     * Setup the Plugin
     * 
     * @return void
     */
    public static function setup() {

        if (!function_exists('rgpost') || !function_exists('rgar')) {
            # TODO Error
            return false;
        }

        add_filter('gform_tooltips', [__CLASS__, 'formTooltips']);
        add_filter('gform_pre_form_settings_save', [__CLASS__, 'formSettingsSave']);
        add_filter('gform_form_settings', [__CLASS__, 'formSettings'], 10, 2);
        // add_action('wp_head', [__CLASS__, 'wpHead']);
        add_action('gform_editor_js', [__CLASS__, 'editorJs']);
        add_action('gform_pre_render', [__CLASS__, 'preRenderForm'], 10, 6);
        add_action('gform_field_css_class', [__CLASS__, 'fieldClasses'], 10, 3);
        add_action('gform_field_content', [__CLASS__, 'fieldContent'], 10, 5);
        add_filter('gform_form_tag', [__CLASS__, 'formTag'], 10, 2 );

        add_action( 'gform_enqueue_scripts', function ( $form, $is_ajax ) {
            wp_deregister_style('gforms_reset_css');
            wp_deregister_style('gforms_datepicker_css');
            wp_deregister_style('gforms_formsmain_css');
            wp_deregister_style('gforms_ready_class_css');
            wp_deregister_style('gforms_browsers_css');
        }, 10, 2);
    }



    /**
     * Add CSS and JS to the Forms
     * 
     * @return void
     */
    public static function formTag($formTag, $form) {

        $mainColor = strtolower(rgar($form, 'mdfgf_form_color'));

        $hoverColor = self::adjustBrightness($mainColor, .2);

        $preTag = "
<script>
    if(typeof window.jQuery !== 'undefined') {
        jQuery(function($){
            function gFormsMdfgformsRender(){

                // var mdForm = $('.md-form');
                // if (mdForm.length) {
                //     mdForm.find('.custom-select').each(function(){
                //         $(this).removeClass('custom-select').addClass('mdb-select').materialSelect();
                //     });
                //     mdForm.find('input, select, textarea').trigger('change');
                // }

                // $('.ginput_container_name input, .ginput_container_address input').each(function(){
                //     if ($(this).val()) {
                //         $(this).closest('li.gfield').find('label').addClass('active');
                //     }
                // })
                // $('.ginput_container_name input, .ginput_container_address input').on('focus', function(){
                //     $(this).closest('li.gfield').find('label').addClass('active');
                // });

                // if (typeof bsCustomFileInput !== 'undefined') {
                //     bsCustomFileInput.init();
                // }
        
                // var inputs = [
                //     'form.bootstrap.nested-labels .ginput_container_text input',
                //     'form.bootstrap.nested-labels .ginput_container_email input',
                //     'form.bootstrap.nested-labels .ginput_container_phone input',
                //     'form.bootstrap.nested-labels .ginput_container_number input',
                //     'form.bootstrap.nested-labels .ginput_container_textarea textarea',
                // ];

                // $(inputs.join(', ')).off('focus.mbdGformStyles').on('focus.mbdGformStyles', function(){
                //     $(this).closest('.gfield').find('.gfield_label').addClass('active');
                // }).off('blur.mbdGformStyles').on('blur.mbdGformStyles', function(){
                //     if (!$(this).val()){
                //         $(this).closest('.gfield').find('.gfield_label').removeClass('active');
                //     }
                // });

                // $('form.bootstrap.nested-labels .ginput_container_select select').off('change.mbdGformStyles').on('change.mbdGformStyles', function(){
                //     if ($(this).find('option:checked')) {
                //         $(this).addClass('is-selected');
                //         $(this).closest('.gfield').find('.gfield_label').addClass('active');
                //     } else {
                //         $(this).removeClass('is-selected');
                //         $(this).closest('.gfield').find('.gfield_label').removeClass('active');
                //     }
                // });

                // $('.ginput_container_address input, .ginput_container_name input, .ginput_container_address select, .ginput_container_name select').off('focus').on('focus.mbdGformStyles', function(){
                //     $(this).closest('span').find('label').addClass('active');
                // }).off('blur').on('blur.mbdGformStyles', function(){
                //     if (!$(this).val()){
                //         $(this).closest('span').find('label').removeClass('active');
                //     }
                // });

                // $('.form-check-input').off('focus.mbdGformStyles').on('focus.mbdGformStyles', function(){
                //     $(this).before('<div class=\"form-check-ripple\"></div>');
                //     setTimeout(function(){
                //         $('.form-check-ripple').addClass('show');
                //     }, 1);
                // }).off('blur.mbdGformStyles').on('blur.mbdGformStyles', function(){
                //     $(this).parent().find('.form-check-ripple').remove();
                // });

                // $('.custom-file-input').each(function(){
                //     if ($(this).get(0).files.length) {
                //         $(this).parent().find('.gfield_label').addClass('active');
                //     }
                // });

                // $('.custom-file-input').on('change', function(){
                //     if ($(this).get(0).files.length) {
                //         $(this).parent().find('.gfield_label').addClass('active');
                //     }
                // });
                $('.gfield_error input, .gfield_error select, .gfield_error textarea').on('change', function(){
                    $(this).closest('.gfield_error').removeClass('gfield_error');
                });
            }

            $(document).on('gform_post_render', function(event, form_id, current_page){
                gFormsMdfgformsRender();
            });

            gFormsMdfgformsRender();
        });
    }
    
</script>
<style>
/* Modern Designs for Gravity Forms css */
:root {
  --mdfgf-main-color: ".$mainColor.";
  --mdfgf-main-color-hover: ". self::adjustBrightness($mainColor, .2).";
}
".file_get_contents(dirname(__FILE__).'/gravityforms-modern-designs.min.css')."


#gform_wrapper_".$form['id']." .button,
#gform_wrapper_".$form['id']." .button:active,
#gform_wrapper_".$form['id']." .gf_progressbar_percentage,
#gform_wrapper_".$form['id']." .ginput_container input[type=\"checkbox\"]:checked:after,
#gform_wrapper_".$form['id']." .ginput_container input[type=\"radio\"]:checked:after,
#gform_wrapper_".$form['id']." .ginput_container_fileupload input[type=\"file\"]:active:before,
#gform_wrapper_".$form['id']." .ginput_container_fileupload input[type=\"file\"]:before {
    background-color: ".$mainColor.";
}
#gform_wrapper_".$form['id']." .ginput_container input:focus,
#gform_wrapper_".$form['id']." .ginput_container input:checked,
#gform_wrapper_".$form['id']." .ginput_container select:focus,
#gform_wrapper_".$form['id']." .ginput_container textarea:focus {
    border-color: ".$mainColor.";
}
#gform_wrapper_".$form['id']." .gform_wrapper .button:hover,
#gform_wrapper_".$form['id']." .ginput_container_fileupload input[type=\"file\"]:hover:before,
#gform_wrapper_".$form['id']." .gform_wrapper .button:focus,
#gform_wrapper_".$form['id']." .ginput_container_fileupload input[type=\"file\"]:focus:before {
    background-color: ".$hoverColor.";
}
</style>";

        return $preTag.$formTag;
    }


    /**
     * Change hex color
     * 
     * @param string $hexCode
     * @param int    $adjustPercent
     * 
     * @return string
     */
    public static function adjustBrightness($hexCode, $adjustPercent) {
        $hexCode = ltrim($hexCode, '#');
        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
        }
        $hexCode = array_map('hexdec', str_split($hexCode, 2));
        foreach ($hexCode as & $color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustPercent);
            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }
        return '#' . implode($hexCode);
    }



    /**
     * Pre Render Form functon before Gravity Form is Created
     * 
     * @param array $form
     * 
     * @return array
     */
    public static function preRenderForm($form){
        if (!empty($form['mdfgf_form_style'])) {
            $form['cssClass'].= (empty($form['cssClass']) ? '' : ' ').$form['mdfgf_form_style'];
        }
        return $form;
    }


    
    /**
     * Filter the Field Classes
     * 
     * @param string $field_container
     * @param object  $field
     * @param array  $form
     * 
     * @return string
     */
    public static function fieldClasses($classes, $field, $form) {

        if ($field->type !== 'honeypot') {
            $classes.= ' mdfgf-field-type-'.$field->type;
        }

        if ($field->type === 'fileupload' && !empty($field['allowedExtensions'])) {
            $classes.= ' mdfgf-show-extensions';
        }

        if (in_array($field->type, self::$singleTextFields)) {
            $classes.= ' mdfgf-field '.($field->size === 'small' ? ' mdfgfcol-4' : ($field->size === 'large' ? ' mdfgfcol-12' : ' mdfgfcol-6'));
        } elseif (in_array($field->type, array('radio', 'checkbox', 'list'))) {
            $classes.= ' mdfgf-field';
        }

        return $classes;
    }



    /**
     * Array of ToolTips for Gravity Forms
     * 
     * @param array $tooltips
     * 
     * @return string
     */
    public static function fieldContent($content, $field, $value, $lead_id, $form_id){
        if (in_array($field['type'], ['name'])) {
            $content = str_replace('name_prefix', 'mdfgf-field name_prefix', $content);
            $content = str_replace('name_first', 'mdfgf-field name_first', $content);
            $content = str_replace('name_last', 'mdfgf-field name_last', $content);
            $content = str_replace('name_middle', 'mdfgf-field name_middle', $content);
            $content = str_replace('name_suffix', 'mdfgf-field name_suffix', $content);
            $content = str_replace('ginput_container_name', 'mdfgf-row ginput_container_name', $content);
        }
        if (in_array($field['type'], ['address'])) {
            $content = str_replace('address_line_1', 'mdfgf-field address_line_1', $content);
            $content = str_replace('address_line_2', 'mdfgf-field address_line_2', $content);
            $content = str_replace('address_city', 'mdfgf-field address_city', $content);
            $content = str_replace('address_state', 'mdfgf-field address_state', $content);
            $content = str_replace('address_zip', 'mdfgf-field address_zip', $content);
            $content = str_replace('address_country', 'mdfgf-field address_country', $content);
            $content = str_replace('ginput_container_address', 'mdfgf-row ginput_container_address', $content);
        }
        // if (in_array($field['type'], ['list'])) {
        //     $content = str_replace('ginput_container_address', 'mdfgf-row ginput_container_address', $content);
        // }
        return $content;

    }
    


    /**
     * Array of ToolTips for Gravity Forms
     * 
     * @param array $tooltips
     * 
     * @return array
     */
    public static function formTooltips($tooltips)
    {
        $tooltips["mdfgf_form_style_tooltip"] = "Select which CSS Styles you would like to Add. When using somthing other than Gravity Forms";
        $tooltips["mdfgf_form_add_bootstrap_classes"] = "Enable this if you wish to add the Bootstrap 4 classes to your fields. This feature allows you to use your own css when setting Form Style to None.";
        return $tooltips;
    }



    /**
     * Customize the Settings for Gravity Forms
     * 
     * @param array $tooltips
     * @param array $form
     * 
     * @return array
     */
    public static function formSettings($settings, $form)
    {
        $settings['Moder Designs for Gravity Forms']['mdfgf_form_style'] = '
            <tr>
                <th><label for="mdfgf_form_style">Css Form Styles '.gform_tooltip("mdfgf_form_style_tooltip", '', true).'</label></th>
                <td><select name="mdfgf_form_style">
                    <option value="" '.selected(rgar($form, 'mdfgf_form_style'), '').'>None</option>
                    <option value="mdfgf-gf" '.selected(rgar($form, 'mdfgf_form_style'), '').'>Gravity Forms Default</option>
                    <option value="mdfgf-form" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form').'>Modern Designs Standard</option>
                    <option value="mdfgf-form mdfgf-md" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-md').'>Material Design</option>
                    <option value="mdfgf-form mdfgf-bootstrap mdfgf-nested-labels" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-bootstrap mdfgf-nested-labels').'>Bootstrap with Nested Labels</option>
                    <option value="mdfgf-form mdfgf-bootstrap mdfgf-contained mdfgf-nested-labels" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-bootstrap mdfgf-contained mdfgf-nested-labels').'>Bootstrap with Contained Nested Labels</option>
                    <option value="mdfgf-form mdfgf-bootstrap mdfgf-outlined mdfgf-nested-labels" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-bootstrap mdfgf-outlined mdfgf-nested-labels').'>Bootstrap with Outlined Nested Labels</option>
                    <option value="mdfgf-form mdfgf-bootstrap" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-bootstrap').'>Bootstrap</option>
                </select></td>
            </tr>
            <tr>
                <th><label for="mdfgf_form_color">Primary Color</label></th>
                <td>
                    <input type="text" id="mdfgf_form_color" name="mdfgf_form_color" value="'.(rgar($form, 'mdfgf_form_color') ? rgar($form, 'mdfgf_form_color') : '#21759b').'">
                </td>
            </tr>
            <tr>
                <th><label for="mdfgf_form_add_bootstrap_classes">Add Bootstrap Classes '.gform_tooltip("mdfgf_form_add_bootstrap_classes", '', true).'</label></th>
                <td>
                    <input type="checkbox" id="mdfgf_form_add_bootstrap_classes" name="mdfgf_form_add_bootstrap_classes" value="1" '.checked(rgar($form, 'mdfgf_form_add_bootstrap_classes'), '1').'>
                </td>
            </tr>
            ';

        return $settings;
    }



    /**
     * Update the field on Save for Gravity Forms
     * 
     * @param array $form
     * 
     * @return array
     */
    public static function formSettingsSave($form)
    {
        $form['mdfgf_form_style'] = rgpost('mdfgf_form_style');
        $form['mdfgf_form_add_bootstrap_classes'] = rgpost('mdfgf_form_add_bootstrap_classes') ? 1 : 0;
        $form['mdfgf_form_color'] = rgpost('mdfgf_form_color') ? strtolower(rgpost('mdfgf_form_color')) : '#21759b';
        return $form;
    }



    /**
     * Customize the sizes for the Field in the Editor
     * 
     * @return void
     */
    public static function editorJs()
    {
       ?>
        <script>
            //binding to the load field settings event to initialize the checkbox
            jQuery(document).bind("gform_load_field_settings", function(event, field, form) {
               jQuery('#field_size option[value="small"]').html('Small (1/3 Column)');
               jQuery('#field_size option[value="medium"]').html('Medium (1/2 Column)');
               jQuery('#field_size option[value="large"]').html('Large (Full Width)');
            });
        </script>
        <?php
    }
}

MDFGF::setup();
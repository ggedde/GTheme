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
     * Array of Single Text Inputs for Gravity Forms
     */
    private static $singleTextInputs = [
        'input[type="text"]', 
        'input[type="email"]', 
        'input[type="tel"]', 
        'input[type="number"]', 
        'input[type="date"]', 
        'input[type="time"]', 
        'input[type="password"]', 
        'input[type="url"]', 
        'input[type="month"]', 
        'input[type="week"]', 
        'input[type="text"]', 
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
        add_action('wp_head', [__CLASS__, 'wp_head']);
        add_action('gform_editor_js', [__CLASS__, 'editorJs']);
        add_action('gform_pre_render', [__CLASS__, 'preRenderForm'], 10, 6);
        add_action('gform_field_css_class', [__CLASS__, 'fieldClasses'], 10, 3);
        add_action('gform_field_content', [__CLASS__, 'fieldContent'], 10, 5);

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
    public static function wp_head() {
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
                    ];

                    $(inputs.join(', ')).off('focus.mbdGformStyles').on('focus.mbdGformStyles', function(){
                        $(this).closest('.gfield').find('.gfield_label').addClass('active');
                    }).off('blur.mbdGformStyles').on('blur.mbdGformStyles', function(){
                        if (!$(this).val()){
                            $(this).closest('.gfield').find('.gfield_label').removeClass('active');
                        }
                    });

                    $('form.bootstrap.nested-labels .ginput_container_select select').off('change.mbdGformStyles').on('change.mbdGformStyles', function(){
                        if ($(this).find('option:checked')) {
                            $(this).addClass('is-selected');
                            $(this).closest('.gfield').find('.gfield_label').addClass('active');
                        } else {
                            $(this).removeClass('is-selected');
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

                    $('.custom-file-input').each(function(){
                        if ($(this).get(0).files.length) {
                            $(this).parent().find('.gfield_label').addClass('active');
                        }
                    });

                    $('.custom-file-input').on('change', function(){
                        if ($(this).get(0).files.length) {
                            $(this).parent().find('.gfield_label').addClass('active');
                        }
                    });
                }

                $(document).on('gform_post_render', function(event, form_id, current_page){
                    gFormsMdbformsRender();
                });

                gFormsMdbformsRender();
            });

            
        </script>
        <style>
        ul.gform_fields,
        ul.gfield_checkbox,
        ul.gfield_radio,
        .mdfgf-row {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            justify-content: space-between;
            margin: 0;
            padding: 0;
        }
        ul.gfield_checkbox,
        ul.gfield_radio {
            justify-content: flex-start;
        }
        ul.gfield_checkbox li,
        ul.gfield_radio li {
            flex: 0 0 calc(100% - 15px);
            margin-top: 1rem;
            margin-left: 5px;
            padding-right: 10px;
        }
        @media only screen and (min-width: 680px) {
            ul.gfield_checkbox li,
            ul.gfield_radio li {
                flex: 0 0 calc(25% - 15px);
            }
        }
        li.gfield,
        .mdfgf-field {
            flex: 0 0 100%;
            margin-bottom: 1.5rem;
            box-sizing: border-box;
        }
        li.gfield.mdfgf-field-type-name,
        li.gfield.mdfgf-field-type-address {
            margin-bottom: 0;
        }
        .gfield_list_cell {
            padding-right: 20px;
        }
        .gfield_list_cell:nth-last-child(2) {
            padding-right: 0;
        }
        .gfield_list {
            width: 100%;
            border-collapse: collapse;
        }
        .gfield_list_icons {
            width: 30px;
        }
        @media only screen and (min-width: 800px) {
            .mdfgf-field.mdfgfcol-4 {
                flex: 0 0 calc(33% - 10px);
            }
        }
        @media only screen and (min-width: 640px) {
            .mdfgf-field.mdfgfcol-6,
            .ginput_complex .mdfgf-field {
                flex: 0 0 calc(50% - 10px);
            }
        }
        label.gfield_label {
            font-weight: 500;
        }
        .gfield_required {
            padding-left: 4px;
            opacity: .4;
        }
        .ginput_complex label,
        .gfield_list th {
            font-size: 14px;
            font-weight: 100;
            opacity: .8;
        }
        .gfield_list th,
        .gfield_list_group + .gfield_list_group td {
            padding-top: .5rem;
        }
        body .gform_wrapper .ginput_container_list table.gfield_list tbody tr td.gfield_list_icons img {
            background-color: rgba(255,255,255,0.5) !important;
            border-radius: 50%;
        }
        <?php foreach (self::$singleTextInputs as $singleTextInputs) { ?>
        .mdfgf-field <?=$singleTextInputs;?>,
        <?php } ?>
        .mdfgf-field select,
        .mdfgf-field textarea,
        .ginput_container_fileupload {
            width: 100%;
            border: 1px solid rgba(0,0,0,0.2);
            background-color: rgba(240,240,240,0.1);
            border-radius: 4px;
            min-height: 40px;
            padding: 0 10px;
            appearance: none;
            -webkit-appearance: none;
            box-sizing: border-box;
            transition: border .1s ease-in-out;
        }
        .text-light label.gfield_label,
        .text-light li.gfield,
        .text-light .gf_progressbar,
        .text-light .gf_progressbar_title,
        .text-light .mdfgf-field,
        .text-light .gfield_list th,
        .text-light .ginput_complex label {
            color: #eee;
        }
        <?php foreach (self::$singleTextInputs as $singleTextInputs) { ?>
        .text-light .mdfgf-field <?=$singleTextInputs;?>,
        <?php } ?>
        .text-light .mdfgf-field select,
        .text-light .mdfgf-field textarea,
        .text-light .ginput_container_fileupload {
            border-color: rgba(255,255,255,0.2);
            background-color: rgba(255,255,255,0.05);
            color: #eee;
        }
        <?php foreach (self::$singleTextInputs as $singleTextInputs) { ?>
        .gfield_error.mdfgf-field <?=$singleTextInputs;?>,
        <?php } ?>
        .gfield_error.mdfgf-field select,
        .gfield_error.mdfgf-field textarea,
        .gfield_error.ginput_container_fileupload {
            border-color: rgba(250,0,0,0.9);
        }
        .ginput_container_fileupload {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ginput_container_fileupload input[type="file"] {
            padding-left: 32px;
        }
        .ginput_container_fileupload input[type="file"]::-webkit-file-upload-button {
            visibility: hidden;

        }
        .ginput_container_fileupload input[type="file"]:before {
            content: 'Choose File';
            position: absolute;
            left: 10px;
            top: 7px;
        }
        .ginput_container_fileupload .validation_message,
        .ginput_container_fileupload span[id^="extensions_"] {
            position: absolute;
            text-align: right;
            top: 30px;
            right: 0;
            width: 100%;
            font-size: 14px;
        }
        .ginput_container_fileupload span[id^="extensions_"] {
            top: -20px;
        }
        <?php foreach (self::$singleTextInputs as $singleTextInputs) { ?>
        .mdfgf-field <?=$singleTextInputs;?>:focus,
        <?php } ?>
        .mdfgf-field select:focus,
        .mdfgf-field textarea:focus {
            border-color: #007bff;
        }
        .mdfgf-field label {
            margin: 0;
        }
        .gform_wrapper .button,
        .ginput_container_fileupload input[type="file"]:before {
            cursor: pointer;
            border: 1px solid #007bff;
            border-radius: 4px;
            appearance: none;
            -webkit-appearance: none;
            padding: 0 1rem;
            height: 40px;
            line-height: 40px;
            min-width: 140px;
            text-align: center;
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            font-weight: 400;
            text-transform: uppercase;
            margin: auto;
            display: inline-block;
            transition: background-color .2s ease-in-out;
        }
        .gform_wrapper .ginput_container_fileupload input[type="file"]:before {
            height: 22px;
            font-size: 12px;
            padding: 0 .4rem;
            line-height: 22px;
            min-width: 100px;
        }
        .gform_wrapper .button:hover,
        .ginput_container_fileupload input[type="file"]:hover:before {
            background-color: #108bff;
        }
        .gform_wrapper .button:active,
        .ginput_container_fileupload input[type="file"]:active:before {
            background-color: #006bef;
            line-height: 41px;
        }
        .ginput_container_fileupload input[type="file"]:active:before {
            line-height: 25px;
        }
            

        </style>
        <?php
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

        $classes.= ' mdfgf-field-type-'.$field->type;

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
        $tooltips["mdfgf_form_style_tooltip"] = "<h6>Custom API Calls</h6>If you want this form to be associated with a custom API Call then you need to specify the 'Name' of your Api Call. Leave blank to not associate this form. You can use commas to separate multiple calls.";
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
        ob_start();
        gform_tooltip("mdfgf_form_style_tooltip");
        $tooltip = ob_get_contents();
        ob_end_clean();

        $settings['Form Layout']['mdfgf_form_style'] = '
            <tr>
                <th><label for="mdfgf_form_style">Form Style '.$tooltip.'</label></th>
                <td><select name="mdfgf_form_style">
                    <option value="mdfgf-form mdfgf-md" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-md').'>Material Design</option>
                    <option value="mdfgf-form mdfgf-bootstrap mdfgf-nested-labels" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-bootstrap mdfgf-nested-labels').'>Bootstrap with Nested Labels</option>
                    <option value="mdfgf-form mdfgf-bootstrap mdfgf-contained mdfgf-nested-labels" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-bootstrap mdfgf-contained mdfgf-nested-labels').'>Bootstrap with Contained Nested Labels</option>
                    <option value="mdfgf-form mdfgf-bootstrap mdfgf-outlined mdfgf-nested-labels" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-bootstrap mdfgf-outlined mdfgf-nested-labels').'>Bootstrap with Outlined Nested Labels</option>
                    <option value="mdfgf-form mdfgf-bootstrap" '.selected(rgar($form, 'mdfgf_form_style'), 'mdfgf-form mdfgf-bootstrap').'>Bootstrap</option>
                </select></td>
            </tr>';

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
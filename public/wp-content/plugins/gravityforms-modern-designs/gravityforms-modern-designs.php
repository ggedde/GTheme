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
 * 
 * Running Sass Watch
 * sass --watch --no-source-map --style=compressed public/wp-content/plugins/gravityforms-modern-designs/gravityforms-modern-designs.scss public/wp-content/plugins/gravityforms-modern-designs/gravityforms-modern-designs.min.css
 */

 namespace MDFGF;

 use GFAPI;
 /**    
  * Class for Modern Designs for Gravity Forms
  */
class MDFGF {



    /**
     * Array of Single Text Types for Gravity Forms
     */
    private static $singleTextFields = array(
        'text', 
        'email', 
        'phone', 
        'textarea', 
        'multiselect', 
        'select', 
        'number', 
        'date', 
        'website'
    );



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

        add_filter('gform_tooltips', array(__CLASS__, 'formTooltips'));
        add_filter('gform_pre_form_settings_save', array(__CLASS__, 'formSettingsSave'));
        add_filter('gform_form_settings', array(__CLASS__, 'formSettings'), 10, 2);
        add_action('wp_head', array(__CLASS__, 'wpHead'));
        add_action('gform_editor_js', array(__CLASS__, 'editorJs'));
        add_action('gform_pre_render', array(__CLASS__, 'preRenderForm'), 10, 6);
        add_action('gform_shortcode_form', array(__CLASS__, 'shortcodeForm'), 10, 3);
        add_action('gform_field_css_class', array(__CLASS__, 'fieldClasses'), 10, 3);
        add_action('gform_field_content', array(__CLASS__, 'fieldContent'), 10, 5);
        add_filter('admin_footer', array(__CLASS__, 'adminFooter'));

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
    public static function wpHead() {

        ?>
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
                $('.mdfgf-container .gfield_error input, .mdfgf-container .gfield_error select, .mdfgf-container .gfield_error textarea').on('change', function(){
                    $(this).closest('.gfield_error').removeClass('gfield_error');
                });

                $('.mdfgf-auto-grow-textareas textarea').attr('rows', 0).css({'min-height': '80px', 'max-height': '300px', 'overflow': 'auto'}).on('input', function(){
                    var element = $(this)[0];
                    if (element && typeof element.scrollHeight !== 'undefined') {
                        if (element.scrollHeight > 80) {
                            element.style.height = element.scrollHeight+"px";
                        }
                    }
                });

                $('select').each(function(){
                    var select = $('<div class="mdfgf-custom-select" style="display:none;"></div>').insertAfter($(this));
                    $(this).find('option').hide().each(function(){
                        select.append('<div data-value="'+$(this).val()+'">'+$(this).html()+'</div>');
                    });
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
<?= file_get_contents(dirname(__FILE__).'/gravityforms-modern-designs.min.css');?>
</style>
<?php
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
        // echo '<pre>';print_r($form);echo '</pre>';
        
        if (!empty($form['mdfgf_design'])) {
            $form['cssClass'].= (empty($form['cssClass']) ? '' : ' ').$form['mdfgf_design'];
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

        $complexFieldsClasses = array(
            'name_prefix',
            'name_first',
            'name_last',
            'name_middle',
            'name_suffix',
            'address_line_1',
            'address_line_2',
            'address_city',
            'address_state',
            'address_zip',
            'address_country',
            'gfield_time_hour',
            'gfield_time_minute',
            'gfield_time_ampm',
        );

        if (in_array($field['type'], array('address', 'name', 'time'))) {
            // $content = preg_replace('/\<(select|input) /m', '<$1 class="mdfgf-input" ', $content);
            $content = preg_replace('/(ginput_container_address|ginput_container_name|clear-multi)/m', 'mdfgf-row $1', $content);
            $content = preg_replace('/('.implode('|',$complexFieldsClasses).')/m', 'mdfgf-field $1', $content);
        }

        if (preg_match_all('/\<(input|select|textarea) [^\>]+\>/m', $content, $matches)) {
            if (!empty($matches[0])) {
                foreach ($matches[0] as $tag) {
                    $newTag = '';

                    if (stripos($tag, "type='hidden")) {
                        continue;
                    }

                    if (preg_match("/class=\'([^\']*)\'/m", $tag, $classMatches)) {
                        $newTag = str_replace($classMatches[0], "class='mdfgf-input".($classMatches[1] ? ' '.$classMatches[1] : '')."'", $tag);
                    } else {
                        $newTag = preg_replace('/\<(select|input|textarea) /m', '<$1 class="mdfgf-input" ', $tag);
                    }

                    if ($newTag) {
                        $content = str_replace($tag, $newTag, $content);
                    }
                }
            }
        }

        if (preg_match_all('/\<(label)[^\>]+\>/m', $content, $matches)) {
            if (!empty($matches[0])) {
                foreach ($matches[0] as $tag) {
                    $newTag = '';

                    if (preg_match("/class=\'([^\']*)\'/m", $tag, $classMatches)) {
                        $newTag = str_replace($classMatches[0], "class='mdfgf-label".($classMatches[1] ? ' '.$classMatches[1] : '')."'", $tag);
                    } else if (!in_array($field['type'], array('radio', 'checkbox', 'consent'))) {
                        $newTag = preg_replace('/\<(label)/m', '<$1 class="mdfgf-label"', $tag);
                    }

                    if ($newTag) {
                        $content = str_replace($tag, $newTag, $content);
                    }
                }
            }
        }

        return $content;

    }


    /**
     * Filter the Shortcode settings and return content
     * 
     * @param string $string
     * @param array $attributes
     * @param string $content
     * 
     * @return string
     */
    public static function shortcodeForm($string, $attributes, $content) {
        $classes = array('mdfgf-container');
        $mainColor = '';
        $themeClass = 'mdfgf-theme-default';
        $design = 'mdfgf-mdfgf';
        $textColorClass = '';
        $autoGrowTextareas = false;
        
        if (class_exists('GFAPI') && function_exists('rgar')) {
            if ($form = GFAPI::get_form( $attributes['id'])) {
                $design = !empty($form['mdfgf_design']) ? esc_attr($form['mdfgf_design']) : '';

                if($design && $design !== 'mdfgf-gf') {
                    if(rgar($form, 'mdfgf_color')) {
                        $mainColor = esc_attr(rgar($form, 'mdfgf_color'));
                    }
                    if (rgar($form, 'mdfgf_theme')) {
                        $themeClass = esc_attr(rgar($form, 'mdfgf_theme'));
                    }
                    if (!empty($form['mdfgf_text_class'])) {
                        $textColorClass = esc_attr($form['mdfgf_text_class']);
                    }
                    if (!empty($form['mdfgf_auto_grow_textareas'])) {
                        $autoGrowTextareas = true;
                    }
                }
            }
        }

        if ($attributes['mdfgf_color']) {
            $mainColor = esc_attr($attributes['mdfgf_color']);
        }
        if ($attributes['mdfgf_theme']) {
            $themeClass = esc_attr($attributes['mdfgf_theme']);
        }
        if (isset($attributes['mdfgf_text_class'])) {
            $textColorClass = esc_attr($attributes['mdfgf_text_class']);
        }
        if (isset($attributes['mdfgf_auto_grow_textareas'])) {
            $autoGrowTextareas = !empty($attributes['mdfgf_auto_grow_textareas']);
        }

        if ($textColorClass) {
            $classes[] = $textColorClass;
        }

        if ($themeClass) {
            $classes[] = $themeClass;
        }

        if ($autoGrowTextareas) {
            $classes[] = 'mdfgf-auto-grow-textareas';
        }

        if ($mainColor) {
            $mainColor = strtolower($mainColor);
            $hoverColor = self::adjustBrightness($mainColor, .2);
            $colorString = '
        <style>
/* Modern Designs for Gravity Forms Custom css for Single Form */
#gform_wrapper_'.$attributes['id'].' .button,
.gform_wrapper_original_id_'.$attributes['id'].' .button,
#gform_wrapper_'.$attributes['id'].' .button:active,
.gform_wrapper_original_id_'.$attributes['id'].' .button:active,
#gform_wrapper_'.$attributes['id'].' .gf_progressbar .gf_progressbar_percentage,
.gform_wrapper_original_id_'.$attributes['id'].' .gf_progressbar .gf_progressbar_percentage,
#gform_wrapper_'.$attributes['id'].' .ginput_container input[type="checkbox"]:checked:after,
.gform_wrapper_original_id_'.$attributes['id'].' .ginput_container input[type="checkbox"]:checked:after,
#gform_wrapper_'.$attributes['id'].' .ginput_container input[type="radio"]:checked:after,
.gform_wrapper_original_id_'.$attributes['id'].' .ginput_container input[type="radio"]:checked:after,
#gform_wrapper_'.$attributes['id'].' .ginput_container_fileupload input[type="file"]:active:before,
.gform_wrapper_original_id_'.$attributes['id'].' .ginput_container_fileupload input[type="file"]:active:before,
#gform_wrapper_'.$attributes['id'].' .ginput_container_fileupload input[type="file"]:before,
.gform_wrapper_original_id_'.$attributes['id'].' .ginput_container_fileupload input[type="file"]:before {
    background-color: '.$mainColor.';
}
#gform_wrapper_'.$attributes['id'].' .mdfgf-input:focus,
.gform_wrapper_original_id_'.$attributes['id'].' .mdfgf-input:focus {
    border-color: '.$mainColor.';
}
#gform_wrapper_'.$attributes['id'].' .button:hover,
.gform_wrapper_original_id_'.$attributes['id'].' .button:hover,
#gform_wrapper_'.$attributes['id'].' .ginput_container_fileupload input[type="file"]:hover:before,
.gform_wrapper_original_id_'.$attributes['id'].' .ginput_container_fileupload input[type="file"]:hover:before,
#gform_wrapper_'.$attributes['id'].' .button:focus,
.gform_wrapper_original_id_'.$attributes['id'].' .button:focus,
#gform_wrapper_'.$attributes['id'].' .ginput_container_fileupload input[type="file"]:focus:before, 
    .gform_wrapper_original_id_'.$attributes['id'].' .ginput_container_fileupload input[type="file"]:focus:before {
    background-color: '.$hoverColor.';
}
</style>';

        }

        // if(preg_match_all("/\<ul[^\>]*class=\'([^\']*[gform\_fields|gfield\_checkbox|gfield\_radio][^\']*)\'[^\>]*\>/m", $string, $matches))
        // {
        //     // echo '<pre>';print_r($matches);echo '</pre>';
        //     // exit;
        //     if (!empty($matches[0])) {
        //         foreach ($matches[0] as $key => $match) {
        //             $string = str_replace($match, str_replace($matches[1][$key], $matches[1][$key].' mdfgf-row', $match), $string);
        //         }
        //     }
        // }
        
        return $colorString.'<div class="'.implode(' ', $classes).'">'.$string.'</div>';
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
        $tooltips["mdfgf_design_tooltip"] = "Select which Design Style you would like to use. When using somthing other than Gravity Forms Default, Gravity forms Styles will be de-registered for faster page loads. If you are already using a css framework like Bootstrap or MDB, then it is best to set this to None and 'Add Additional Classes' for your Framework.";
        $tooltips["mdfgf_add_classes_tooltip"] = "Alternatively, if you are already including a css framework like bootstrap or mdb then you can add the classes to the form markup. Currently Supports Bootstrap 4 and MDB (mdbootstrap.com)";
        $tooltips["mdfgf_shortcode_overrides_tooltip"] = "You can Override these values within the shortcode attributes. This is useful when needing to change colors or themes when embedding the form in different locations.<br>Examples:<br>mdfgf_theme=\"mdfgf-theme-default\"<br>mdfgf_theme=\"mdfgf-theme-greyish\"<br>mdfgf_theme=\"mdfgf-theme-ash\"<br>mdfgf_theme=\"mdfgf-theme-dark\"<br>mdfgf_text_class=\"mdfgf-text-light\"<br>mdfgf_color=\"#21759b\"";
        $tooltips["mdfgf_color_tooltip"] = "This will override the Highlight color used for Buttons, Radios and Checkboxes when filled and Focus events. Use Hexadecimal value.<br>Ex #21759b";
        $tooltips["mdfgf_auto_grow_textareas_tooltip"] = "This will collapse all textarea fields in the form to 80px and will auto grow the height when the user types content into the box. The Max height is 300px and will show a scrollbar once they enter that much data.";
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
        $formDesign = rgar($form, 'mdfgf_design');

        $settings['Moder Designs for Gravity Forms']['mdfgf_design'] = '
            <tr>
                <th><label for="mdfgf_design">Design Style '.gform_tooltip("mdfgf_design_tooltip", '', true).'</label></th>
                <td>
                    <select id="mdfgf_design" name="mdfgf_design" style="width: 300px;">
                        <option value="mdfgf-gf" '.selected($formDesign, 'mdfgf-gf', false, false).'>Gravity Forms Default</option>
                        <option value="mdfgf-mdfgf" '.selected($formDesign, 'mdfgf-mdfgf', false).'>Modern Designs for Gravity Forms</option>
                        <option value="mdfgf-md" '.selected($formDesign, 'mdfgf-form mdfgf-md', false).'>Material Design</option>
                        <option value="mdfgf-bootstrap" '.selected($formDesign, 'mdfgf-bootstrap', false).'>Bootstrap</option>
                        <option value="" '.selected($formDesign, '', false).'>None</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-theme-options"'.(!$formDesign || $formDesign === 'mdfgf-gf' ? ' style="display:none;"' : '').'>
                <th><label for="mdfgf_theme">Theme '.gform_tooltip("mdfgf_theme_tooltip", '', true).'</label></th>
                <td>
                    <select id="mdfgf_theme" name="mdfgf_theme" style="width: 300px;">
                        <option value="mdfgf-theme-default" '.selected(rgar($form, 'mdfgf_theme'), 'mdfgf-theme-default', false).'>Default</option>
                        <option value="mdfgf-theme-greyish" '.selected(rgar($form, 'mdfgf_theme'), 'mdfgf-theme-greyish', false).'>Greyish</option>
                        <option value="mdfgf-theme-vivid" '.selected(rgar($form, 'mdfgf_theme'), 'mdfgf-theme-vivid', false).'>Vivid</option>
                        <option value="mdfgf-theme-ash" '.selected(rgar($form, 'mdfgf_theme'), 'mdfgf-theme-ash', false).'>Ash (Good on Medium Dark Backgrounds)</option>
                        <option value="mdfgf-theme-dark" '.selected(rgar($form, 'mdfgf_theme'), 'mdfgf-theme-dark', false).'>Dark (Good on Dark Backgrounds)</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-theme-options"'.(!$formDesign || $formDesign === 'mdfgf-gf' ? ' style="display:none;"' : '').'>
                <th><label for="mdfgf_text_class">Text Color</label></th>
                <td>
                    <select id="mdfgf_text_class" name="mdfgf_text_class" style="width: 300px;">
                        <option value="" '.selected(rgar($form, 'mdfgf_theme'), '', false).'>Use Theme Default (Auto Detect)</option>
                        <option value="mdfgf-text-light" '.selected(rgar($form, 'mdfgf_text_class'), 'mdfgf-text-light', false).'>Light Text</option>
                        <option value="mdfgf-text-dark" '.selected(rgar($form, 'mdfgf_text_class'), 'mdfgf-text-dark', false).'>Dark Text</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-theme-options"'.(!$formDesign || $formDesign === 'mdfgf-gf' ? ' style="display:none;"' : '').'>
                <th><label for="mdfgf_color">Primary Color '.gform_tooltip("mdfgf_color_tooltip", '', true).'</label></th>
                <td>
                    <input type="text" id="mdfgf_color" name="mdfgf_color" value="'.(rgar($form, 'mdfgf_color') ? rgar($form, 'mdfgf_color') : '').'" style="width: 300px;">
                </td>
            </tr>
            <tr>
                <th><label for="mdfgf_add_classes">Add Additional Classes '.gform_tooltip("mdfgf_add_classes_tooltip", '', true).'</label></th>
                <td>
                    <select name="mdfgf_add_classes" style="width: 300px;">
                        <option value="" '.selected(rgar($form, 'mdfgf_add_classes'), '', false).'>None</option>
                        <option value="bootstrap" '.selected(rgar($form, 'mdfgf_add_classes'), 'bootstrap', false).'>Add Bootstrap Classes</option>
                        <option value="mdb" '.selected(rgar($form, 'mdfgf_add_classes'), 'mdb', false).'>Add MDB Classes (mdbootstrap.com)</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-theme-options"'.(!$formDesign || $formDesign === 'mdfgf-gf' ? ' style="display:none;"' : '').'>
                <th><label for="mdfgf_auto_grow_textareas">Auto Grow Textareas '.gform_tooltip("mdfgf_auto_grow_textareas_tooltip", '', true).'</label></th>
                <td>
                    <input type="checkbox" id="mdfgf_auto_grow_textareas" name="mdfgf_auto_grow_textareas" value="1" '.checked(rgar($form, 'mdfgf_auto_grow_textareas'), 1, false).'>
                </td>
            </tr>
            <tr>
                <th><label for="mdfgf_add_classes">Shortcode Overrides '.gform_tooltip("mdfgf_shortcode_overrides_tooltip", '', true).'</label></th>
                <td></td>
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
        $form['mdfgf_design'] = rgpost('mdfgf_design');
        $form['mdfgf_theme'] = rgpost('mdfgf_theme');
        $form['mdfgf_add_classes'] = rgpost('mdfgf_add_classes') ? rgpost('mdfgf_add_classes') : '';
        $form['mdfgf_text_class'] = rgpost('mdfgf_text_class') ? rgpost('mdfgf_text_class') : '';
        $form['mdfgf_color'] = rgpost('mdfgf_color') ? strtolower(rgpost('mdfgf_color')) : '';
        $form['mdfgf_auto_grow_textareas'] = rgpost('mdfgf_auto_grow_textareas') ? 1 : 0;
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

    /**
     * Customize the sizes for the Field in the Editor
     * 
     * @return void
     */
    public static function adminFooter()
    {
       ?>
        <script>
            //binding to the load field settings event to initialize the checkbox
            jQuery('#mdfgf_design').on('change', function(){
                var val = jQuery(this).val();    
                if (!val || val === 'mdfgf-gf') {
                    jQuery('.mdfgf-theme-options').hide();
                } else {
                    jQuery('.mdfgf-theme-options').show();
                }
            });
        </script>
        <?php
    }
}

MDFGF::setup();
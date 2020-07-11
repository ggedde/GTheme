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
        'website',
        'quantity',
        'option',
    );



    /**
     * Array of Single Text Types for Gravity Forms
     */
    private static $columnFields = array(
        'text', 
        'email', 
        'phone', 
        'textarea', 
        'multiselect', 
        'select', 
        'number', 
        'date', 
        'time', 
        'radio', 
        'checkbox', 
        'website',
        'name', 
        'address', 
        'post_image',
        'quantity',
        'option',
    );

    /**
     * Array of Single Text Types for Gravity Forms
     */
    private static $complexFields = array(
        'name', 
        'address', 
        'post_image',
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
        add_action( 'gform_settings_mdfgf', array(__CLASS__, 'globalSettings'));

        add_action('gform_field_appearance_settings', function($position, $formId){
            if($position === 500) {
            ?>
            <li class="size_setting size_input_setting field_setting" style="display: none;">
                <label for="field_inputsize" class="section_label">
                    <?php esc_html_e( 'Input Size', 'gravityforms' ); ?>
                    <?php gform_tooltip( 'form_field_size' ) ?>
                </label>
                <select id="field_inputsize" onchange="SetFieldProperty('inputsize', jQuery(this).val());">
                    <option value="tiny"><?php esc_html_e( 'Tiny (1/4 Column)', 'gravityforms' ); ?></option>
                    <option value="small"><?php esc_html_e( 'Small (1/3 Column)', 'gravityforms' ); ?></option>
                    <option value="medium"><?php esc_html_e( 'Medium (1/2 Column)', 'gravityforms' ); ?></option>
                    <option value="large"><?php esc_html_e( 'Large (Full Width)', 'gravityforms' ); ?></option>
                </select>
            </li>
            <?php
            }
        }, 10, 2);

        add_filter( 'gform_settings_menu', function($tabs) {
            $tabs[] = array( 'name' => 'mdfgf', 'label' => 'Modern Designs' );
            return $tabs;
        });

        add_action( 'gform_enqueue_scripts', function ( $form, $is_ajax ) {

            $settings = self::getSettings($form['id']);
            if (empty($settings['design']) || $settings['design'] !== 'mdfgf-gf') {
                wp_deregister_style('gforms_reset_css');
                wp_deregister_style('gforms_datepicker_css');
                wp_deregister_style('gforms_formsmain_css');
                wp_deregister_style('gforms_ready_class_css');
                wp_deregister_style('gforms_browsers_css');
            }
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
        function mdfgfUpdateUploadPreviews() {
            setTimeout(function(){
                jQuery('.mdfgf-multifile [id^="gform_preview"]').each(function(){
                    if (jQuery(this).find('.ginput_preview').length) {
                        jQuery(this).fadeIn(200);
                    } else {
                        jQuery(this).fadeOut(200);
                    }
                });
            }, 100);
        }
        jQuery(function($){
            function isMobile() {
                if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                    return true;
                }
                return false;
            }
            function mdfgfCloseCustomSelects(force){
                $('.mdfgf-select-open').each(function(){
                    $(this).removeClass('mdfgf-select-open');
                    $(this).find('.mdfgf-custom-select').hide().find('button').off();
                });
            }
            
            function mdfgfOpenCustomSelect(select){
                mdfgfCloseCustomSelects(true);
                var customSelect = select.siblings('.mdfgf-custom-select');
                customSelect.show();
                setTimeout(function(){
                    customSelect.parent().addClass('mdfgf-select-open');
                },1);
                if (customSelect.find('button.active').length) {
                    customSelect.find('button.active').focus();
                } else {
                    customSelect.find('button:first-child').focus();
                }
                customSelect.find('button').off().on('click keydown tap', function(e){                    
                    if(e.type !== 'keydown' || (e.type === 'keydown' && (parseInt(e.keyCode) === 13 || parseInt(e.keyCode) === 32 || parseInt(e.keyCode) === 27))){
                        if (e.type !== 'keydown' || parseInt(e.keyCode) !== 27) {
                            if (customSelect.hasClass('multiple')) {
                                if ($(this).hasClass('active')) {
                                    $(this).removeClass('active');
                                    customSelect.siblings('select').find("option:nth-child("+($(this).index() + 1)+")").prop("selected", false);
                                } else {
                                    $(this).addClass('active');
                                    customSelect.siblings('select').find("option:nth-child("+($(this).index() + 1)+")").prop("selected", true);
                                }
                                customSelect.siblings('.mdfgf-multi-text').html(customSelect.siblings('select').val().join(', '));
                                select.trigger('change');
                                e.preventDefault();
                                return false;
                            } else {
                                $(this).parent().siblings('select').val($(this).attr('data-value'));
                                select.trigger('change');
                                $(this).siblings().removeClass('active');
                                $(this).addClass('active');
                            }
                        }
                        if(!isMobile()) {
                            $(this).parent().siblings('select').focus();
                        }
                        if (!customSelect.hasClass('multiple') || (customSelect.hasClass('multiple') && e.type === 'keydown' && parseInt(e.keyCode) === 27)) {
                            mdfgfCloseCustomSelects();
                        }
                        e.preventDefault();
                        return false;
                    }
                    if(e.type === 'keydown'){
                        if (parseInt(e.keyCode) === 38 && $(this).prev()) {
                            $(this).prev().focus();
                            e.preventDefault();
                            return false;
                        }
                        if ((parseInt(e.keyCode) === 40 && parseInt(e.keyCode) === 40) && $(this).next()) {
                            $(this).next().focus();
                            e.preventDefault();
                            return false;
                        }
                    }
                });
                $(document).on('click', function(e) { 
                    $target = $(e.target);
                    if(!$target.closest('.mdfgf-custom-select').length && $('.mdfgf-custom-select').is(":visible")) {
                        mdfgfCloseCustomSelects();
                    }        
                });
            }
            function mdfgfRenderForms(){

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

                $('.mdfgf-input').off('focus.mdfgf').on('focus.mdfgf', function(){
                    $(this).closest('.mdfgf-field').addClass('active has-focus');
                }).off('blur.mdfgf').on('blur.mdfgf', function(){
                    var self = $(this);
                    self.closest('.mdfgf-field').removeClass('has-focus');
                    setTimeout(function(){
                        if (!self.val()){
                            self.closest('.mdfgf-field').removeClass('active');
                        }
                    }, 100);
                });

                $('.mdfgf-input').each(function(){
                    if ($(this).val()) {
                        $(this).closest('.mdfgf-field').addClass('no-transition').addClass('active');
                    }
                });
                // Don't show animation on page load
                setTimeout(function(){
                    $('.no-transition').removeClass('no-transition');
                }, 100);

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

                $('.mdfgf-animate-line .mdfgf-render .mdfgf-field .mdfgf-label').each(function(){
                    $(this).appendTo($(this).closest('.mdfgf-field').find('.mdfgf-fieldblock-label'));
                });

                $('.mdfgf-render').each(function(){
                    var form = $(this);
                    var formId = $(this).attr('id');
                
                    if (form.find('.gf_page_steps .gf_step').length) {
                        form.find('.gf_page_steps .gf_step').after('<div class="mdfgf-step-spacer"></div>');
                        var steps = form.find('.gf_step').length;
                        form.find('.mdfgf-step-spacer').css('width', 'calc('+(100 / (steps - 1))+'% - '+(42 * (steps - (steps > 2 ? 1 : 0)))+'px)');
                    }

                    form.find('select').each(function(){
                        $(this).wrap('<div class="mdfgf-select'+($(this).prop('multiple') ? ' multiple' : '')+'"></div>');
                    });

                    form.find('.gform_button, .gform_next_button, .gform_previous_button').each(function(){
                        $(this).wrap('<span class="mdfgf-button'+($(this).hasClass('gform_next_button') ? ' mdfgf-next' : ($(this).hasClass('gform_previous_button') ? ' mdfgf-prev' : ($(this).hasClass('gform_button') ? ' mdfgf-submit' : '')))+'"></span>');
                    });

                    form.off('submit.mdfgf').on('submit.mdfgf', function(){
                        $(this).addClass('mdfgf-submitted');
                    });

                    form.find('.gform_page:visible .mdfgf-prev').on('click.mdfgf').on('click.mdfgf', function(e){
                        $(this).closest('form').addClass('mdfgf-prev-submitted');
                    });

                    form.find('.gfield_error .mdfgf-input').on('change', function(){
                        $(this).closest('.gfield_error').removeClass('gfield_error');
                    });

                    setTimeout(function(){
                        form.find('.mdfgf-fieldblock .mdfgf-label').each(function(){
                            var wid = $(this).width();
                            $(this).css('width', ((wid - (wid * .1)) + 10)).addClass('mdfgf-collapse').parent().addClass('mdfgf-remove-border');
                        });
                    }, 10);

                    $('.mdfgf-auto-grow-textareas #'+formId+'.mdfgf-render textarea').attr('rows', 0).css({'min-height': '80px', 'max-height': '300px', 'overflow': 'auto'}).on('input', function(){
                        var element = $(this)[0];
                        if (element && typeof element.scrollHeight !== 'undefined') {
                            if (element.scrollHeight > 80) {
                                element.style.height = element.scrollHeight+"px";
                            }
                        }
                    });

                    $('.mdfgf-use-custom-selects #'+formId+'.mdfgf-render .mdfgf-select').each(function(){
                        if (!$(this).find('.mdfgf-custom-select').length) {
                            var select = $('<div class="mdfgf-custom-select'+($(this).find('select').prop('multiple') ? ' multiple' : '')+'"></div>');
                            if ($(this).find('select').prop('multiple')) {
                                $(this).append('<div class="mdfgf-multi-text mdfgf-input"></div>');
                            }
                            $(this).append(select);
                            $(this).find('option').each(function(){
                                select.append('<button type="button" data-value="'+$(this).val()+'"'+($(this).prop('disabled') ? ' disabled' : '')+($(this).prop('selected') ? ' class="active"' : '')+'>'+$(this).html()+'</button>');
                            });
                        }
                    });

                    $('.mdfgf-use-custom-selects #'+formId+'.mdfgf-render select').on('click keydown tap', function(e){
                        if(e.type !== 'keydown' || (e.type === 'keydown' && (parseInt(e.keyCode) === 13 || parseInt(e.keyCode) === 32 || parseInt(e.keyCode) === 38 || parseInt(e.keyCode) === 40))){
                            mdfgfOpenCustomSelect($(this));
                            e.preventDefault();
                            return false;
                        }
                    });

                    if ($('.mdfgf-container').hasClass('mdfgf-use-custom-datepicker')) {
                        $('body').addClass('mdfgf-use-custom-datepicker');
                    }

                    $(this).removeClass('mdfgf-render');
                });
            }

            $(document).on('gform_post_render', function(event, form_id, current_page){
                mdfgfRenderForms();
                mdfgfUpdateUploadPreviews();
            });

            if (typeof gform !== 'undefined') {
                gform.addFilter( 'gform_file_upload_markup', function( html, file, up, strings, imagesUrl ) {
                    html = html.split('\'gformDeleteUploadedFile(').join('\'mdfgfUpdateUploadPreviews();gformDeleteUploadedFile(')
                    mdfgfUpdateUploadPreviews();
                    return html;
                });
            }

            // mdfgfRenderForms();
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
     * Get RGB color
     * 
     * @param string $hexCode
     * 
     * @return string
     */
    public static function hexToRGB($hexCode) {
        $hexCode = ltrim($hexCode, '#');
        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
        }
        list($r, $g, $b) = sscanf('#'.$hexCode, "#%02x%02x%02x");
        
        return array('r' => $r, 'g' => $g, 'b' => $b);
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

        $settings = self::getSettings($form['id']);
        
        if (!empty($settings['design']) && $settings['design'] !== 'mdfgf-gf') {
            $form['cssClass'].= (empty($form['cssClass']) ? '' : ' ').$settings['design'].' mdfgf-render';
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

        $settings = self::getSettings($form['id']);
        if (!empty($settings['design']) && $settings['design'] !== 'mdfgf-gf') {
            if ($field->type !== 'honeypot') {
                $classes.= ' mdfgf-field-type-'.$field->type;
            }

            if ($field->type === 'fileupload' && !empty($field['allowedExtensions'])) {
                $classes.= ' mdfgf-show-extensions';
            }

            if (empty($field->label)) {
                $classes.= ' mdfgf-no-label';
            }

            if ($field->type === 'fileupload' && !empty($field['multipleFiles'])) {
                $classes.= ' mdfgf-multifile';
            }

            if ($field['type'] === 'time' && $field['timeFormat'] === '24') {
                $classes.= ' mdfgf-24';
            }

            if (in_array($field->type, self::$singleTextFields) || ($field['type'] === 'date' && $field['dateType'] === 'datepicker')) {
                $classes.= ' mdfgf-field';
            }

            if (in_array($field->type, self::$columnFields)) {
                $classes.= ' '.($field->size === 'tiny' ? ' mdfgfcol-3' : ($field->size === 'small' ? ' mdfgfcol-4' : ($field->size === 'large' ? ' mdfgfcol-12' : ' mdfgfcol-6')));
            }

            if (in_array($field->type, self::$complexFields)) {
                $classes.= ' mdfgf-complex '.(!empty($field->inputsize) && $field->inputsize === 'tiny' ? ' mdfgfcol-input-3' : (!empty($field->inputsize) && $field->inputsize === 'small' ? ' mdfgfcol-input-4' : (!empty($field->inputsize) && $field->inputsize === 'large' ? ' mdfgfcol-input-12' : ' mdfgfcol-input-6')));
            }
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

        $settings = self::getSettings($form_id);

        if (empty($settings['design']) || $settings['design'] === 'mdfgf-gf') {
            return $content;
        }

        if (strpos($content, 'ginput_complex') === false && ($field['type'] === 'time' || $field['type'] === 'date' && $field['dateType'] !== 'datepicker')) {
            $content = preg_replace("/class=\'([^\']*ginput_container[^\']*)\'/m", "class='ginput_complex $1'", $content);
        }

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
            'ginput_full',
            'gfield_date_dropdown_month',
            'gfield_date_dropdown_day',
            'gfield_date_dropdown_year',
            'gfield_date_month',
            'gfield_date_day',
            'gfield_date_year',
        );

        if (in_array($field['type'], array('address', 'name', 'time', 'post_image', 'date'))) {
            // $content = preg_replace('/\<(select|input) /m', '<$1 class="mdfgf-input" ', $content);
            $content = preg_replace('/(ginput_container_address|ginput_container_name|ginput_container_post_image|clear-multi)/m', 'mdfgf-row $1', $content);
            $content = preg_replace('/('.implode('|',$complexFieldsClasses).')/m', 'mdfgf-field $1', $content);
        }

        preg_match_all('/\<input [^\>]+\>/ms', $content, $inputs);
        preg_match_all('/\<select [^\>]+\>.*?\<\/select\>/ms', $content, $selects);
        preg_match_all('/\<textarea [^\>]+\>.*?\<\/textarea\>/ms', $content, $textareas);

        $tags = array_merge($inputs[0], $selects[0], $textareas[0]);

        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $newTag = '';

                if (stripos($tag, "type='hidden")) {
                    continue;
                }

                // if ($settings['design'] !== 'mdfgf-bootstrap' || ($settings['design'] === 'mdfgf-bootstrap' && !preg_match("/type=\'(checkbox|radio)\'/m", $tag))) {
                    if (preg_match("/class=\'([^\']*)\'/m", $tag, $classMatches)) {
                        $newTag = str_replace($classMatches[0], "class='mdfgf-input".($classMatches[1] ? ' '.$classMatches[1] : '')."'", $tag);
                    } else {
                        $newTag = preg_replace('/\<(select|input|textarea) /m', '<$1 class="mdfgf-input" ', $tag);
                    }
                // }

                if ($settings['label_animation'] === 'line') {
                    if ($newTag && !in_array($field['type'], array('radio', 'checkbox', 'consent', 'fileupload'))) {
                        $newTag = '<div class="mdfgf-fieldset">'.$newTag.'<div class="mdfgf-fieldblockset"><div class="mdfgf-fieldblock"></div><div class="mdfgf-fieldblock mdfgf-fieldblock-label"></div><div class="mdfgf-fieldblock"></div></div></div>';
                    }
                }

                if ($newTag) {
                    $content = str_replace($tag, '<span class="mdfgf-field-input">'.$newTag.'</span>', $content);
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

        $content = str_replace("'gformDeleteUploadedFile(", "'mdfgfUpdateUploadPreviews();gformDeleteUploadedFile(", $content);

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

        $settings = self::getSettings($attributes['id']);

        if(empty($settings['design']) || $settings['design'] === 'mdfgf-gf') {
            return $string;
        }

        $classes = array('mdfgf-container');
        $mainColor = '';
        $themeClass = '';
        $textColorClass = '';
        $autoGrowTextareas = false;
        $useCustomSelects = false;
        $useCustomDatepicker = false;
        $colorString = '';
        $labelAnimation = '';
        $fieldAppearance = '';
        
        if(!empty($settings['design']) && $settings['design'] !== 'mdfgf-gf') {
            if($settings['color']) {
                $mainColor = esc_attr($settings['color']);
            }
            if ($settings['theme']) {
                $themeClass = esc_attr($settings['theme']);
            }
            if (!empty($settings['text_class'])) {
                $textColorClass = esc_attr($settings['text_class']);
            }
            if (!empty($settings['label_animation'])) {
                $labelAnimation = esc_attr($settings['label_animation']);
            }
            if (!empty($settings['field_appearance'])) {
                $fieldAppearance = esc_attr($settings['field_appearance']);
            }
            if (!empty($settings['auto_grow_textareas'])) {
                $autoGrowTextareas = true;
            }
            if (!empty($settings['use_custom_selects'])) {
                $useCustomSelects = true;
            }
            if (!empty($settings['use_custom_datepicker'])) {
                $useCustomDatepicker = true;
            }
        }

        if (isset($attributes['mdfgf_color'])) {
            $mainColor = esc_attr($attributes['mdfgf_color']);
        }
        if (isset($attributes['mdfgf_theme'])) {
            $themeClass = esc_attr($attributes['mdfgf_theme']);
        }
        if (isset($attributes['mdfgf_text_class'])) {
            $textColorClass = esc_attr($attributes['mdfgf_text_class']);
        }
        if (isset($attributes['mdfgf_label_animation'])) {
            $labelAnimation = esc_attr($attributes['mdfgf_label_animation']);
        }
        if (isset($attributes['mdfgf_field_appearance'])) {
            $fieldAppearance = esc_attr($attributes['mdfgf_field_appearance']);
        }
        if (isset($attributes['mdfgf_auto_grow_textareas'])) {
            $autoGrowTextareas = !empty($attributes['mdfgf_auto_grow_textareas']);
        }
        if (isset($attributes['mdfgf_use_custom_selects'])) {
            $useCustomSelects = !empty($attributes['mdfgf_use_custom_selects']);
        }
        if (isset($attributes['mdfgf_use_custom_datepicker'])) {
            $useCustomDatepicker = !empty($attributes['mdfgf_use_custom_datepicker']);
        }

        if ($textColorClass) {
            $classes[] = $textColorClass;
        }

        if ($themeClass) {
            $classes[] = $themeClass;
        }

        if (!empty($labelAnimation)) {
            $classes[] = 'mdfgf-animate-'.$labelAnimation;
        }

        if (!empty($fieldAppearance)) {
            $classes[] = 'mdfgf-'.$fieldAppearance;
        }

        if ($autoGrowTextareas) {
            $classes[] = 'mdfgf-auto-grow-textareas';
        }

        if ($useCustomSelects) {
            $classes[] = 'mdfgf-use-custom-selects';
        }

        if ($useCustomDatepicker) {
            $classes[] = 'mdfgf-use-custom-datepicker';
        }

        if (!$mainColor && $settings['design'] === 'mdfgf-bootstrap') {
            $mainColor = '#007bff';
            $hoverColor = self::adjustBrightness($mainColor, -.2);
        }

        if ($mainColor) {
            $mainColor = strtolower($mainColor);
            if (empty($hoverColor)) {
                $hoverColor = self::adjustBrightness($mainColor, .2);
            }
            $colorString = '
        <style>
/* Modern Designs for Gravity Forms Custom css for Single Form */
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .button,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .button,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .button:active,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .button:active,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .gf_progressbar .gf_progressbar_percentage,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .gf_progressbar .gf_progressbar_percentage,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .ginput_container input[type="checkbox"]:checked:after,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .ginput_container input[type="checkbox"]:checked:after,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .ginput_container input[type="radio"]:checked:after,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .ginput_container input[type="radio"]:checked:after,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' input[type="file"]:active:before,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' input[type="file"]:active:before,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' input[type="file"]:before,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' input[type="file"]:before,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' select[multiple="multiple"] option:checked,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' select[multiple="multiple"] option:checked,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .mdfgf-custom-select.multiple button.active:after,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .mdfgf-custom-select.multiple button.active:after,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .gf_page_steps .gf_step_active .gf_step_number,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .gf_page_steps .gf_step_active .gf_step_number,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .gf_page_steps .gf_step_completed .gf_step_number,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .gf_page_steps .gf_step_completed .gf_step_number,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .gf_page_steps .gf_step_completed + .mdfgf-step-spacer,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .gf_page_steps .gf_step_completed + .mdfgf-step-spacer {
    background-color: '.$mainColor.';
    border-color: '.$mainColor.';
    color: #eee;
}
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .mdfgf-input:focus,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .mdfgf-input:focus,
.mdfgf-container.mdfgf-md-regular #gform_wrapper_'.$attributes['id'].' .mdfgf-md .mdfgf-field.has-focus .mdfgf-field-input:after,
.mdfgf-container.mdfgf-md-regular .gform_wrapper_original_id_'.$attributes['id'].' .mdfgf-md .mdfgf-field.has-focus .mdfgf-field-input:after,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .mdfgf-field.has-focus .mdfgf-fieldset .mdfgf-fieldblock,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .mdfgf-field.has-focus .mdfgf-fieldset .mdfgf-fieldblock {
    border-color: '.($settings['design'] === 'mdfgf-bootstrap' ? self::adjustBrightness($mainColor, .5) : $mainColor).';';

    if ($settings['design'] === 'mdfgf-bootstrap' && $labelAnimation !== 'line') {
        $rgb = self::hexToRGB($mainColor);
        $colorString.= '
    box-shadow: 0 0 0 0.2rem rgba('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].',.2);
    ';
    }
    
    $colorString.= '
}';

if ($settings['design'] === 'mdfgf-bootstrap') {
    $rgb = self::hexToRGB($mainColor);
    $colorString.= '
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .mdfgf-bootstrap .button:focus,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .mdfgf-bootstrap .button:focus {
    box-shadow: 0 0 0 0.2rem rgba('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].',.5);
}
    ';
}
    
$colorString.= '
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .button:hover,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .button:hover,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' input[type="file"]:hover:before,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' input[type="file"]:hover:before,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' .button:focus,
.mdfgf-container .gform_wrapper_original_id_'.$attributes['id'].' .button:focus,
.mdfgf-container #gform_wrapper_'.$attributes['id'].' input[type="file"]:focus:before, 
    .gform_wrapper_original_id_'.$attributes['id'].' input[type="file"]:focus:before {
    background-color: '.$hoverColor.';
}
</style>';

        }
        
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
        $tooltips["mdfgf_design_tooltip"] = "Select which Design Style you would like to use. When using somthing other than Gravity Forms Default, Gravity forms Styles will be de-registered for faster page loads. If you are already using a css framework like Bootstrap or MDB, then it is best to set this to None and 'Add Framework Classes' for your Framework.";
        $tooltips["mdfgf_add_classes_tooltip"] = "Alternatively, if you are already including a css framework like bootstrap or mdb then you can add the classes to the form markup. Currently Supports Bootstrap 4 and MDB (mdbootstrap.com)";
        $tooltips["mdfgf_shortcode_overrides_tooltip"] = "You can Override these values within the shortcode attributes. This is useful when needing to change colors or themes when embedding the form in different locations.<br>Examples:<br>mdfgf_theme=\"mdfgf-theme-default\"<br>mdfgf_theme=\"mdfgf-theme-greyish\"<br>mdfgf_theme=\"mdfgf-theme-ash\"<br>mdfgf_theme=\"mdfgf-theme-dark\"<br>mdfgf_text_class=\"mdfgf-text-light\"<br>mdfgf_color=\"#21759b\"";
        $tooltips["mdfgf_color_tooltip"] = "This will override the Highlight color used for Buttons, Radios and Checkboxes when filled and Focus events. Use Hexadecimal value.<br>Ex #8a8a8a";
        $tooltips["mdfgf_auto_grow_textareas_tooltip"] = "This will collapse all textarea fields in the form to 80px and will auto grow the height when the user types content into the box. The Max height is 300px and will show a scrollbar once they enter that much data.";
        $tooltips["mdfgf_use_custom_selects_tooltip"] = "This will add custom styles and functionality to the Dropdown fields (select fields). Their may be issues when using this with other frameworks, plugins, or older devices.";
        $tooltips["mdfgf_use_custom_datepicker_tooltip"] = "This will add custom styles to the Datepicker.";
        $tooltips["mdfgf_override_globals_tooltip"] = "This will allow you to override the settings from the Global Settings.";
        $tooltips["mdfgf_label_animation_tooltip"] = "This will place the label inside field and use it as a Placeholder. This will also remove the placeholder text if it has been set. The label will be animated once the user sets focus to the field. The placement of the animated label (Above or Below) will still depend on the setting you give it within your field settings";
        $tooltips["mdfgf_field_appearance_tooltip"] = "This will determine how the field inputs will show. When removing the backgrounds or borders make sure your page background color contrasts with the fields enough to be seen. You cannot remove both the border and background as that would make it too difficult for the user to see the field.";
        return $tooltips;
    }

    private static function getForm($formId) 
    {
        if (class_exists('GFAPI')) {
            if ($form = GFAPI::get_form($formId)) {
                return $form;
            }
        }
        return null;
    }
    

    private static function getDefaultSettings() {
        return [
            'design' => 'mdfgf-mdfgf',
            'theme' => 'mdfgf-theme-default',
            'text_class' => '',
            'color' => '',
            'label_animation' => '',
            'field_appearance' => '',
            'add_classes' => '',
            'auto_grow_textareas' => 0,
            'use_custom_selects' => 0,
            'use_custom_datepicker' => 0,
        ];
    }


    private static function getSettings($formId=null) {

        $settings = [];
        $globalSettings = get_option('mdfgf_settings');
        if (empty($globalSettings)) {
            $globalSettings = self::getDefaultSettings();
        }

        if (empty($formId)) {
            return $globalSettings;
        }

        if ($form = self::getForm($formId)) {
            if (empty($form['mdfgf_override_globals'])) {
                return $globalSettings;
            }
            foreach (self::getDefaultSettings() as $settingKey => $setting) {
                if (isset($form['mdfgf_'.$settingKey])) {
                    $settings[$settingKey] = $form['mdfgf_'.$settingKey];
                }
            }
        }

        return $settings;
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

        $settings['Modern Designs for Gravity Forms']['mdfgf_design'] = '
        '.(!rgar($form, 'mdfgf_override_globals') ? '<style>.mdfgf-override-options { display: none; }</style>' : '').'
        '.(!$formDesign || $formDesign === 'mdfgf-gf' ? '<style>.mdfgf-theme-options { display: none; }</style>' : '').'
            <tr>
                <th><label for="mdfgf_use_custom_selects">Override Global Styles '.gform_tooltip("mdfgf_override_globals_tooltip", '', true).'</label></th>
                <td>
                    <input type="checkbox" id="mdfgf_override_globals" name="mdfgf_override_globals" value="1" '.checked(rgar($form, 'mdfgf_override_globals'), 1, false).'> &nbsp; &nbsp; <small><a href="/wp-admin/admin.php?page=gf_settings&subview=mdfgf">Edit Global Settings</a></small>
                </td>
            </tr>
            <tr class="mdfgf-override-options">
                <th><label for="mdfgf_design">Design Style '.gform_tooltip("mdfgf_design_tooltip", '', true).'</label></th>
                <td>
                    <select id="mdfgf_design" name="mdfgf_design" style="width: 300px;">
                        <option value="mdfgf-gf" '.selected($formDesign, 'mdfgf-gf', false, false).'>Gravity Forms Default</option>
                        <option value="mdfgf-mdfgf" '.selected($formDesign, 'mdfgf-mdfgf', false).'>Modern Designs for Gravity Forms</option>
                        <option value="mdfgf-md" '.selected($formDesign, 'mdfgf-md', false).'>Material Design</option>
                        <option value="mdfgf-bootstrap" '.selected($formDesign, 'mdfgf-bootstrap', false).'>Bootstrap</option>
                        <option value="" '.selected($formDesign, '', false).'>None</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-theme-options mdfgf-override-options">
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
            <tr class="mdfgf-theme-options mdfgf-override-options">
                <th><label for="mdfgf_color">Theme Color '.gform_tooltip("mdfgf_color_tooltip", '', true).'</label></th>
                <td>
                    <input type="text" id="mdfgf_color" placeholder="#8a8a8a" name="mdfgf_color" value="'.(rgar($form, 'mdfgf_color') ? rgar($form, 'mdfgf_color') : '').'" style="width: 300px;">
                </td>
            </tr>
            <tr class="mdfgf-theme-options mdfgf-override-options">
                <th><label for="mdfgf_text_class">Text Color</label></th>
                <td>
                    <select id="mdfgf_text_class" name="mdfgf_text_class" style="width: 300px;">
                        <option value="" '.selected(rgar($form, 'mdfgf_theme'), '', false).'>Use Theme Default (Auto Detect)</option>
                        <option value="mdfgf-text-light" '.selected(rgar($form, 'mdfgf_text_class'), 'mdfgf-text-light', false).'>Light Text</option>
                        <option value="mdfgf-text-dark" '.selected(rgar($form, 'mdfgf_text_class'), 'mdfgf-text-dark', false).'>Dark Text</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-theme-options mdfgf-override-options">
                <th><label for="mdfgf_field_appearance">Field Appearance '.gform_tooltip("mdfgf_field_appearance_tooltip", '', true).'</label></th>
                <td>
                    <select id="mdfgf_field_appearance" name="mdfgf_field_appearance" style="width: 300px;">
                        <option class="mdfgf-not-md-options" value="" '.selected(rgar($form, 'mdfgf_field_appearance'), '', false).'>Show Backgrounds and Borders</option>
                        <option class="mdfgf-not-md-options" value="no-backgrounds" '.selected(rgar($form, 'mdfgf_field_appearance'), 'no-backgrounds', false).'>Remove Backgrounds</option>
                        <option class="mdfgf-not-md-options" value="no-borders" '.selected(rgar($form, 'mdfgf_field_appearance'), 'no-borders', false).'>Remove Borders</option>
                        <option class="mdfgf-md-options" value="md-regular" '.selected(rgar($form, 'mdfgf_field_appearance'), 'md-regular', false).'>Regular</option>
                        <option class="mdfgf-md-options" value="md-filled" '.selected(rgar($form, 'mdfgf_field_appearance'), 'md-filled', false).'>Filled</option>
                        <option class="mdfgf-md-options" value="md-outlined" '.selected(rgar($form, 'mdfgf_field_appearance'), 'md-outlined', false).'>Outlined</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-theme-options mdfgf-not-md-options mdfgf-override-options">
                <th><label for="mdfgf_label_animation">Label Animation '.gform_tooltip("mdfgf_label_animation_tooltip", '', true).'</label></th>
                <td>
                    <select id="mdfgf_label_animation" name="mdfgf_label_animation" style="width: 300px;">
                        <option value="" '.selected(rgar($form, 'mdfgf_label_animation'), '', false).'>None</option>
                        <option value="out" '.selected(rgar($form, 'mdfgf_label_animation'), 'out', false).'>On Focus Out</option>
                        <option value="in" '.selected(rgar($form, 'mdfgf_label_animation'), 'in', false).'>On Focus In</option>
                        <option value="line" '.selected(rgar($form, 'mdfgf_label_animation'), 'line', false).'>On Focus Line</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-override-options mdfgf-none-options">
                <th><label for="mdfgf_add_classes">Add Framework Classes '.gform_tooltip("mdfgf_add_classes_tooltip", '', true).'</label></th>
                <td>
                    <select id="mdfgf_add_classes" name="mdfgf_add_classes" style="width: 300px;">
                        <option value="" '.selected(rgar($form, 'mdfgf_add_classes'), '', false).'>None</option>
                        <option value="bootstrap" '.selected(rgar($form, 'mdfgf_add_classes'), 'bootstrap', false).'>Add Bootstrap Classes</option>
                        <option value="mdb" '.selected(rgar($form, 'mdfgf_add_classes'), 'mdb', false).'>Add MDB Pro Classes (mdbootstrap.com)</option>
                    </select>
                </td>
            </tr>
            <tr class="mdfgf-theme-options mdfgf-not-md-options mdfgf-override-options">
                <th><label for="mdfgf_use_custom_selects">Use Custom Dropdowns '.gform_tooltip("mdfgf_use_custom_selects_tooltip", '', true).'</label></th>
                <td>
                    <input type="checkbox" id="mdfgf_use_custom_selects" name="mdfgf_use_custom_selects" value="1" '.checked(rgar($form, 'mdfgf_use_custom_selects'), 1, false).'>
                </td>
            </tr>
            <tr class="mdfgf-theme-options mdfgf-not-md-options mdfgf-override-options">
                <th><label for="mdfgf_use_custom_selects">Use Custom Datepicker '.gform_tooltip("mdfgf_use_custom_datepicker_tooltip", '', true).'</label></th>
                <td>
                    <input type="checkbox" id="mdfgf_use_custom_datepicker" name="mdfgf_use_custom_datepicker" value="1" '.checked(rgar($form, 'mdfgf_use_custom_datepicker'), 1, false).'>
                </td>
            </tr>
            <tr class="mdfgf-theme-options mdfgf-override-options">
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

    public static function globalSettings() 
    {
        $saved = false;

        if (!empty($_POST['mdfgf'])) {
            update_option('mdfgf_settings', $_POST['mdfgf']);
            $saved = true;
        }

        $settings = get_option('mdfgf_settings');
        
        if (empty($settings)) {
            $settings = self::getDefaultSettings();
        }

        ?>
        <?php if ($saved) {?>
        <div class="hidden">
            <div class="updated fade">
				<p>Settings Updated.</p>
			</div>
		</div>
        <?php } ?>
        <h3><span><i class="fa fa-cogs"></i> Modern Designs Global Settings</span></h3>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th><label for="mdfgf_design">Design Style <?php gform_tooltip("mdfgf_design_tooltip", '');?></label></th>
                    <td>
                        <select id="mdfgf_design" name="mdfgf[design]" style="width: 300px;">
                            <option value="mdfgf-gf" <?php selected($settings['design'], 'mdfgf-gf');?>>Gravity Forms Default</option>
                            <option value="mdfgf-mdfgf" <?php selected($settings['design'], 'mdfgf-mdfgf');?>>Modern Designs for Gravity Forms</option>
                            <option value="mdfgf-md" <?php selected($settings['design'], 'mdfgf-md');?>>Material Design</option>
                            <option value="mdfgf-bootstrap" <?php selected($settings['design'], 'mdfgf-bootstrap');?>>Bootstrap</option>
                            <option value="" <?php selected($settings['design'], '');?>>None</option>
                        </select>
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_theme">Theme <?php gform_tooltip("mdfgf_theme_tooltip", '');?></label></th>
                    <td>
                        <select id="mdfgf_theme" name="mdfgf[theme]" style="width: 300px;">
                            <option value="mdfgf-theme-default" <?php selected($settings['theme'], 'mdfgf-theme-default');?>>Default</option>
                            <option value="mdfgf-theme-greyish" <?php selected($settings['theme'], 'mdfgf-theme-greyish');?>>Greyish</option>
                            <option value="mdfgf-theme-vivid" <?php selected($settings['theme'], 'mdfgf-theme-vivid');?>>Vivid</option>
                            <option value="mdfgf-theme-ash" <?php selected($settings['theme'], 'mdfgf-theme-ash');?>>Ash (Good on Medium Dark Backgrounds)</option>
                            <option value="mdfgf-theme-dark" <?php selected($settings['theme'], 'mdfgf-theme-dark');?>>Dark (Good on Dark Backgrounds)</option>
                        </select>
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_color">Theme Color <?php gform_tooltip("mdfgf_color_tooltip", '');?></label></th>
                    <td>
                        <input type="text" id="mdfgf_color" placeholder="#8a8a8a" name="mdfgf[color]" value="<?= ($settings['color'] ? $settings['color'] : '');?>" style="width: 300px;">
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_text_class">Text Color</label></th>
                    <td>
                        <select id="mdfgf_text_class" name="mdfgf[text_class]" style="width: 300px;">
                            <option value="" <?php selected($settings['theme'], '');?>>Use Theme Default (Auto Detect)</option>
                            <option value="mdfgf-text-light" <?php selected($settings['text_class'], 'mdfgf-text-light');?>>Light Text</option>
                            <option value="mdfgf-text-dark" <?php selected($settings['text_class'], 'mdfgf-text-dark');?>>Dark Text</option>
                        </select>
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' || $settings['design'] === 'mdfgf-md' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_field_appearance">Field Appearance <?= gform_tooltip("mdfgf_field_appearance_tooltip", '');?></label></th>
                    <td>
                        <select id="mdfgf_field_appearance" name="mdfgf_field_appearance" style="width: 300px;">
                            <option value="" <?php selected($settings['field_appearance'], '');?>>Show Backgrounds and Borders</option>
                            <option value="no-backgrounds" <?php selected($settings['field_appearance'], 'no-backgrounds');?>>Remove Backgrounds</option>
                            <option value="no-borders" <?php selected($settings['field_appearance'], 'no-borders');?>>Remove Borders</option>
                        </select>
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' || $settings['design'] === 'mdfgf-md' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_label_animation">Label Animation <?php gform_tooltip("mdfgf_label_animation_tooltip", '');?></label></th>
                    <td>
                        <select id="mdfgf_label_animation" name="mdfgf[label_animation]" style="width: 300px;">
                            <option value="" <?php selected($settings['label_animation'], '');?>>None</option>
                            <option value="out" <?php selected($settings['label_animation'], 'out');?>>On Focus Out</option>
                            <option value="in" <?php selected($settings['label_animation'], 'in');?>>On Focus In</option>
                            <option value="line" <?php selected($settings['label_animation'], 'line');?>>On Focus Line</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="mdfgf_add_classes">Add Framework Classes <?php gform_tooltip("mdfgf_add_classes_tooltip", '');?></label></th>
                    <td>
                        <select id="mdfgf_add_classes" name="mdfgf[add_classes]" style="width: 300px;">
                            <option value="" <?php selected($settings['add_classes'], '');?>>None</option>
                            <option value="bootstrap" <?php selected($settings['add_classes'], 'bootstrap');?>>Add Bootstrap Classes</option>
                            <option value="mdb" <?php selected($settings['add_classes'], 'mdb');?>>Add MDB Classes (mdbootstrap.com)</option>
                        </select>
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_use_transparent_backgrounds">Transparent Backgrounds <?php gform_tooltip("mdfgf_use_custom_selects_tooltip", '');?></label></th>
                    <td>
                        <input type="hidden" name="mdfgf[use_transparent_backgrounds]" value="0" readonly>
                        <input type="checkbox" id="mdfgf_use_transparent_backgrounds" name="mdfgf[use_transparent_backgrounds]" value="1" <?php checked($settings['use_transparent_backgrounds'], 1);?>>
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_use_custom_selects">Use Custom Dropdowns <?php gform_tooltip("mdfgf_use_custom_selects_tooltip", '');?></label></th>
                    <td>
                        <input type="hidden" name="mdfgf[use_custom_selects]" value="0" readonly>
                        <input type="checkbox" id="mdfgf_use_custom_selects" name="mdfgf[use_custom_selects]" value="1" <?php checked($settings['use_custom_selects'], 1);?>>
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_use_custom_datepicker">Use Custom Datepicker <?php gform_tooltip("mdfgf_use_custom_datepicker_tooltip", '');?></label></th>
                    <td>
                        <input type="hidden" name="mdfgf[use_custom_datepicker]" value="0" readonly>
                        <input type="checkbox" id="mdfgf_use_custom_datepicker" name="mdfgf[use_custom_datepicker]" value="1" <?php checked($settings['use_custom_datepicker'], 1);?>>
                    </td>
                </tr>
                <tr class="mdfgf-theme-options"<?= (!$settings['design'] || $settings['design'] === 'mdfgf-gf' ? ' style="display:none;"' : '');?>>
                    <th><label for="mdfgf_auto_grow_textareas">Auto Grow Textareas <?php gform_tooltip("mdfgf_auto_grow_textareas_tooltip", '');?></label></th>
                    <td>
                        <input type="hidden" name="mdfgf[auto_grow_textareas]" value="0" readonly>
                        <input type="checkbox" id="mdfgf_auto_grow_textareas" name="mdfgf[auto_grow_textareas]" value="1" <?php checked($settings['auto_grow_textareas'], 1);?>>
                    </td>
                </tr>
                <tr>
                    <th><label for="mdfgf_add_classes">Shortcode Overrides <?php gform_tooltip("mdfgf_shortcode_overrides_tooltip", '');?></label></th>
                    <td></td>
                </tr>
            </table>
            <p class="submit" style="text-align: left;">
                <input type="submit" name="submit" value="Save Settings" class="button-primary gfbutton" id="save">
                <span id="gform_spinner" style="display:none;margin-left:10px;">
                    <img src="http://gtheme.local.com/wp-content/plugins/gravityforms/images/spinner.gif">
                </span>
            </p>
        </form>
        <?php
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
        $form['mdfgf_override_globals'] = rgpost('mdfgf_override_globals');
        $form['mdfgf_design'] = rgpost('mdfgf_design');
        $form['mdfgf_theme'] = rgpost('mdfgf_theme');
        $form['mdfgf_add_classes'] = rgpost('mdfgf_add_classes') ? rgpost('mdfgf_add_classes') : '';
        $form['mdfgf_label_animation'] = rgpost('mdfgf_label_animation') ? rgpost('mdfgf_label_animation') : '';
        $form['mdfgf_text_class'] = rgpost('mdfgf_text_class') ? rgpost('mdfgf_text_class') : '';
        $form['mdfgf_color'] = rgpost('mdfgf_color') ? strtolower(rgpost('mdfgf_color')) : '';
        $form['mdfgf_auto_grow_textareas'] = rgpost('mdfgf_auto_grow_textareas') ? 1 : 0;
        $form['mdfgf_use_custom_selects'] = rgpost('mdfgf_use_custom_selects') ? 1 : 0;
        $form['mdfgf_field_appearance'] = rgpost('mdfgf_field_appearance') ? rgpost('mdfgf_field_appearance') : '';
        $form['mdfgf_use_custom_datepicker'] = rgpost('mdfgf_use_custom_datepicker') ? 1 : 0;
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
                if (!jQuery('#field_size option[value="tiny"]').length) {
                    jQuery('#field_size').prepend('<option value="tiny">Tiny (1/4 Column)</option>');
                }
                jQuery('#field_size option[value="small"]').html('Small (1/3 Column)');
                jQuery('#field_size option[value="medium"]').html('Medium (1/2 Column)');
                jQuery('#field_size option[value="large"]').html('Large (Full Width)');

                if (['<?= implode("','", self::$columnFields);?>'].includes(field.type)) {
                    jQuery('.size_setting.field_setting').show();
                }
                if (['<?= implode("','", self::$complexFields);?>'].includes(field.type)) {
                    jQuery('#field_inputsize').val((typeof field.inputsize !== 'undefined' && field.inputsize ? field.inputsize : 'medium'));
                    jQuery('.size_input_setting.field_setting').show();
                } else {
                    jQuery('.size_input_setting.field_setting').hide();
                }


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
            function mdfgfUpdateSettingFields() {
                if (jQuery('#mdfgf_override_globals').is(':checked')) {
                    jQuery('.mdfgf-override-options').show();
                    var design = jQuery('#mdfgf_design').val(); 

                    if (!design || design === 'mdfgf-gf') {
                        jQuery('.mdfgf-theme-options').hide();
                    } else {
                        jQuery('.mdfgf-theme-options').show();
                        if (design && design === 'mdfgf-md') {
                            jQuery('.mdfgf-md-options').show();
                            jQuery('.mdfgf-not-md-options').hide();
                        } else {
                            jQuery('.mdfgf-md-options').hide();
                            jQuery('.mdfgf-not-md-options').show();
                        }
                    }
                    if (!design) {
                        jQuery('.mdfgf-none-options').show();
                    } else {
                        jQuery('.mdfgf-none-options').hide();
                    }
                } else {
                    jQuery('.mdfgf-override-options').hide();
                }
            }
            jQuery('#mdfgf_design').on('change', function(){
                mdfgfUpdateSettingFields();
            });
            jQuery('#mdfgf_override_globals').on('click', function(){
                mdfgfUpdateSettingFields();
            });
        </script>
        <?php
    }
}

MDFGF::setup();
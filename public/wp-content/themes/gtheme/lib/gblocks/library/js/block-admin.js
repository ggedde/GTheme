if (window.jQuery) {
    jQuery(document).ready(function($)
    {

        // NOTE gBlockData is from localized script passed from php in gblocks.php

        gBlocks = {};

        gBlocks.init = function(){
            var $gpopup = $( $('#acf-group_gblocks .tmpl-popup').html() );

            $.each(gBlockData, function( index, value ) {
                var blockName = index;
                $.each(value.choices, function( index, value ) {
                    if(index){
                        $gpopup.find('[data-layout="' + blockName + '"]').first().parent().after('<li><a href="#" data-layout="grid" data-min="" data-max="" data-format="format-'+index+'">Grid - '+value+'</a></li>');
                    }
                });
            });
            $('.acf-field-flexible-content .tmpl-popup').html($gpopup[0].outerHTML);
            gBlocks.setClick();
        }

        gBlocks.setClick = function(){
            $('[data-event="add-layout"]').on('click touch', function(e){
                $(document).on('click touch', e, gBlocks.addFormat);
            });
        }

        gBlocks.addFormat = function(e){
            if(e.target.dataset.layout && e.target.dataset.layout == 'grid'){
                if(e.target.dataset.format){
                    console.log(e.target.dataset.format);
                    acf.add_action('append', function($el){
                        gBlocks.setClick();
                        var format = $el.find('[id$='+e.target.dataset.layout+'_'+e.target.dataset.format+']');
                        $(format).click();
                    });
                } else {
                    acf.add_action('append', function($el){
                        gBlocks.setClick();
                        var format = $el.find('[id$='+e.target.dataset.layout+'_format]');
                        $(format).click();
                    });
                }
            }
            if(e.target.dataset.layout){
                $(document).off('click touch', gBlocks.addFormat);
            }
        }



        gBlocks.init();


    });
}

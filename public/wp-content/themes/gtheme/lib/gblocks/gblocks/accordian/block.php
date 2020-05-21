<?php

$accordion = isset($accordion) ? $accordion : GBLOCKS::getField($block.'_accordion');
$expand_first_item = isset($expand_first_item) ? $expand_first_item :  GBLOCKS::getField($block.'_expand_first_item');

if($accordion)
{
    ?>
    <div class="block-inner">
        <div class="row">

            <?php foreach($accordion as $accordianKey => $accordianItem){ ?>

                <div class="col-12">
                    <div class="item-container<?php echo (!$accordianKey && $expand_first_item ? ' open' : '');?>">
                        <span class="item-handle"></span>
                        <span class="item-icon"></span>
                        <h4 class="item-title">
                            <?php echo $accordianItem['title'];?>
                        </h4>
                        <div class="item-content">
                            <?php echo $accordianItem['text'];?>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($){

        $('.block-accordian .item-title').off().on('click', function(){
            $(this).closest('.item-container').toggleClass('open');
            $(this).closest('.item-container').find('.item-content').animate({
                height: "toggle",
                opacity: "toggle"
            }, 200);
        });

        $('.block-accordian .item-container .item-content').css('display', 'block');
        $('.block-accordian .item-container:not(.open) .item-content').hide();

    });
    </script>
    <?php
}

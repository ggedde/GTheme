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
                    <div class="item-container<?= (!$accordianKey && $expand_first_item ? ' open' : '');?>">
                        <span class="item-handle"></span>
                        <span class="item-icon"></span>
                        <h4 class="item-title font-weight-400 cursor-pointer mb-2<?= $accordianKey ? ' mt-2' : '';?>">
                            <?= $accordianItem['title'];?>
                        </h4>
                        <div class="item-content mb-4">
                            <?= $accordianItem['text'];?>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
    
    <script>
    jQuery('.block-accordian .item-title').off().on('click', function(){
        jQuery(this).closest('.item-container').toggleClass('open');
        jQuery(this).closest('.item-container').find('.item-content').animate({
            height: "toggle",
            opacity: "toggle"
        }, 200);
    });

    jQuery('.block-accordian .item-container .item-content').css('display', 'block');
    jQuery('.block-accordian .item-container:not(.open) .item-content').hide();
    </script>
    <?php
}

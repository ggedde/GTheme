<?php

$accordians = !empty($block_attributes['is_wp_block']) ? get_field('accordian') : get_sub_field('accordian');
$expand_first_item = !empty($block_attributes['is_wp_block']) ? get_field('expand_first_item') : get_sub_field('expand_first_item');

if($accordians)
{
    ?>
    <div class="block-inner">
        <div class="<?php echo GBLOCKS::css()->row()->get();?>">

            <?php foreach($accordians as $accordian_key => $accordian){ ?>

                <div class="<?php echo GBLOCKS::css()->col()->get();?>">
                    <div class="item-container<?php echo (!$accordian_key && $expand_first_item ? ' open' : '');?>">
                        <span class="item-handle"></span>
                        <span class="item-icon"></span>
                        <h4 class="item-title">
                            <?php echo $accordian['title'];?>
                        </h4>
                        <div class="item-content">
                            <?php echo $accordian['text'];?>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($){

        $('.block-accordian .item-title, .block-accordian .item-container > i.fa').on('click', function(){
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

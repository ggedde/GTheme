<?php

if($accordians = get_sub_field('accordian'))
{
    ?>
    <div class="block-inner">
        <div class="<?php echo GBLOCKS::css()->row()->get();?>">

            <?php foreach($accordians as $accordian_key => $accordian){ ?>

                <div class="<?php echo GBLOCKS::css()->col()->get();?>">
                    <div class="item-container<?php echo (!$accordian_key && get_sub_field('expand_first_item') ? ' open' : '');?>">
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
    <?php
}

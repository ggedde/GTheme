<?php
$image = (has_post_thumbnail() ? get_post_thumbnail_id() : (function_exists('get_field') ? get_field('theme_options_default_post_image', 'option') : ''));
?>

<div class="post mb-5">
    <?php if(!empty($image)){ ?>
        <div class="item-image-container columns small-12 medium-5 large-4">
            <a href="<?php the_permalink();?>" title="<?php the_title();?>" aria-label="<?php the_title();?>">
                <div class="item-image" <?= GBLOCKS::image_sources($image);?>></div>
            </a>
        </div>
    <?php } ?>
    <div class="item-content-container columns small-12 medium-<?php echo (!empty($image) ? 7 : 12);?> large-<?php echo (!empty($image) ? 8 : 12);?>">
        <h3><a class="item-title" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
        <p class="meta">
            <span class="meta-date"><span class="meta-date-label">Posted On: </span> <time datetime="<?php echo the_time('Y-m-d'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> </span>
            <span class="meta-categories"><span class="meta-categories-label">Categories: </span><?php the_category(', '); ?></span>
            <?php if ( comments_open() ) : ?>
                <span><?php comments_popup_link(); ?></span>
            <?php endif; ?>
        </p>
        <p class="item-content"><?php echo wp_trim_words( get_the_excerpt());?></p>
        <div class="read-more">
            <a href="<?php the_permalink();?>" aria-label="Go to <?php the_title();?>">Read More ></a>
        </div>
    </div>
</div>
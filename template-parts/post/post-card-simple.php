<?php
$post_id = get_query_var("post_id") ?: false;
if( !$post_id ){
    return;
}

$postsClass = new post();
$reading_time = $postsClass->getReadingTime( $post_id );

?>

<a class="post-card-simple" href="<?= get_the_permalink($post_id) ?>">
    <figure class="post-card-simple__image">
        <?= get_the_post_thumbnail($post_id , 'medium') ?>
    </figure>
    <div class="post-card-simple__body">
        <h3 class="post-card-simple__title bold fs-16"><?= get_the_title($post_id) ?></h3>
        <div class="post-card-simple__meta">
            <span class="post-card-simple__date">
                <?= get_the_date('j F Y' , $post_id) ?>
            </span>
            <span class="post-card-simple__divider"></span>
            <span class="post-card-simple__reading-time">
                <?= $reading_time ?> min read
            </span>
        </div>
        <span class="post-card-simple__btn">
            Read More
            <svg class="icon ms-1" width="14" height="14">
                <use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#arrow"></use>
            </svg>
        </span>
    </div>
</a>

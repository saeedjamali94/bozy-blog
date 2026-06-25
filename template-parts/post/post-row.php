<?php
$post_id = get_query_var("post_id") ?: false;
if( !$post_id ){
    return;
}

$postsClass = new post();
$reading_time = $postsClass->getReadingTime( $post_id );

?>

<a class="post-row" href="<?= get_the_permalink($post_id) ?>">
    <figure class="post-row__image">
        <?= get_the_post_thumbnail($post_id , 'thumbnail') ?>
    </figure>
    <div class="post-row__content">
        <h3 class="post-row__title bold fs-16"><?= get_the_title($post_id) ?></h3>
        <div class="post-row__meta">
            <span class="post-row__date">
                <?= get_the_date('j F Y' , $post_id) ?>
            </span>
            <span class="post-row__reading-time">
                <?= $reading_time ?> min read
            </span>
        </div>
    </div>
</a>

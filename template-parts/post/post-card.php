<?php
$post_id = get_query_var("post_id") ?: false;
if( !$post_id ){
    return;
}

$post_categories = wp_get_object_terms($post_id, 'category');
$post_date = json_decode(json_encode(get_post_datetime($post_id)))->date;

?>

<a class="post-card" href="<?= get_the_permalink($post_id) ?>">
    <figure>
        <?= get_the_post_thumbnail($post_id , 'medium') ?>
    </figure>
    <div class="post-card__box">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <?php if( count($post_categories) > 0 ){
                foreach( $post_categories as $category ){ ?>
                    <span class="category_item"><?= $category->name ?></span>
                <?php }
            } ?>
        </div>
        <div class="bold fs-16 title mb-4"><?= get_the_title($post_id) ?></div>
        <div>
            <p class="d-flex align-items-center">
                <img class="me-2" src="<?= BOZY_THEME_URI ?>/assets/images/calendar.svg" alt="">
                <?= get_the_date('j F Y' , $post_id) ?>
            </p>
        </div>
    </div>
</a>

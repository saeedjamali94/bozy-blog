<?php
$post_id = get_the_ID();
$postsClass = new post();
$reading_time = $postsClass->getReadingTime($post_id);
$categories = wp_get_object_terms($post_id, 'category');
$comment_count = get_comments_number($post_id);
$author_id = get_post_field('post_author', $post_id);
?>

<div class="post-meta-bar">
    <div class="post-meta-bar__left">
        <span class="post-meta-bar__item">
            <svg class="icon me-1" width="16" height="16"><use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#calendar"></use></svg>
            <?= get_the_date('j F Y') ?>
        </span>
        <span class="post-meta-bar__divider"></span>
        <span class="post-meta-bar__item">
            <svg class="icon me-1" width="16" height="16"><use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#comment"></use></svg>
            <?= $comment_count ?> <?= $comment_count == 1 ? 'Comment' : 'Comments' ?>
        </span>
        <span class="post-meta-bar__divider"></span>
        <span class="post-meta-bar__item">
            <svg class="icon me-1" width="16" height="16"><use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#clock"></use></svg>
            <?= $reading_time ?> min read
        </span>
    </div>
    <div class="post-meta-bar__right">
        <div class="post-author">
            <div class="post-author__avatar">
                <?= get_avatar($author_id, 40) ?>
            </div>
            <div class="post-author__info">
                <span class="post-author__label">Author</span>
                <span class="post-author__name"><?= get_the_author_meta('display_name', $author_id) ?></span>
            </div>
        </div>
    </div>
</div>

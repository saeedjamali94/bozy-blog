<?php
$post_id = get_the_ID();
$categories = wp_get_object_terms($post_id, 'category');
$primary_cat = !empty($categories) ? $categories[0] : null;
?>

<nav class="post-breadcrumb" aria-label="Breadcrumb">
    <a href="<?= home_url() ?>">Home</a>
    <?php if( $primary_cat ): ?>
    <svg class="icon" width="14" height="14"><use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#chevron"></use></svg>
    <a href="<?= get_category_link($primary_cat->term_id) ?>"><?= $primary_cat->name ?></a>
    <?php endif; ?>
    <svg class="icon" width="14" height="14"><use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#chevron"></use></svg>
    <span class="current"><?= get_the_title() ?></span>
</nav>

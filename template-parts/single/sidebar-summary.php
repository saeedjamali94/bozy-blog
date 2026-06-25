<?php
$postsClass = new post();
$summary_posts = $postsClass->getPosts( 'post' , 6 , 'publish' , 0 );
// Exclude current post
$summary_posts = array_filter($summary_posts, function($p) {
    return $p->ID !== get_the_ID();
});
$summary_posts = array_slice($summary_posts, 0, 6);
if( !$summary_posts || !count($summary_posts) ) return;
?>

<div class="sidebar-box">
    <h3 class="sidebar-box__title bold fs-18">Summary</h3>
    <ul class="summary-list">
        <?php foreach( $summary_posts as $post ): ?>
        <li class="summary-list__item">
            <a href="<?= get_the_permalink($post->ID) ?>">
                <svg class="icon me-2" width="14" height="14"><use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#chevron"></use></svg>
                <?= get_the_title($post->ID) ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

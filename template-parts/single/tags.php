<?php
$post_id = get_the_ID();
$tags = wp_get_post_tags($post_id);
if( empty($tags) ) return;
?>

<div class="post-tags">
    <span class="post-tags__label bold me-3">Tags:</span>
    <?php foreach( $tags as $tag ): ?>
        <a class="post-tags__tag" href="<?= get_tag_link($tag->term_id) ?>"><?= $tag->name ?></a>
    <?php endforeach; ?>
</div>

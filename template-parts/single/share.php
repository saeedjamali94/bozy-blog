<?php
$post_id = get_query_var("post_id") ?: get_the_ID();
$post_url = urlencode(get_the_permalink($post_id));
$post_title = urlencode(get_the_title($post_id));
?>

<div class="share-box">
    <span class="share-box__label bold fs-16">Share</span>
    <div class="share-box__links">
        <a class="share-box__link" href="https://www.facebook.com/sharer/sharer.php?u=<?= $post_url ?>" target="_blank" rel="noopener" title="Share on Facebook">
            <img src="<?= BOZY_THEME_URI ?>/assets/images/facebook.svg" width="20" height="20" alt="Facebook">
        </a>
        <a class="share-box__link" href="https://t.me/share/url?url=<?= $post_url ?>&text=<?= $post_title ?>" target="_blank" rel="noopener" title="Share on Telegram">
            <img src="<?= BOZY_THEME_URI ?>/assets/images/telegram.svg" width="20" height="20" alt="Telegram">
        </a>
        <a class="share-box__link" href="https://x.com/intent/post?url=<?= $post_url ?>&text=<?= $post_title ?>" target="_blank" rel="noopener" title="Share on X">
            <img src="<?= BOZY_THEME_URI ?>/assets/images/x.svg" width="20" height="20" alt="X">
        </a>
        <a class="share-box__link" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $post_url ?>" target="_blank" rel="noopener" title="Share on LinkedIn">
            <img src="<?= BOZY_THEME_URI ?>/assets/images/linkedin.svg" width="20" height="20" alt="LinkedIn">
        </a>
        <button class="share-box__link copy-link-btn" data-url="<?= get_the_permalink($post_id) ?>" title="Copy Link">
            <img src="<?= BOZY_THEME_URI ?>/assets/images/copy.svg" width="20" height="20" alt="Link">
            <span class="copy-link-text">Copy Link</span>
        </button>
    </div>
</div>

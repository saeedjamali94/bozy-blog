<?php
if ( post_password_required() ) return;

$post_id = get_the_ID();
$comments = get_comments([
    'post_id' => $post_id,
    'status'  => 'approve',
    'order'   => 'ASC',
]);
?>

<div class="post-comments mt-5" id="comments">
    <h2 class="section-title bold fs-20 mb-4">
        <?= get_comments_number($post_id) ?> <?= get_comments_number($post_id) == 1 ? 'Comment' : 'Comments' ?>
    </h2>

    <?php if( !empty($comments) ): ?>
    <ul class="comments-list">
        <?php
        wp_list_comments([
            'style'       => 'ul',
            'avatar_size' => 48,
            'callback'    => 'bozy_comment_callback',
            'max_depth'   => 2,
        ], $comments);
        ?>
    </ul>
    <?php endif; ?>

    <?php if( !comments_open() && get_comments_number() > 0 ): ?>
        <p class="textColor">Comments are closed.</p>
    <?php endif; ?>

    <div class="comment-respond mt-5" id="respond">
        <h3 class="section-title bold fs-18 mb-4">Leave a Comment</h3>
        <form class="comment-form" action="<?= site_url('wp-comments-post.php') ?>" method="post" id="commentform">
            <div class="row">
                <div class="col-md-6">
                    <div class="comment-form__stack">
                        <div class="comment-form__group">
                            <input type="text" name="author" id="author" class="comment-form__input" placeholder="Name *" required>
                        </div>
                        <div class="comment-form__group">
                            <input type="email" name="email" id="email" class="comment-form__input" placeholder="Email *" required>
                        </div>
                        <div class="comment-form__group">
                            <input type="url" name="url" id="url" class="comment-form__input" placeholder="Website">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="comment-form__group h-100">
                        <textarea name="comment" id="comment" class="comment-form__textarea" placeholder="Your Comment *" required></textarea>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="comment-form__submit" id="submit">Post Comment</button>
            </div>
            <?php comment_id_fields($post_id); ?>
        </form>
    </div>
</div>

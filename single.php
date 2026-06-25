<?php
/**
 * Single Blog Post Template
 */

get_header();

// Custom comment callback
function bozy_comment_callback($comment, $args, $depth) {
    $comment_date = get_comment_date('j F Y', $comment);
    ?>
    <li <?php comment_class('comment-item'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-item__inner">
            <div class="comment-item__avatar">
                <?= get_avatar($comment, 48) ?>
            </div>
            <div class="comment-item__body">
                <div class="comment-item__header">
                    <div class="comment-item__info">
                        <span class="comment-item__name bold"><?= get_comment_author($comment) ?></span>
                        <span class="comment-item__date"><?= $comment_date ?></span>
                    </div>
                    <div class="comment-item__reply">
                        <?php
                        comment_reply_link(array_merge($args, [
                            'reply_text' => '
                                <svg class="icon me-1" width="14" height="14"><use xlink:href="' . BOZY_THEME_URI . '/assets/images/sprite.svg#reply"></use></svg>
                                Reply',
                            'depth'      => $depth,
                            'max_depth'  => $args['max_depth'],
                        ]));
                        ?>
                    </div>
                </div>
                <div class="comment-item__text">
                    <?php if ($comment->comment_approved == '0') : ?>
                        <em>Your comment is awaiting moderation.</em>
                    <?php endif; ?>
                    <?php comment_text($comment); ?>
                </div>
            </div>
        </div>
    <?php
    // Note: closing </li> is added by WordPress
}

while ( have_posts() ) : the_post();
$post_id = get_the_ID();
$postsClass = new post();
$categories = wp_get_object_terms($post_id, 'category');
?>

<main class="single-blog blogMain">
    <div class="container">
        <div class="row">
            <!-- Main Content: col-md-9 -->
            <div class="col-md-9">
                <article class="single-blog__content">
                    <!-- Breadcrumb -->
                    <?php get_template_part('template-parts/single/breadcrumb'); ?>

                    <!-- Title -->
                    <h1 class="single-blog__title bold"><?php the_title(); ?></h1>

                    <!-- Featured Image with Category Tag -->
                    <figure class="single-blog__featured">
                        <?= get_the_post_thumbnail($post_id, 'large') ?>
                        <?php if( !empty($categories) ): ?>
                            <span class="single-blog__cat-tag"><?= $categories[0]->name ?></span>
                        <?php endif; ?>
                    </figure>

                    <!-- Meta Bar -->
                    <?php get_template_part('template-parts/single/meta-bar'); ?>

                    <!-- Post Content -->
                    <div class="single-blog__body contentBox">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <?php get_template_part('template-parts/single/tags'); ?>

                    <!-- Share -->
                    <?php set_query_var("post_id", $post_id);
                    get_template_part('template-parts/single/share'); ?>

                    <!-- Comments -->
                    <?php get_template_part('template-parts/single/comments'); ?>

                    <!-- Recommended Articles -->
                    <?php get_template_part('template-parts/single/recommended'); ?>
                </article>
            </div>

            <!-- Sidebar: col-md-3 -->
            <aside class="col-md-3">
                <div class="single-sidebar">
                    <!-- Important Posts -->
                    <?php get_template_part('template-parts/single/sidebar-important'); ?>

                    <!-- Share -->
                    <?php set_query_var("post_id", $post_id);
                    get_template_part('template-parts/single/share'); ?>

                    <!-- Summary -->
                    <?php get_template_part('template-parts/single/sidebar-summary'); ?>

                    <!-- Newsletter -->
                    <?php get_template_part('template-parts/single/sidebar-newsletter'); ?>
                </div>
            </aside>
        </div>
    </div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>

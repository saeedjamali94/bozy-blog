<?php
$post_id = get_the_ID();
$categories = wp_get_object_terms($post_id, 'category');
$cat_ids = array_map(function($c){ return $c->term_id; }, $categories);
$postsClass = new post();

$recommended = [];
if( !empty($cat_ids) ){
    // Get posts from same categories
    $all_rec = [];
    foreach( $cat_ids as $cat_id ){
        $cat_posts = $postsClass->getPosts('post', 8, 'publish', $cat_id);
        $all_rec = array_merge($all_rec, $cat_posts);
    }
    // Dedupe and exclude current post
    $seen = [];
    foreach( $all_rec as $p ){
        if( $p->ID !== $post_id && !isset($seen[$p->ID]) ){
            $seen[$p->ID] = true;
            $recommended[] = $p;
        }
    }
    $recommended = array_slice($recommended, 0, 8);
}
if( empty($recommended) ) return;
?>

<section class="recommended-articles mt-5">
    <h2 class="section-title bold fs-20 mb-4">Recommended Articles</h2>
    <div class="recommendedCarousel owl-carousel">
        <?php foreach( $recommended as $post ): ?>
            <div class="item">
                <?php set_query_var("post_id" , $post->ID);
                get_template_part("template-parts/post/post-card" , "simple"); ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

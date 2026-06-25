<?php
/**
 * Archive / Category / Tag / Search Template
 */

get_header();

$current_cat_id = is_category() ? get_queried_object_id() : 0;
$current_tag_id = is_tag() ? get_queried_object_id() : 0;
$search_query   = is_search() ? get_search_query() : '';

// Page title
if( is_category() ){
    $page_title = single_cat_title('', false);
} elseif( is_tag() ){
    $page_title = single_tag_title('', false);
} elseif( is_search() ){
    $page_title = 'Search Results: ' . $search_query;
} else {
    $page_title = 'Blog Archive';
}
?>

<main class="blogMain archive-page">
    <div class="container">
        <?php set_query_var("info" , [
            "title" => $page_title,
            "subtitle" => "",
            "extraClass" => "mb-5 pb-3"
        ]) ?>
        <?php get_template_part('template-parts/global/section' , 'title'); ?>

        <!-- Posts Grid: 16 posts, 4 cols -->
        <div class="archive-grid row row-cols-1 row-cols-md-2 row-cols-lg-4" id="archiveGrid">
            <?php
            if( have_posts() ){
                while( have_posts() ){
                    the_post();
                    ?>
                    <div class="col archive-grid__item">
                        <?php set_query_var("post_id" , get_the_ID());
                        get_template_part("template-parts/post/post-card" , "simple"); ?>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                echo '<div class="col-12"><p class="textColor text-center py-5">No posts found.</p></div>';
            }
            ?>
        </div>

        <!-- Load More Button -->
        <?php
        global $wp_query;
        $max_pages = $wp_query->max_num_pages;
        if( $max_pages > 1 ): ?>
        <div class="text-center mt-4 mb-5" id="loadMoreWrap">
            <button class="load-more-btn" id="loadMoreBtn"
                    data-page="1"
                    data-per-page="16"
                    data-category="<?= $current_cat_id ?>"
                    data-tag="<?= $current_tag_id ?>"
                    data-search="<?= esc_attr($search_query) ?>"
                    data-max="<?= $max_pages ?>">
                Load More
            </button>
        </div>
        <?php endif; ?>

        <!-- Trendy Posts Carousel -->
        <?php
        $postsClass = new post();
        $trendy_posts = $postsClass->getPosts( 'post' , 8 );
        if( $trendy_posts && count($trendy_posts) ): ?>
        <section class="trendy-posts mt-5">
            <?php set_query_var("info" , [
                "title" => "Trendy Posts",
                "subtitle" => "",
                "extraClass" => "mb-5 pb-3"
            ]) ?>
            <?php get_template_part('template-parts/global/section' , 'title'); ?>

            <div class="trendyPostsCarousel owl-carousel">
                <?php foreach( $trendy_posts as $post ){ ?>
                    <div class="item">
                        <?php set_query_var("post_id" , $post->ID);
                        get_template_part("template-parts/post/post-card" , "simple"); ?>
                    </div>
                <?php } ?>
            </div>
        </section>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>

<?php
/**
 * Template Name: Homepage
 */

$all_categories = get_categories();
get_header();

?>

<main class="blogMain">
    <div class="container">
        <?php set_query_var("info" , [
            "title" => "Our Blog",
            "subtitle" => "Commodity Market Insights & Analysis",
            "extraClass" => "mb-5 pb-3"
        ]) ?>
        <?php get_template_part('template-parts/global/section' , 'title'); ?>


        <section class="blog-slider">
            <div class="row">
                <?php
                $postsClass = new post();
                $new_posts = $postsClass->getPosts( 'post' , 3 );
                if( $new_posts && count($new_posts) ) {
                    foreach( $new_posts as $index => $post ){
                        switch ($index) {
                            case 1:
                            case 2:
                                $col = 3;
                                break;
                            default:
                                $col = 6;
                                break;
                        }
                        ?>
                        <div class="col-lg-<?= $col ?> mb-3">
                            <?php set_query_var("post_id" , $post->ID);
                            get_template_part("template-parts/post/post" , "card"); ?>
                        </div>
                    <?php }
                } ?>
            </div>
        </section>

        <section class="blog-categories mainSection">
            <?php set_query_var("info" , [
                "title" => "Article Categories",
                "subtitle" => "",
                "extraClass" => "mb-5 pb-3"
            ]) ?>
            <?php get_template_part('template-parts/global/section' , 'title'); ?>

            <!-- tabs -->
            <?php
            if( $all_categories && count($all_categories) ) {
                $tab_items = [[
                    "title" => "All",
                    "link" => "",
                    "data-id" => 0
                ]];
                foreach( $all_categories as $index => $category){
                    $tab_items[] = [
                        "title" => $category->name,
                        "link" => $category->slug,
                        "data-id" => $category->term_id
                    ];
                }
                set_query_var("tabs" , $tab_items); ?>
                <?php get_template_part('template-parts/global/tabs');
            } ?>

            <div class="mt-5 row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="featuredCarousel owl-carousel">
                        <?php
                        $all_articles_posts = $postsClass->getPosts( 'post' , 8 );
                        if( $all_articles_posts && count($all_articles_posts) ) {
                            // First 2 posts as featured carousel in col-lg-8
                            for( $i = 0; $i < min(4, count($all_articles_posts)); $i++ ){ ?>
                                <div class="item">
                                    <?php set_query_var("post_id" , $all_articles_posts[$i]->ID);
                                    get_template_part("template-parts/post/post" , "card"); ?>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="post-list">
                        <?php
                        if( $all_articles_posts && count($all_articles_posts) > 4 ) {
                            // Remaining 4 posts as horizontal rows
                            for( $i = 4; $i < count($all_articles_posts); $i++ ){
                                set_query_var("post_id" , $all_articles_posts[$i]->ID);
                                get_template_part("template-parts/post/post" , "row");
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest Insights: 12 posts in 3 rows × 4 cols -->
        <section class="latest-insights mainSection">
            <?php set_query_var("info" , [
                "title" => "Latest Insights",
                "subtitle" => "",
                "extraClass" => "mb-5 pb-3"
            ]) ?>
            <?php get_template_part('template-parts/global/section' , 'title'); ?>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                <?php
                $insights_posts = $postsClass->getPosts( 'post' , 12 );
                if( $insights_posts && count($insights_posts) ) {
                    foreach( $insights_posts as $post ){ ?>
                        <div class="col">
                            <?php set_query_var("post_id" , $post->ID);
                            get_template_part("template-parts/post/post-card" , "simple"); ?>
                        </div>
                    <?php }
                } ?>
            </div>
        </section>

        <!-- Latest Videos: carousel with mixed layout -->
        <?php
        $videos_category = get_category_by_slug('videos');
        $video_posts = [];
        if( $videos_category ) {
            $video_posts = $postsClass->getPosts( 'post' , 6 , 'publish' , $videos_category->term_id );
        }
        if( !empty($video_posts) ): ?>
        <section class="latest-videos mainSection">
            <?php set_query_var("info" , [
                "title" => "Latest Videos",
                "subtitle" => "",
                "extraClass" => "mb-5 pb-3"
            ]) ?>
            <?php get_template_part('template-parts/global/section' , 'title'); ?>

            <div class="latestVideosCarousel owl-carousel">
                <?php
                // First item: large featured video
                $main_post = $video_posts[0];
                ?>
                <div class="video-slide video-slide--large">
                    <?php set_query_var("post_id" , $main_post->ID);
                    get_template_part("template-parts/post/post" , "card"); ?>
                </div>

                <?php
                // Remaining posts: 2 half-height cards per slide
                for( $i = 1; $i < count($video_posts); $i += 2 ):
                    $card1 = $video_posts[$i];
                    $card2 = isset($video_posts[$i + 1]) ? $video_posts[$i + 1] : null;
                ?>
                <div class="video-slide video-slide--grid">
                    <?php set_query_var("post_id" , $card1->ID);
                    get_template_part("template-parts/post/post-card-simple" , "horizontal"); ?>
                    <?php if( $card2 ):
                        set_query_var("post_id" , $card2->ID);
                        get_template_part("template-parts/post/post-card-simple" , "horizontal");
                    endif; ?>
                </div>
                <?php endfor; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Trendy Posts: carousel with 4 posts in view -->
        <?php
        $trendy_posts = $postsClass->getPosts( 'post' , 8 );
        if( $trendy_posts && count($trendy_posts) ): ?>
        <section class="trendy-posts mainSection">
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

<?php get_footer();
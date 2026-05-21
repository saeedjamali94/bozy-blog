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
                    foreach( $new_posts as $index => $post_id ){
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
                            <?php set_query_var("post_id" , $post_id);
                            get_template_part("template-parts/post/post" , "card"); ?>
                        </div>
                    <?php }
                } ?>
            </div>
        </section>

        <section class="blog-categories mt-5">
            <?php set_query_var("info" , [
                "title" => "Article Categories",
                "subtitle" => "",
                "extraClass" => "mb-5 pb-3"
            ]) ?>
            <?php get_template_part('template-parts/global/section' , 'title'); ?>

            <!-- tabs -->
            <?php
            if( $all_categories && count($all_categories) ) {
                $tab_items = [];
                foreach( $all_categories as $index => $category){
                    $tab_items[] = [
                        "title" => $category->name,
                        "link" => $category->slug,
                    ];
                }
                set_query_var("tabs" , $tab_items) ?>
                <?php get_template_part('template-parts/global/tabs');
            } ?>

            <div class="mt-5 row">
                <div class="col-lg-7">
                    <div class="homeArticleNews owl-carousel">
                        <?php
                        $all_articles_posts = $postsClass->getPosts( 'post' , 6 );
                        if( $all_articles_posts && count($all_articles_posts) ) {
                            foreach( $all_articles_posts as $index => $post_id ){ ?>
                                <div class="item">
                                    <?php set_query_var("post_id" , $post_id);
                                    get_template_part("template-parts/post/post" , "card"); ?>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>

                <div class="col-lg-5">
                    test
                </div>
            </div>
        </section>
    </div>
</main>

<?php get_footer();
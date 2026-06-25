<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class post
{
    public function __construct()
    {

    }


    /**
     * Get the videos category ID (cached)
     * @return int|false
     */
    private function getVideosCategoryId()
    {
        static $videos_cat_id = null;
        if( $videos_cat_id === null ){
            $cat = get_category_by_slug('videos');
            $videos_cat_id = $cat ? $cat->term_id : false;
        }
        return $videos_cat_id;
    }


    /**
     * Get Posts with defined arguments
     * @param $post_type
     * @param $posts_per_page
     * @param $post_status
     * @param $category_id
     * @param $exclude_videos  bool  Exclude posts from the "videos" category (default true)
     * @return mixed
     */
    public function getPosts( $post_type = "post" , $posts_per_page = 10 , $post_status = "publish" , $category_id = 0 , $exclude_videos = true )
    {
        $tax_query = array();
        if($category_id){
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => [$category_id],
            );
        }

        // Exclude videos category by default
        if( $exclude_videos && !$category_id ){
            $videos_cat_id = $this->getVideosCategoryId();
            if( $videos_cat_id ){
                $tax_query[] = array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => [$videos_cat_id],
                    'operator' => 'NOT IN',
                );
            }
        }

        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => $posts_per_page,
            'post_status' => $post_status,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => $tax_query,
        );
        return $posts = get_posts( $args );
    }


    /**
     * Get estimated reading time for a post
     * @param $post_id
     * @return int minutes
     */
    public function getReadingTime( $post_id )
    {
        $content = get_post_field( 'post_content', $post_id );
        $word_count = str_word_count( wp_strip_all_tags( $content ) );
        $reading_time = ceil( $word_count / 200 ); // Average reading speed: 200 words per minute
        return max( 1, $reading_time ); // Minimum 1 minute
    }
}
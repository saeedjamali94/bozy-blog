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
     * Get Posts with defined arguments
     * @param $post_type
     * @param $posts_per_page
     * @param $post_status
     * @return mixed
     */
    public function getPosts( $post_type = "post" , $posts_per_page = 10 , $post_status = "publish" , $category_id = 0 )
    {
        $tax_query = array();
        if($category_id){
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => [$category_id],
            );
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
}
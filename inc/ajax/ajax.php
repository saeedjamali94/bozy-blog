<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ALL AJAX handlers here
 */


/**
 * AJAX to get recent posts from a category
 */
add_action('wp_ajax_bzy_get_category_posts', 'bzy_get_category_posts');
add_action('wp_ajax_nopriv_bzy_get_category_posts', 'bzy_get_category_posts');

function bzy_get_category_posts() {

    // security check
    check_ajax_referer('my_ajax_nonce', 'nonce');

    $cat_id = isset($_POST['category_id']) ? (int)($_POST['category_id']) : false;
    if(!$cat_id) {
        wp_send_json_error([
            'message' => 'Category id is required'
        ]);
    }

    $Post = new Post();
    $latest = $Post->getPosts('post' , 6 , 'publish' , $cat_id);
    $result = [];
    if( count($latest) > 0 ) {
        foreach ($latest as $post) {

            $post_categories = wp_get_object_terms($post->ID, 'category');
            $cat_array = [];
            if( count($post_categories) > 0 ){
                foreach( $post_categories as $category ){
                    $cat_array[] = $category->name;
                }
            }

            $result[] = [
                'id' => $post->ID,
                'post_title' => $post->post_title,
                'link' => get_the_permalink($post->ID),
                'date' => get_the_date('j F Y' , $post->ID),
                'img' => get_the_post_thumbnail_url($post->ID),
                'category' => $cat_array,
            ];
        }
    }

    wp_send_json_success([
        'message' => 'AJAX request successful',
        'data'    => $result,
    ]);

    // Always terminate
    wp_die();
}

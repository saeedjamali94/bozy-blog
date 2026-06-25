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

    $cat_id = isset($_POST['category_id']) ? (int)($_POST['category_id']) : 0;

    $Post = new Post();
    $latest = $Post->getPosts('post' , 8 , 'publish' , $cat_id);
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
                'thumb' => get_the_post_thumbnail_url($post->ID , 'thumbnail'),
                'category' => $cat_array,
                'reading_time' => $Post->getReadingTime($post->ID),
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


/**
 * AJAX newsletter subscription
 */
add_action('wp_ajax_bzy_newsletter_subscribe', 'bzy_newsletter_subscribe');
add_action('wp_ajax_nopriv_bzy_newsletter_subscribe', 'bzy_newsletter_subscribe');

function bzy_newsletter_subscribe() {

    check_ajax_referer('my_ajax_nonce', 'nonce');

    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    if( !is_email($email) ){
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }

    // Store or send to external service — for now log it
    $subscribers = get_option('bzy_newsletter_subscribers', []);
    if( in_array($email, $subscribers) ){
        wp_send_json_error(['message' => 'This email is already subscribed.']);
    }

    $subscribers[] = $email;
    update_option('bzy_newsletter_subscribers', $subscribers);

    wp_send_json_success(['message' => 'Thank you! You have been subscribed successfully.']);

    wp_die();
}


/**
 * AJAX load more posts for archive pages
 */
add_action('wp_ajax_bzy_load_more', 'bzy_load_more');
add_action('wp_ajax_nopriv_bzy_load_more', 'bzy_load_more');

function bzy_load_more() {

    check_ajax_referer('my_ajax_nonce', 'nonce');

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $per_page = isset($_POST['per_page']) ? (int)$_POST['per_page'] : 16;
    $cat_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
    $tag_id = isset($_POST['tag_id']) ? (int)$_POST['tag_id'] : 0;
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => $per_page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $page,
    ];

    if( $cat_id ){
        $args['tax_query'][] = [
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => [$cat_id],
        ];
    } else {
        // Exclude videos category by default
        $videos_cat = get_category_by_slug('videos');
        if( $videos_cat ){
            $args['tax_query'][] = [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => [$videos_cat->term_id],
                'operator' => 'NOT IN',
            ];
        }
    }
    if( $tag_id ){
        $args['tax_query'][] = [
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => [$tag_id],
        ];
    }
    if( $search ){
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    $posts_data = [];
    $Post = new Post();

    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
            $post_id = get_the_ID();

            $post_categories = wp_get_object_terms($post_id, 'category');
            $cat_array = [];
            if( count($post_categories) > 0 ){
                foreach( $post_categories as $category ){
                    $cat_array[] = $category->name;
                }
            }

            $posts_data[] = [
                'id' => $post_id,
                'post_title' => get_the_title(),
                'link' => get_the_permalink(),
                'date' => get_the_date('j F Y'),
                'img' => get_the_post_thumbnail_url($post_id),
                'thumb' => get_the_post_thumbnail_url($post_id, 'thumbnail'),
                'category' => $cat_array,
                'reading_time' => $Post->getReadingTime($post_id),
            ];
        }
        wp_reset_postdata();
    }

    $has_more = $query->max_num_pages > $page;

    wp_send_json_success([
        'posts'    => $posts_data,
        'has_more' => $has_more,
        'page'     => $page,
    ]);

    wp_die();
}


/**
 * AJAX search posts
 */
add_action('wp_ajax_bzy_search_posts', 'bzy_search_posts');
add_action('wp_ajax_nopriv_bzy_search_posts', 'bzy_search_posts');

function bzy_search_posts() {

    check_ajax_referer('my_ajax_nonce', 'nonce');

    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    if( strlen($search) < 2 ){
        wp_send_json_success(['posts' => []]);
    }

    $Post = new Post();
    $args = [
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        's'              => $search,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    // Exclude videos category
    $videos_cat = get_category_by_slug('videos');
    if( $videos_cat ){
        $args['tax_query'] = [[
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => [$videos_cat->term_id],
            'operator' => 'NOT IN',
        ]];
    }

    $query = new WP_Query($args);
    $posts_data = [];

    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
            $post_id = get_the_ID();

            $posts_data[] = [
                'id'           => $post_id,
                'post_title'   => get_the_title(),
                'link'         => get_the_permalink(),
                'date'         => get_the_date('j F Y'),
                'thumb'        => get_the_post_thumbnail_url($post_id, 'thumbnail'),
                'reading_time' => $Post->getReadingTime($post_id),
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json_success(['posts' => $posts_data]);

    wp_die();
}

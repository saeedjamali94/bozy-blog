<?php
/**
 * Bozy template functions and definitions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

require_once ABSPATH . 'vendor/autoload.php';
include "inc/classes/post.php";

// Define theme constants
define("PROJECT_NAME" , "Bozy");
define('BOZY_THEME_DIR', get_template_directory());
define('BOZY_THEME_URI', get_template_directory_uri());
define('BOZY_LOGIN_URL' , 'https://assistant.qubitorbit.com/api/iam/auth/start?client_id=qubitorbit&redirect_uri=https://assistant.qubitorbit.com&browser=true');

// Theme setup
function bozy_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Add support for WooCommerce
    add_theme_support('woocommerce');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'bozy'),
        'footer' => __('Footer Menu', 'bozy'),
    ));
}
add_action('after_setup_theme', 'bozy_theme_setup');


// Enqueue scripts and styles
function bozy_scripts() {
    // Enqueue styles
    wp_enqueue_style('owl-css', BOZY_THEME_URI . '/assets/css/owl.carousel.min.css', array(), time());
    wp_enqueue_style('bozy-main-style', BOZY_THEME_URI . '/assets/css/styles.css', array(), time());
    
    // Enqueue scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('owl-js', BOZY_THEME_URI . '/assets/js/owl.carousel.min.js', array('jquery'), time());
    wp_enqueue_script('bozy-js', BOZY_THEME_URI . '/assets/js/app.js', array('jquery'), time());
    wp_localize_script( 'bozy-js', 'bozy_options',
        array(
            'theme_url' => BOZY_THEME_URI,
            'ajax_url' => admin_url('admin-ajax.php'),
            'sprite_url' => BOZY_THEME_URI.'/assets/images/sprite.svg?v='.time(),
        )
    );
}
add_action('wp_enqueue_scripts', 'bozy_scripts');


include "inc/logger/logger.php";
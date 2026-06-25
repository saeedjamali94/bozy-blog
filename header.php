<?php
// exit if accessed directly
if( !defined('ABSPATH') ){
    exit;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!-- Standard favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BOZY_THEME_URI ?>/assets/images/FavIcon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="<?= BOZY_THEME_URI ?>/assets/images/FavIcon-48x48.png">
    <link rel="icon" type="image/png" sizes="64x64" href="<?= BOZY_THEME_URI ?>/assets/images/FavIcon-64x64.png">

    <!-- Apple Touch Icon (for iOS devices) -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BOZY_THEME_URI ?>/assets/images/FavIcon-180x180.png">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="siteHeader">
    <div class="container siteHeader__container">
        <div class="d-flex align-items-center justify-content-between">
            <div class="ms-2 d-flex align-items-center gap-2">
                <svg class="menuBtn d-lg-none d-inline-block me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M4 4.5L20 4.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 14.5L20 14.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 9.5L20 9.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 19.5L20 19.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <img class="logo" src="<?= BOZY_THEME_URI ?>/assets/images/logo.svg" width="" alt="<?= get_bloginfo('name') ?>">
                <div class="search-box">
                    <button class="search-toggle" type="button" aria-label="Search">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M17.5 17.5L22 22" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20C15.9706 20 20 15.9706 20 11Z" stroke="white" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    </button>
                </div>
            </div>

            <?php
            if( !wp_is_mobile() ){
                // include wordpress nav menu
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id' => 'primary-menu',
                    'menu_class' => 'topNav d-flex align-items-center gap-5',
                    'container' => 'ul',
                    'container_class' => 'd-flex align-items-center gap-5',
                ));
            } else {
                get_template_part("template-parts/navigation/mobile-nav");
            }
            ?>

            <div>
                <a class="d-lg-inline-block d-none" href="<?= BOZY_LOGIN_URL ?>" target="_blank">Login</a>
                <a class="mainBtn style3 small fs-16 ms-2">Book a Demo</a>
            </div>
        </div>
    </div>
</header>

<!-- Search Dropdown -->
<div class="search-dropdown" id="searchDropdown">
    <div class="container">
        <div class="search-dropdown__inner">
            <div class="search-dropdown__input-wrap">
                <svg class="icon search-dropdown__input-icon" width="20" height="20"><use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#search"></use></svg>
                <input type="text" class="search-dropdown__input" id="searchDropdownInput" placeholder="Search articles..." autocomplete="off">
                <button class="search-dropdown__close" type="button" aria-label="Close search">
                    <svg class="icon" width="20" height="20"><use xlink:href="<?= BOZY_THEME_URI ?>/assets/images/sprite.svg#close"></use></svg>
                </button>
            </div>
            <div class="search-dropdown__loading" id="searchLoading">
                <span class="search-dropdown__spinner"></span>
            </div>
            <div class="search-dropdown__results" id="searchResults"></div>
        </div>
    </div>
</div>


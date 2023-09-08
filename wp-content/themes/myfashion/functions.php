<?php
include 'customizer.php';
function my_custom_wc_theme_support()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'my_custom_wc_theme_support');

function initTheme()
{
    add_filter('use_block_editor_for_post', '__return_false');
    register_nav_menu('header-main', __('Menu chính'));
    register_nav_menu('footer-menu', __('Menu footer'));
    register_sidebar([
        'name' => 'First sidebar',
        'id' => 'first_sidebar',
    ]);
}

add_action('init', 'initTheme');

// require_once 'loop-product.php';

add_filter('woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1);
function iconic_cart_count_fragments($fragments)
{
    ob_start();
    include 'mini-cart.php';
    $mini_cart = ob_get_clean();
    $fragments['.cart-contents-count'] = $mini_cart;
    return $fragments;
}

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

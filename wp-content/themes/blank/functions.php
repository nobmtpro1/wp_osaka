<?php
require_once 'const.php';
require_once 'helpers.php';

function my_custom_wc_theme_support()
{
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
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
add_filter('woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1);
add_filter('woocommerce_product_loop_title_classes', 'my_woocommerce_product_loop_title_classes');
add_filter('woocommerce_quantity_input_classes', 'my_woocommerce_quantity_input_classes');
add_action('woocommerce_before_shop_loop', 'my_woocommerce_before_shop_loop', 100);
add_action('woocommerce_product_query', 'my_woocommerce_product_query', 10, 2);
// add_action('woocommerce_before_cart', 'woocommerce_breadcrumb', 10);
// woocommerce_breadcrumb
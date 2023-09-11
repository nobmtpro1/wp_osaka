<?php
require_once 'const.php';
require_once 'helpers.php';

add_action('after_setup_theme', 'my_custom_wc_theme_support');
add_action('init', 'initTheme');
add_filter('woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1);
add_filter('woocommerce_product_loop_title_classes', 'my_woocommerce_product_loop_title_classes');
add_filter('woocommerce_quantity_input_classes', 'my_woocommerce_quantity_input_classes');
add_action('woocommerce_before_shop_loop', 'my_woocommerce_before_shop_loop', 100);
add_action('woocommerce_product_query', 'my_woocommerce_product_query', 10, 2);
add_action('woocommerce_after_add_to_cart_button', 'my_woocommerce_after_add_to_cart_button', 10);

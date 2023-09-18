<?php
if (!session_id()) {
    session_start();
}

include "vendor/autoload.php";
require_once 'const.php';
require_once 'database.php';
require_once 'helpers.php';
require_once 'includes/newsletter/newsletter-table.php';

// woocommerce
add_action('after_setup_theme', 'my_custom_wc_theme_support');
add_action('init', 'initTheme');
add_filter('woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1);
add_filter('woocommerce_product_loop_title_classes', 'my_woocommerce_product_loop_title_classes');
add_filter('woocommerce_quantity_input_classes', 'my_woocommerce_quantity_input_classes');
add_action('woocommerce_before_shop_loop', 'my_woocommerce_before_shop_loop', 100);
add_action('woocommerce_product_query', 'my_woocommerce_product_query', 10, 2);
add_action('woocommerce_after_add_to_cart_button', 'my_woocommerce_after_add_to_cart_button', 10);
add_filter('woocommerce_currency_symbol', 'my_woocommerce_currency_symbol', 10, 2);


// ajax
add_action('wp_ajax_nopriv_submit_newsletter', 'ajax_submit_newsletter');
add_action('wp_ajax_submit_newsletter', 'ajax_submit_newsletter');
add_action('wp_ajax_create_ghn_order', 'ajax_create_ghn_order');

// admin_menu
add_action('admin_menu', function () {
    add_menu_page(__('Newsletters', 'wpbc'), __('Newsletters', 'wpbc'), 'activate_plugins', 'aim_newsletter', 'admin_newsletter', 'dashicons-email-alt', 50);

    add_submenu_page('aim_newsletter', __('Newsletters', 'wpbc'), __('Newsletters', 'wpbc'), 'activate_plugins', 'aim_newsletter', 'admin_newsletter');
});

// enqueue scripts
add_action('wp_enqueue_scripts', 'my_enqueue_function');
add_action('admin_enqueue_scripts', 'my_admin_enqueue_scripts');

// woocommerce_giao_hang_nhanh_settings devvn_woo_district
// dd(get_option('woocommerce_giao_hang_nhanh_settings'));


$flash_message = get_flash_message("success");
if ($flash_message) {
    function wpse60244_custom_admin_notice()
    {
        global $flash_message;
        return print '<div id="message" class="updated fade"><p><strong>Hi!</strong>"' . $flash_message["message"] . '"</p></div>';
    }
    add_action('admin_notices', 'wpse60244_custom_admin_notice');
}

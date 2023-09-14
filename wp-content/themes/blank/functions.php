<?php

use aim_features\newsletter\NewsletterTable;

require_once 'const.php';
require_once 'database.php';
require_once 'helpers.php';
require_once 'includes/newsletter/newsletter-table.php';

add_action('after_setup_theme', 'my_custom_wc_theme_support');
add_action('init', 'initTheme');
add_filter('woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1);
add_filter('woocommerce_product_loop_title_classes', 'my_woocommerce_product_loop_title_classes');
add_filter('woocommerce_quantity_input_classes', 'my_woocommerce_quantity_input_classes');
add_action('woocommerce_before_shop_loop', 'my_woocommerce_before_shop_loop', 100);
add_action('woocommerce_product_query', 'my_woocommerce_product_query', 10, 2);
add_action('woocommerce_after_add_to_cart_button', 'my_woocommerce_after_add_to_cart_button', 10);
add_filter('woocommerce_currency_symbol', 'my_woocommerce_currency_symbol', 10, 2);
add_action('wp_enqueue_scripts', 'my_enqueue_function');

// ajax
add_action('wp_ajax_nopriv_submit_newsletter', 'ajax_submit_newsletter');
add_action('wp_ajax_submit_newsletter', 'ajax_submit_newsletter');

function admin_newsletter()
{
    $table = new NewsletterTable();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'wpbc'), '1') . '</p></div>';
    }

    ob_start();
    require 'includes/newsletter/views/list.php';
    $content = ob_get_clean();
    echo $content;
}

add_action('admin_menu', function () {
    add_menu_page(__('Newsletters', 'wpbc'), __('Newsletters', 'wpbc'), 'activate_plugins', 'aim_newsletter', 'admin_newsletter', 'dashicons-admin-generic', 50);

    add_submenu_page('aim_newsletter', __('Newsletters', 'wpbc'), __('Newsletters', 'wpbc'), 'activate_plugins', 'aim_newsletter', 'admin_newsletter');
});

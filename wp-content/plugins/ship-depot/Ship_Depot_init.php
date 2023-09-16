<?php

/**
 * Plugin Name:       Ship Depot
 * Plugin URI:        https://shipdepot.vn/
 * Description:       Ship Depot support shipping couriers in Vietnam like GHN, GHTK, AhaMove.
 * Version:           1.1.1
 * Author:            ShipDepot.vn
 * Text Domain:       ship-depot-translate
 * Domain Path:       /languages
 * Requires at least: 6.1.1
 * Requires PHP:      7.4.3
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!defined('SHIP_DEPOT_PLUGIN_FILE')) {
    define('SHIP_DEPOT_PLUGIN_FILE', __FILE__);
}

if (!defined('SHIP_DEPOT_DIR_URL')) {
    define('SHIP_DEPOT_DIR_URL', plugin_dir_url(__FILE__));
}

if (!defined('SHIP_DEPOT_DIR_PATH')) {
    define('SHIP_DEPOT_DIR_PATH', plugin_dir_path(__FILE__));
}

if (!defined('SHIP_DEPOT_LOCALE')) {
    define('SHIP_DEPOT_LOCALE', 'vi-VN');
}

if (!defined('SHIP_DEPOT_VERSION')) {
    define('SHIP_DEPOT_VERSION', '1.0.0');
}

if (!defined('SHIP_DEPOT_WEIGHT_UNIT')) {
    define('SHIP_DEPOT_WEIGHT_UNIT', 'gram');
}

if (!defined('SHIP_DEPOT_MEASUREMENT_UNIT')) {
    define('SHIP_DEPOT_MEASUREMENT_UNIT', 'cm');
}

if (!defined('SHIP_DEPOT_HOST_API')) {
    define('SHIP_DEPOT_HOST_API', 'https://admin.shipdepot.co/api');
}

if (!defined('SHIP_DEPOT_SITE')) {
    define('SHIP_DEPOT_SITE', 'https://shipdepot.vn');
}

if (!defined('SHIP_DEPOT_SHIPPING_METHOD')) {
    define('SHIP_DEPOT_SHIPPING_METHOD', 'sd_shipdepot_shipping_method');
}

if (!defined('SD_SELECT_CITY_TEXT')) {
    define('SD_SELECT_CITY_TEXT', __('Chọn tỉnh/thành phố', 'ship-depot-translate'));
}

if (!defined('SD_SELECT_DISTRICT_TEXT')) {
    define('SD_SELECT_DISTRICT_TEXT', __('Chọn quận/huyện', 'ship-depot-translate'));
}

if (!defined('SD_SELECT_WARD_TEXT')) {
    define('SD_SELECT_WARD_TEXT', __('Chọn phường/xã', 'ship-depot-translate'));
}

if (!defined('SD_DELIVERING_STATUS')) {
    define('SD_DELIVERING_STATUS', 'delivering');
}

if (!defined('SD_DELI_SUCCESS_STATUS')) {
    define('SD_DELI_SUCCESS_STATUS', 'delivered');
}

if (!defined('SD_FOR_CONTROL_STATUS')) {
    define('SD_FOR_CONTROL_STATUS', 'for_control');
}

if (!defined('SD_DELI_FAIL_STATUS')) {
    define('SD_DELI_FAIL_STATUS', 'delivery_fail');
}

if (!defined('SD_CANCEL_STATUS')) {
    define('SD_CANCEL_STATUS', 'cancel');
}

if (!defined('GHTK_COURIER_CODE')) {
    define('GHTK_COURIER_CODE', 'GHTK');
}

if (!defined('GHN_COURIER_CODE')) {
    define('GHN_COURIER_CODE', 'GHN');
}

if (!defined('GHTK_PROVINCE_SPECIAL')) {
    //Lâm Đồng(209) và Kiên Giang(219)
    define('GHTK_PROVINCE_SPECIAL', '209,219');
}

include_once(ABSPATH . 'wp-admin/includes/plugin.php');



if (!class_exists('Ship_Depot', false)) {
    include_once dirname(__FILE__) . '/includes/class-ship-depot-general.php';
}

if (!function_exists('Ship_Depot_init')) {
    function Ship_Depot_init()
    {
        return Ship_Depot::instance();
    }

    function ship_depot_plugins_loaded()
    {
        $GLOBALS['sd'] = Ship_Depot_init();
    }

    add_action('plugins_loaded', 'ship_depot_plugins_loaded');
}

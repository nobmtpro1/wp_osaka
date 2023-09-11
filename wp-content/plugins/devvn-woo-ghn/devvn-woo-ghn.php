<?php
/*
 * Plugin Name: Woocommerce - Giao Hàng Nhanh (GHN)
 * Plugin URI: https://levantoan.com/san-pham/plugin-ket-noi-giao-hang-nhanh-voi-woocommerce/
 * Requires PHP: 7.2
 * Version: 2.0.6
 * Description: Tính phí vận chuyển, đăng đơn, kiểm tra tình trạng đơn hàng với giao hàng nhanh (GHN)
 * Author: GHN - Dev by Le Van Toan
 * Author URI: https://levantoan.com
 * Text Domain: devvn-ghn
 * Domain Path: /languages
 * WC requires at least: 3.0.0
 * WC tested up to: 5.0.0
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if (!defined('DEVVN_GHNV2_VERSION_NUM'))
    define('DEVVN_GHNV2_VERSION_NUM', '2.0.6');
if (!defined('DEVVN_GHNV2_URL'))
    define('DEVVN_GHNV2_URL', plugin_dir_url(__FILE__));
if (!defined('DEVVN_GHNV2_BASENAME'))
    define('DEVVN_GHNV2_BASENAME', plugin_basename(__FILE__));
if (!defined('DEVVN_GHNV2_PLUGIN_DIR'))
    define('DEVVN_GHNV2_PLUGIN_DIR', plugin_dir_path(__FILE__));
if (!defined('DEVVN_GHNV2_NOTE_VERSION'))
    define('DEVVN_GHNV2_NOTE_VERSION', 1);

if(extension_loaded('ionCube Loader')) {
    include 'devvn-woo-ghn-main.php';
}else{
    function devvn_ghn_admin_notice__error() {
        $class = 'notice notice-error';
        $message = __( 'Để Plugin <strong>Woocommerce - Giao Hàng Nhanh (GHN)</strong> hoạt động, bắt buộc cần kích hoạt <strong>php extension ionCube</strong>. <a href="https://levantoan.com/huong-dan-kich-hoat-extension-ioncube/" target="_blank" rel="nofollow">Xem hướng dẫn tại đây</a>', 'devvn-ghn' );

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
    }
    add_action( 'admin_notices', 'devvn_ghn_admin_notice__error' );
}
<?php

use aim_features\newsletter\NewsletterTable;

if (!function_exists('dd')) {
    function dd()
    {
        foreach (func_get_args() as $x) {
            dump($x);
        }
        die;
    }
} else {
    die('dd');
}

if (!function_exists('my_custom_wc_theme_support')) {
    function my_custom_wc_theme_support()
    {
        add_theme_support('custom-logo');
        add_theme_support('woocommerce');
        // add_theme_support('wc-product-gallery-zoom');
        // add_theme_support('wc-product-gallery-lightbox');
        // add_theme_support('wc-product-gallery-slider');
    }
} else {
    die('my_custom_wc_theme_support');
}

if (!function_exists('initTheme')) {
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
} else {
    die('initTheme');
}

if (!function_exists('my_admin_enqueue_scripts')) {
    function my_admin_enqueue_scripts($hook)
    {
        wp_enqueue_script('my_admin_enqueue_scripts_2', TEMPLATE_DIRECTORY . '/assets/js/admin.js', null, null, true);
    }
} else {
    die('my_admin_enqueue_scripts');
}

if (!function_exists('get_percent_sale')) {
    function get_percent_sale($product)
    {

        if ($product->is_type('variable')) {
            $percentages = array();

            // Get all variation prices
            $prices = $product->get_variation_prices();

            // Loop through variation prices
            foreach ($prices['price'] as $key => $price) {
                // Only on sale variations
                if ($prices['regular_price'][$key] !== $price) {
                    // Calculate and set in the array the percentage for each variation on sale
                    $percentages[] = round(100 - (floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100));
                }
            }
            // We keep the highest value
            $percentage = @max($percentages) ? @max($percentages) . '%' : "";
        } elseif ($product->is_type('grouped')) {
            $percentages = array();

            // Get all variation prices
            $children_ids = $product->get_children();

            // Loop through variation prices
            foreach ($children_ids as $child_id) {
                $child_product = wc_get_product($child_id);

                $regular_price = (float) $child_product->get_regular_price();
                $sale_price    = (float) $child_product->get_sale_price();

                if ($sale_price != 0 || !empty($sale_price)) {
                    // Calculate and set in the array the percentage for each child on sale
                    $percentages[] = round(100 - ($sale_price / $regular_price * 100));
                }
            }
            // We keep the highest value
            $percentage = max($percentages) . '%';
        } else {
            $regular_price = (float) $product->get_regular_price();
            $sale_price    = (float) $product->get_sale_price();

            if ($sale_price != 0 || !empty($sale_price)) {
                $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
            } else {
                return "";
            }
        }
        return $percentage;
    }
} else {
    die('get_percent_sale');
}

if (!function_exists('handle_render_percent_sale')) {
    function handle_render_percent_sale()
    {
        global $product;
        echo ("Tiết kiệm " . get_percent_sale($product));
    }
} else {
    die('handle_render_percent_sale');
}

if (!function_exists('my_woocommerce_product_loop_title_classes')) {
    function my_woocommerce_product_loop_title_classes($output)
    {
        $output .= " w-loop-title";
        return $output;
    }
} else {
    die('my_woocommerce_product_loop_title_classes');
}

if (!function_exists('get_products_by_category')) {
    function get_products_by_category($category_id, $number)
    {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $number,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'         => $category_id,
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                )
            )
        );
        $products = new WP_Query($args);
        return $products;
    }
} else {
    die('get_products_by_category');
}


if (!function_exists('get_all_categories')) {
    function get_all_categories()
    {
        $taxonomy     = 'product_cat';
        $orderby      = 'name';
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no  
        $title        = '';
        $hide_empty = true;

        $args = array(
            'taxonomy'     => $taxonomy,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $hide_empty
        );
        $all_categories = get_categories($args);
        return $all_categories;
    }
} else {
    die('get_all_categories');
}


if (!function_exists('generateRandomString')) {

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
} else {
    die('generateRandomString');
}

if (!function_exists('my_woocommerce_quantity_input_classes')) {

    function my_woocommerce_quantity_input_classes($classes)
    {
        $classes[] = "w-quantity-input";
        return $classes;
    }
} else {
    die('my_woocommerce_quantity_input_classes');
}

if (!function_exists('get_all_term_parents')) {

    function get_all_parents($term, $array)
    {
        if ($term->parent !== 0) {
            $parent = get_term($term->parent);
            $array[] = $parent;
            return get_all_parents($parent, $array);
        } else {
            return array_reverse($array);
        }
    }
} else {
    die('get_all_term_parents');
}

if (!function_exists('iconic_cart_count_fragments')) {
    function iconic_cart_count_fragments($fragments)
    {
        ob_start();
        include 'views/mini-cart.php';
        $mini_cart = ob_get_clean();
        $fragments['.cart-contents-count'] = $mini_cart;
        return $fragments;
    }
} else {
    die('iconic_cart_count_fragments');
}

if (!function_exists('my_woocommerce_before_shop_loop')) {
    function my_woocommerce_before_shop_loop()
    {
        include 'views/shop_filter.php';
    }
} else {
    die('my_woocommerce_before_shop_loop');
}

// my_woocommerce_product_query
if (!function_exists('my_woocommerce_product_query')) {
    function my_woocommerce_product_query($q)
    {
        $price_range = $_GET["price_range"];

        $meta_query = $q->get('meta_query');

        if ($price_range) {
            $price_range_arr = explode("-", $price_range);
            $meta_query = array(
                'relation' => 'and',
                array(
                    'key'     => '_price',
                    'value'   => (int) @$price_range_arr[0],
                    'compare' => '>=',
                    'type' => 'UNSIGNED'
                ),
                array(
                    'key'     => '_price',
                    'value'   => (int) @$price_range_arr[1],
                    'compare' => '<=',
                    'type' => 'UNSIGNED'
                ),
            );
        }

        $q->set('meta_query', $meta_query);
        $q->meta_query = $meta_query;
        // dd( $q);
    }
} else {
    die('my_woocommerce_product_query');
}

if (!function_exists('my_woocommerce_after_add_to_cart_button')) {
    function my_woocommerce_after_add_to_cart_button()
    {
        include 'views/buy_now_button.php';
    }
} else {
    die('my_woocommerce_after_add_to_cart_button');
}

if (!function_exists('my_woocommerce_currency_symbol')) {
    function my_woocommerce_currency_symbol($currency_symbol, $currency)
    {
        switch ($currency) {
            case 'VND':
                $currency_symbol = 'đ';
                break;
        }
        return $currency_symbol;
    }
} else {
    die('my_woocommerce_currency_symbol');
}

if (!function_exists('my_enqueue_function')) {
    function my_enqueue_function()
    {
        wp_enqueue_script('wp-util');
        wp_enqueue_script('my-script', 'my-script.js', ['wp-util']);
    }
} else {
    die('my_enqueue_function');
}

if (!function_exists('ajax_submit_newsletter')) {
    function ajax_submit_newsletter($data)
    {
        $email = @$_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            wp_send_json_error(["message" => "Email không hợp lệ"]);
        }
        global $wpdb;
        $wpdb->insert(NEWSLETTER_TABLE, ['email' => $email], ['%s']);
        wp_send_json_success(["message" => "Đăng ký thành công"]);
    }
} else {
    die('ajax_submit_newsletter');
}

if (!function_exists('admin_newsletter')) {
    function admin_newsletter()
    {
        $table = new NewsletterTable();
        $table->prepare_items();
        ob_start();
        require 'includes/newsletter/views/list.php';
        $content = ob_get_clean();
        echo $content;
    }
} else {
    die('admin_newsletter');
}

if (!function_exists('create_flash_message')) {
    function create_flash_message(string $name, string $message, string $type)
    {
        if (isset($_SESSION[FLASH_MESSAGES][$name])) {
            unset($_SESSION[FLASH_MESSAGES][$name]);
        }
        $_SESSION[FLASH_MESSAGES][$name] = ['message' => $message, 'type' => $type];
    }
} else {
    die('create_flash_message');
}

if (!function_exists('get_flash_message')) {
    function get_flash_message(string $name)
    {
        if (!isset($_SESSION[FLASH_MESSAGES][$name])) {
            return false;
        }
        $flash_message = $_SESSION[FLASH_MESSAGES][$name];
        unset($_SESSION[FLASH_MESSAGES][$name]);
        return $flash_message;
    }
} else {
    die('get_flash_message');
}

if (!function_exists('ajax_create_ghn_order')) {
    function ajax_create_ghn_order()
    {
        try {
            $order = wc_get_order($_POST["order_id"]);
            $shipping = $order->data["shipping"];
            // dd($order->data);

            $line_items = $order->data["line_items"];
            $items = [];
            foreach ($line_items as $line_item) {
                $data = $line_item->get_data();
                $product = wc_get_product($data["product_id"])->get_data();
                $items[] = [
                    "name" => $data["name"],
                    "code" => $product["sku"],
                    "quantity" => (int) $data["quantity"],
                    "price" => (int) $data["total"],
                    "length" => (int)$product["length"],
                    "width" => (int)$product["width"],
                    "height" => (int)$product["height"],
                    "weight" => (int)$product["weight"],
                    "category" => [
                        "level1" => @get_term(@$product["category_ids"][0])->name
                    ]
                ];
            }

            $settings = get_option('woocommerce_giao_hang_nhanh_settings');
            $token = $settings["api_token"];

            $body = [
                "payment_type_id" => (int)$_POST["payment_type_id"],
                "note" => $_POST["note"],
                "required_note" => $_POST["required_note"],
                "client_order_code" => $_POST["client_order_code"],
                "to_name" => $shipping["first_name"],
                "to_phone" => $shipping["phone"],
                "to_address" => $shipping["address_1"],
                "to_ward_code" => $shipping["city"],
                "to_district_id" => (int)end((explode("_", $shipping["state"]))),
                "cod_amount" =>  (int)$_POST["cod_amount"],
                "weight" => (int)$_POST["weight"],
                "length" => (int)$_POST["length"],
                "width" => (int)$_POST["width"],
                "height" => (int)$_POST["height"],
                "deliver_station_id" => null,
                "insurance_value" =>  (int)$_POST["insurance_value"],
                "service_type_id" => 2,
                "items" => $items
            ];
            // dd($body);
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                'https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/create',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        "Token" => $token,
                        "ShopId" => $_POST["shop_id"]
                    ],
                    'body' =>  json_encode($body)
                ]
            );
            $response_data = json_decode($response->getBody()->getContents());
            if (metadata_exists('post', $_POST["order_id"], GHN_ORDER_CODE)) {
                update_post_meta($_POST["order_id"], GHN_ORDER_CODE, $response_data->data->order_code);
            } else {
                add_post_meta($_POST["order_id"], GHN_ORDER_CODE, $response_data->data->order_code, true);
            }
            add_action('admin_notices', 'wpse75629_admin_notice');
            $message = $response_data->message_display;
            create_flash_message("success", $response_data->message_display, "success");
            wp_send_json_success(["message" => $message]);
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $message = json_decode($e->getResponse()->getBody()->getContents())->code_message_value;
            wp_send_json_error(["message" => $message]);
        }
    }
} else {
    die('ajax_create_ghn_order');
}

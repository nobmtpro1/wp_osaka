<?php
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
    die('generateRandomString');
}

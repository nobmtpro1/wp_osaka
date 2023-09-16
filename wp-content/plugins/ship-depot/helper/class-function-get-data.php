<?php
defined('ABSPATH') || exit;

if (!class_exists('Ship_Depot_Get_Data')) {
    class Ship_Depot_Get_Data
    {
        public array $post_data;
        public int $order_id;
        function __construct($post_data = array(), $order_id = 0)
        {
            $this->post_data = $post_data;
            $this->order_id = $order_id;
        }

        public function get_package_sizes(): array
        {
            $list_package_size = [];
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot']) || !isset($this->post_data['shipdepot']['package_id'])) {
                return $list_package_size;
            }

            foreach ($this->post_data['shipdepot']['package_id'] as $id) {
                $pk_id = sanitize_text_field($id);
                $pk_size = new Ship_Depot_Package();
                $pk_size->Length = str_replace('.', '', sanitize_text_field($this->post_data['shipdepot'][$pk_id]['length']));
                $pk_size->Width = str_replace('.', '', sanitize_text_field($this->post_data['shipdepot'][$pk_id]['width']));
                $pk_size->Height = str_replace('.', '', sanitize_text_field($this->post_data['shipdepot'][$pk_id]['height']));
                $pk_size->Weight = str_replace('.', '', sanitize_text_field($this->post_data['shipdepot'][$pk_id]['weight']));
                array_push($list_package_size, $pk_size);
            }
            return $list_package_size;
        }

        public function get_json_sender_storage(): string
        {
            //List package sizes
            $json_sender_storage = '';
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot'])) {
                return $json_sender_storage;
            }

            $json_sender_storage = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['sender_storage'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['sender_storage']);
            return $json_sender_storage;
        }

        public function get_json_sender_info(): string
        {
            $json_sender_info = '';
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot'])) {
                return $json_sender_info;
            }

            $json_sender_info = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['sender_info'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['sender_info']);
            $json_sender_info = Ship_Depot_Helper::CleanJsonFromHTML($json_sender_info);
            return $json_sender_info;
        }

        public function get_receiver_info(): Ship_Depot_Receiver
        {
            //List package sizes
            $receiver = new Ship_Depot_Receiver();
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot']) || !isset($this->post_data['shipdepot']['receiver'])) {
                return $receiver;
            }

            $receiver->Type = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['type'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['type']);
            $receiver->Hamlet = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['ghtkHamlet'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['ghtkHamlet']);
            if ($receiver->Type == 'other') {
                $receiver->FirstName = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['firstName'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['firstName']);
                $receiver->LastName = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['lastName'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['lastName']);
                $receiver->Province = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['province'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['province']);
                $receiver->District = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['district'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['district']);
                $receiver->Ward = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['ward'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['ward']);
                $receiver->Address = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['address'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['address']);
                $receiver->Phone = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['receiver']['phone'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['receiver']['phone']);
            } else {
                $receiver->FirstName = get_post_meta($this->order_id, '_shipping_first_name', true);
                $receiver->LastName = get_post_meta($this->order_id, '_shipping_last_name', true);
                $receiver->Province = get_post_meta($this->order_id, '_shipping_city', true);
                $receiver->District = get_post_meta($this->order_id, '_shipping_district', true);
                $receiver->Ward = get_post_meta($this->order_id, '_shipping_ward', true);
                $receiver->Address = get_post_meta($this->order_id, '_shipping_address_1', true);
                $receiver->Phone = get_post_meta($this->order_id, '_shipping_phone', true);
            }
            return $receiver;
        }

        public function get_insurance_info(): Ship_Depot_Insurance
        {
            //List package sizes
            $insurance = new Ship_Depot_Insurance();
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot']) || !isset($this->post_data['shipdepot']['advance']) || !isset($this->post_data['shipdepot']['advance']['insurance'])) {
                return $insurance;
            }
            if (!Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['advance']['insurance']['isActive']))) {
                $insurance->IsActive = Ship_Depot_Helper::get_data_from_checkbox(sanitize_text_field($this->post_data['shipdepot']['advance']['insurance']['isActive']));
            }

            if ($insurance->IsActive && !Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['advance']['insurance']['value']))) {
                $insurance->Value =  intval(str_replace('.', '', sanitize_text_field($this->post_data['shipdepot']['advance']['insurance']['value'])));
            }
            return $insurance;
        }

        public function get_cod_info(): Ship_Depot_Cod
        {
            //List package sizes
            $cod = new Ship_Depot_Cod();
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot']) || !isset($this->post_data['shipdepot']['advance']) || !isset($this->post_data['shipdepot']['advance']['cod'])) {
                return $cod;
            }

            if (!Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['advance']['cod']['isActive']))) {
                $cod->IsActive = Ship_Depot_Helper::get_data_from_checkbox($this->post_data['shipdepot']['advance']['cod']['isActive']);
            }

            if ($cod->IsActive && !Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['advance']['cod']['value']))) {
                $cod->Value = intval(str_replace('.', '', sanitize_text_field($this->post_data['shipdepot']['advance']['cod']['value'])));
            }
            return $cod;
        }

        public function get_json_selected_shipping(): string
        {
            $json_selected_shipping = '';
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot'])) {
                return $json_selected_shipping;
            }

            $json_selected_shipping = sanitize_text_field($this->post_data['shipdepot']['selectedShipping']);
            if (!Ship_Depot_Helper::check_null_or_empty($json_selected_shipping)) {
                $json_selected_shipping =  Ship_Depot_Helper::CleanJsonFromHTML($json_selected_shipping);
            }
            return $json_selected_shipping;
        }

        public function get_selected_shipping(): Ship_Depot_Shipping_Fee_Response
        {
            $selected_shipping = new Ship_Depot_Shipping_Fee_Response();
            $json_selected_shipping = $this->get_json_selected_shipping();
            if (!Ship_Depot_Helper::check_null_or_empty($json_selected_shipping)) {
                $selected_shipping_obj = json_decode($json_selected_shipping);
                $selected_shipping = new Ship_Depot_Shipping_Fee_Response($selected_shipping_obj);
            }
            return $selected_shipping;
        }

        public function get_selected_courier(): string
        {
            $selected_courier = '';
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot'])) {
                return $selected_courier;
            }

            $selected_courier = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['selectedCourier'])) ? '' : sanitize_text_field($this->post_data['shipdepot']['selectedCourier']);
            return $selected_courier;
        }

        public function get_ship_from_station(): Ship_Depot_Ship_From_Station
        {
            $ship_from_station = new Ship_Depot_Ship_From_Station();
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot'])) {
                return $ship_from_station;
            }
            //shipdepot[ShipFromStation]
            $ship_from_station->IsActive = Ship_Depot_Helper::get_data_from_checkbox(sanitize_text_field($this->post_data['shipdepot']['ShipFromStation']['IsActive']));
            if ($ship_from_station->IsActive) {
                $province_code = sanitize_text_field($this->post_data['shipdepot']['ShipFromStation']['ProvinceCode']);
                $province = new Ship_Depot_Province(Ship_Depot_Address_Helper::get_province_by_id($province_code));
                $district_code = sanitize_text_field($this->post_data['shipdepot']['ShipFromStation']['DistrictCode']);
                $district = new Ship_Depot_District(Ship_Depot_Address_Helper::get_district_by_id($province_code, $district_code));
                $ship_from_station->Province = $province;
                $ship_from_station->District = $district;
                if (isset($this->post_data['shipdepot']['ShipFromStation']['SelectedStation']) && !Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['ShipFromStation']['SelectedStation']))) {
                    $ship_from_station->Station = new Ship_Depot_Station(Ship_Depot_Helper::CleanJsonFromHTMLAndDecode(sanitize_text_field($this->post_data['shipdepot']['ShipFromStation']['SelectedStation'])));
                } else {
                    $ship_from_station->Station = new Ship_Depot_Station();
                    if (isset($this->post_data['shipdepot']['ShipFromStation']['StationID']) && !Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['ShipFromStation']['StationID']))) {
                        $ship_from_station->Station->Id = intval(sanitize_text_field($this->post_data['shipdepot']['ShipFromStation']['StationID']));
                    }
                }
            } else {
                $ship_from_station->Province = new Ship_Depot_Province();
                $ship_from_station->District = new Ship_Depot_District();
                $ship_from_station->Station = new Ship_Depot_Station();
            }
            return $ship_from_station;
        }

        public function get_cod_failed_info(): Ship_Depot_COD_Failed
        {
            $cod_failed = new Ship_Depot_COD_Failed();
            $selected_courier = $this->get_selected_courier();
            if (is_null($this->post_data) || Ship_Depot_Helper::check_null_or_empty($selected_courier) || !isset($this->post_data['shipdepot']) || !isset($this->post_data['shipdepot'][$selected_courier]) || !isset($this->post_data['shipdepot'][$selected_courier]['courier_info'])) {
                return $cod_failed;
            }
            $json_selected_courier = sanitize_text_field($this->post_data['shipdepot'][$selected_courier]['courier_info']);
            if (!Ship_Depot_Helper::check_null_or_empty($json_selected_courier)) {
                $selected_courier_info = new Ship_Depot_Courier_Response(Ship_Depot_Helper::CleanJsonFromHTMLAndDecode($json_selected_courier));
                $cod_failed = $selected_courier_info->CODFailed;
            }
            return $cod_failed;
        }

        public function get_shipping_notes(): string
        {
            $shipping_notes = '';
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot'])) {
                return $shipping_notes;
            }

            $shipping_notes = Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['shipping_notes'])) ? '' : sanitize_textarea_field($this->post_data['shipdepot']['shipping_notes']);
            return $shipping_notes;
        }

        public function get_is_customer_pay_ship(): bool
        {
            $cus_pay_ship = false;
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot'])) {
                return $cus_pay_ship;
            }

            if (Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['customer_pay_shipping']))) {
                $cus_pay_ship = Ship_Depot_Helper::get_data_from_checkbox(sanitize_text_field($this->post_data['shipdepot']['customer_pay_shipping']));
            }
            return $cus_pay_ship;
        }

        public function get_items(): array
        {
            $list_items = [];
            if (is_null($this->order_id) || $this->order_id <= 0) {
                return $list_items;
            }

            $order = wc_get_order($this->order_id);
            Ship_Depot_Logger::wrlog('[Ship_Depot_Get_Data][get_items] order created date: ' . print_r($order->get_date_created(), true));
            $order_items = $order->get_items();
            $item_regular_price_total = 0;
            foreach ($order_items as $item) {
                $item_data = $item->get_data();
                Ship_Depot_Logger::wrlog('[Ship_Depot_Get_Data][get_items] item_data: ' . print_r($item_data, true));
                $product_id = $item_data['product_id'];
                $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
                $it = new Ship_Depot_Item();
                $it->ID = $item_data['id'];
                if ($product_image != false) {
                    Ship_Depot_Logger::wrlog('[Ship_Depot_Get_Data][get_items] item_image: ' . $product_image[0]);
                    $it->ImageURL = $product_image[0];
                }
                $it->Name = $item_data['name'];
                $it->Quantity = $item_data['quantity'];
                $it->TotalPrice = $item_data['total'];
                $item_product = new WC_Order_Item_Product($item->get_id());
                $product = $item_product->get_product();
                $it->Length = Ship_Depot_Helper::ConvertToShipDepotDimension($product->get_length());
                $it->Width = Ship_Depot_Helper::ConvertToShipDepotDimension($product->get_width());
                $it->Height = Ship_Depot_Helper::ConvertToShipDepotDimension($product->get_height());
                $it->Weight = Ship_Depot_Helper::ConvertToShipDepotWeight($product->get_weight());
                //
                $regular_price = $product->get_regular_price();
                $it->RegularPrice = $regular_price;
                $item_regular_price_total += floatval($regular_price) * $item->get_quantity();
                //
                array_push($list_items, $it);
            }

            return array(
                "list_items" => $list_items,
                "item_regular_price_total" => $item_regular_price_total
            );
        }

        public function get_cod_edit_amount(): int
        {
            $cod_amount = 0;
            if (is_null($this->post_data) || !isset($this->post_data['shipdepot'])) {
                return $cod_amount;
            }

            if (!Ship_Depot_Helper::check_null_or_empty(sanitize_text_field($this->post_data['shipdepot']['cod_edit_amount']))) {
                $cod_amount = intval(str_replace('.', '', sanitize_text_field($this->post_data['shipdepot']['cod_edit_amount'])));
            }
            return $cod_amount;
        }
    }
}

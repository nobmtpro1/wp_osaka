<?php
defined('ABSPATH') || exit;

if (!class_exists('Ship_Depot_Helper')) {
    class Ship_Depot_Helper
    {
        public static function is_admin_user()
        {
            return current_user_can('manage_options');
        }

        public static function alert($msg)
        {
            echo "<script type='text/javascript'>alert('" . esc_js($msg) . "');</script>";
        }

        public static function get_data_from_checkbox($data): bool
        {
            if (isset($data)) {
                if (is_null($data) || empty($data)) return false;
                return '1' === $data || 'yes' === $data || 'on' === $data ? true : false;
            } else {
                return false;
            }
        }

        public static function currency_format($number, $suffix = '₫')
        {
            try {
                if (!empty($number)) {
                    return number_format($number, 0, ',', '.') . "{$suffix}";
                } else {
                    return 0 . "{$suffix}";
                }
            } catch (Exception $e) {
                return $number;
            }
        }

        public static function number_format($number)
        {
            try {
                if (!empty($number)) {
                    return number_format($number, 0, ',', '.');
                }
            } catch (Exception $e) {
                return $number;
            }
        }

        public static function is_woocommerce_activated()
        {
            return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins', array()))) ||
                (is_multisite() && array_key_exists('woocommerce/woocommerce.php', get_site_option('active_sitewide_plugins', array())));
        }

        public static function check_null_or_empty($valueCheck)
        {
            if (!isset($valueCheck)) return true;
            if (is_null(($valueCheck) || empty($valueCheck))) return true;
            if (!$valueCheck) return true;
            return false;
        }

        public static function format_phone($phone)
        {
            if (!self::check_null_or_empty($phone)) {
                $phone_length = strlen($phone);
                $format = '';
                if ($phone_length > 3 && $phone_length <= 6) {
                    $format = substr($phone, 0, 3) . '-' . substr($phone, 3, $phone_length - 3);
                } else if ($phone_length > 6) {
                    $format = substr($phone, 0, 3) . '-' . substr($phone, 3, 3) . '-' . substr($phone, 6, $phone_length - 6);
                }

                return $format;
            }
            return $phone;
        }

        public static function format_utc_to_date_time($str_date_time)
        {
            $dt = new DateTime($str_date_time, new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone(wp_timezone_string()));
            return $dt->format(get_option('date_format') . ' ' . get_option('time_format'));
        }

        public static function format_utc_to_date($str_date_time)
        {
            $dt = new DateTime($str_date_time, new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone(wp_timezone_string()));
            return $dt->format(get_option('date_format'));
        }

        // public static function http_get($url, $header = array())
        // {
        //     Ship_Depot_Logger::wrlog('[http_get] url: ' . $url);
        //     Ship_Depot_Logger::wrlog('[http_get] header: ' . print_r($header, true));
        //     $resultObj = new stdClass();
        //     $curl = curl_init();
        //     // OPTIONS:
        //     curl_setopt($curl, CURLOPT_URL, $url);
        //     $header += array('Content-type: application/json');
        //     curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //     // EXECUTE:
        //     $output = curl_exec($curl);
        //     $info = curl_getinfo($curl);
        //     curl_close($curl);
        //     Ship_Depot_Logger::wrlog('[http_get] output info: ' . print_r($info, true));
        //     Ship_Depot_Logger::wrlog('[http_get] output data: ' . print_r($output, true));
        //     $result = new stdClass();
        //     $http_code = isset($info['http_code']) ? $info['http_code'] : 0;
        //     if (!$output || $http_code != 200) {
        //         Ship_Depot_Logger::wrlog("[http_get] Error");
        //         $result->Code = -1000;
        //         $result->Message = 'HTTP GET error. Error message: Connection Failure.' . $http_code != 0 ? 'HTTP Code = ' . $http_code : '';
        //         $result->Data = '';
        //     } else {
        //         $result = json_decode($output);
        //     }

        //     return $result;
        // }

        public static function http_get($url, $header_input = array())
        {
            Ship_Depot_Logger::wrlog('[http_get] url: ' . $url);
            Ship_Depot_Logger::wrlog('[http_get] header_input: ' . print_r($header_input, true));
            $header = array('Content-Type' => 'application/json');
            foreach ($header_input as $key => $value) {
                $header = array($key => $value);
            }
            Ship_Depot_Logger::wrlog('[http_get] headers: ' . print_r($header, true));
            $response = wp_remote_get(
                esc_url($url),
                array(
                    'timeout'     => 45,
                    'headers' => $header
                )
            );
            $http_code = wp_remote_retrieve_response_code($response);
            $output = wp_remote_retrieve_body($response);
            $result = new stdClass();
            Ship_Depot_Logger::wrlog('[http_get] http_code: ' . print_r($http_code, true));
            Ship_Depot_Logger::wrlog('[http_get] output: ' . print_r($output, true));
            if (is_wp_error($response)) {
                Ship_Depot_Logger::wrlog("[http_get] Reponse WP Error.");
                $result->Code = -1000;
                $result->Msg = $response->get_error_message();
                $result->Data = '';
            } else if (!$output || $http_code != 200) {
                Ship_Depot_Logger::wrlog("[http_get] HTTP Error or Output error.");
                $result->Code = -1001;
                $result->Message = 'HTTP GET error. Error message: Connection Failure.' . $http_code != 0 ? 'HTTP Code = ' . $http_code : '';
                $result->Data = '';
            } else {
                $result = json_decode($output);
            }
            Ship_Depot_Logger::wrlog('[http_get] result: ' . print_r($result, true));
            return $result;
        }
        /**
         * Calculate shipping fee
         * @param string $url URL request.
         * @param array $body_input Body of request.
         * @param array $header_input Header of request.
         */
        public static function http_post($url, $body_input = array(), $header_input = array())
        {
            Ship_Depot_Logger::wrlog('[http_post] url: ' . $url);
            Ship_Depot_Logger::wrlog('[http_post] body_input: ' . print_r($body_input, true));
            Ship_Depot_Logger::wrlog('[http_post] json_body_input: ' . print_r(json_encode($body_input), true));
            Ship_Depot_Logger::wrlog('[http_post] header_input: ' . print_r($header_input, true));
            $header = array('Content-Type' => 'application/json');
            foreach ($header_input as $key => $value) {
                $header = array($key => $value);
            }

            Ship_Depot_Logger::wrlog('[http_post] headers: ' . print_r($header, true));
            $response = wp_remote_post(
                esc_url($url),
                array(
                    'timeout'     => 45,
                    'headers' => $header,
                    'body' => $body_input
                )
            );
            $http_code = wp_remote_retrieve_response_code($response);
            $output = wp_remote_retrieve_body($response);
            $result = new stdClass();
            Ship_Depot_Logger::wrlog('[http_get] http_code: ' . print_r($http_code, true));
            Ship_Depot_Logger::wrlog('[http_get] output: ' . print_r($output, true));
            if (is_wp_error($response)) {
                Ship_Depot_Logger::wrlog("[http_post] Reponse WP Error.");
                $result->Code = -1000;
                $result->Msg = $response->get_error_message();
                $result->Data = '';
            } else if (!$output || $http_code != 200) {
                Ship_Depot_Logger::wrlog("[http_post] HTTP Error or Output error.");
                $result->Code = -1001;
                $msg = 'HTTP POST error. Error message: Connection Failure.';
                if ($http_code != 0) {
                    $msg = $msg . ' HTTP Code = ' . $http_code;
                }
                $result->Msg = $msg;
                $result->Data = '';
            } else {
                $result = json_decode($output);
            }
            return $result;
        }

        // public static function http_post($url, $json_post, $header = array())
        // {
        //     Ship_Depot_Logger::wrlog('[http_post] url: ' . $url);
        //     Ship_Depot_Logger::wrlog('[http_post] json_post: ' . $json_post);
        //     Ship_Depot_Logger::wrlog('[http_post] header: ' . print_r($header, true));
        //     $curl = curl_init();
        //     curl_setopt($curl, CURLOPT_URL, $url);
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
        //     curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        //     curl_setopt($curl, CURLOPT_TIMEOUT, 30); //timeout in seconds
        //     $header = array_merge(array('Content-type: application/json; charset=utf-8'), $header);
        //     curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //     curl_setopt($curl, CURLOPT_POST, 1);
        //     curl_setopt($curl, CURLOPT_POSTFIELDS, $json_post);
        //     $output = curl_exec($curl);
        //     $info = curl_getinfo($curl);
        //     curl_close($curl);
        //     //
        //     Ship_Depot_Logger::wrlog('[http_post] output info: ' . print_r($info, true));
        //     Ship_Depot_Logger::wrlog('[http_post] output data: ' . print_r($output, true));
        //     $result = new stdClass();
        //     $http_code = isset($info['http_code']) ? $info['http_code'] : 0;
        //     if (!$output || $http_code != 200) {
        //         Ship_Depot_Logger::wrlog("[http_post] Error.");
        //         $result->Code = -1000;
        //         $msg = 'HTTP POST error. Error message: Connection Failure.';
        //         if ($http_code != 0) {
        //             $msg = $msg . ' HTTP Code = ' . $http_code;
        //         }
        //         $result->Msg = $msg;
        //         $result->Data = '';
        //     } else {
        //         $result = json_decode($output);
        //     }
        //     return $result;
        // }

        public static function ConvertToShipDepotWeight($weight, $unit = '')
        {
            if (!$weight || is_null($weight)) {
                return 0;
            }

            if (self::check_null_or_empty($unit)) {
                $unit = get_option('woocommerce_weight_unit');
            }

            $weight = floatval($weight);
            $sd_weight_unit = strtolower(SHIP_DEPOT_WEIGHT_UNIT);
            $woo_weight_unit = strtolower($unit);
            if ($sd_weight_unit == 'g' || $sd_weight_unit == 'gram') {
                if ($woo_weight_unit == 'g' || $woo_weight_unit == 'gram') {
                    return $weight;
                } else if ($woo_weight_unit == 'kg') {
                    return $weight * 1000;
                } else if ($woo_weight_unit == 'lbs') {
                    return $weight * 453.6;
                } else if ($woo_weight_unit == 'oz') {
                    return $weight * 28.35;
                }
            } else if ($sd_weight_unit == 'kg' || $sd_weight_unit == 'kilogram') {
                if ($woo_weight_unit == 'g' || $woo_weight_unit == 'gram') {
                    return $weight / 1000;
                } else if ($woo_weight_unit == 'kg') {
                    return $weight;
                } else if ($woo_weight_unit == 'lbs') {
                    return $weight * 453.6 / 1000;
                } else if ($woo_weight_unit == 'oz') {
                    return $weight * 28.35 / 1000;
                }
            } else if ($sd_weight_unit == 'lbs') {
                if ($woo_weight_unit == 'g' || $woo_weight_unit == 'gram') {
                    return $weight * 0.002205;
                } else if ($woo_weight_unit == 'kg') {
                    return $weight * 2.205;
                } else if ($woo_weight_unit == 'lbs') {
                    return $weight;
                } else if ($woo_weight_unit == 'oz') {
                    return $weight * 0.0625;
                }
            }
        }

        public static function ConvertToShipDepotDimension($dimension, $unit = '')
        {
            if (!$dimension || is_null($dimension)) {
                return 0;
            }

            if (self::check_null_or_empty($unit)) {
                $unit = get_option('woocommerce_dimension_unit');
            }
            $dimension = floatval($dimension);
            $sd_dimen_unit = strtolower(SHIP_DEPOT_MEASUREMENT_UNIT);
            $woo_dimen_unit = strtolower($unit);
            if ($sd_dimen_unit == 'cm') {
                if ($woo_dimen_unit == 'm') {
                    return $dimension * 100;
                } else if ($woo_dimen_unit == 'cm') {
                    return $dimension;
                } else if ($woo_dimen_unit == 'mm') {
                    return $dimension * 0.1;
                } else if ($woo_dimen_unit == 'in') {
                    return $dimension * 2.54;
                } else if ($woo_dimen_unit == 'yd') {
                    return $dimension * 91.44;
                }
            } else if ($sd_dimen_unit == 'in' || $sd_dimen_unit == 'inch') {
                if ($woo_dimen_unit == 'm') {
                    return $dimension * 39.37;
                } else if ($woo_dimen_unit == 'cm') {
                    return $dimension * 0.3937;
                } else if ($woo_dimen_unit == 'mm') {
                    return $dimension * 0.03937;
                } else if ($woo_dimen_unit == 'in') {
                    return $dimension;
                } else if ($woo_dimen_unit == 'yd') {
                    return $dimension * 36;
                }
            }
        }

        public static function ParseObjectToJsonHTML($object)
        {
            $json_html = json_encode($object, JSON_UNESCAPED_UNICODE);
            $json_html = str_replace('"', "'", $json_html);
            return $json_html;
        }

        public static function CleanJsonFromHTML($json)
        {
            if (Ship_Depot_Helper::check_null_or_empty($json)) {
                return $json;
            }

            $json = stripslashes($json);
            $json = str_replace("'", '"', $json);
            Ship_Depot_Logger::wrlog('[CleanJsonFromHTML] $json aft: ' . $json);
            return $json;
        }

        public static function CleanJsonFromHTMLAndDecode($json)
        {
            if (Ship_Depot_Helper::check_null_or_empty($json)) {
                return null;
            }
            $json = Ship_Depot_Helper::CleanJsonFromHTML($json);
            return json_decode($json);
        }

        public static function ParseObjectToArray($obj): array
        {
            if (is_object($obj)) {
                return json_decode(json_encode($obj), true);
            }
            return [];
        }

        public static function CompareData($old_data, $new_data)
        {
            Ship_Depot_Logger::wrlog('[CompareData] old_data: ' . print_r($old_data, true));
            Ship_Depot_Logger::wrlog('[CompareData] new_data: ' . print_r($new_data, true));
            if (!$old_data || Ship_Depot_Helper::check_null_or_empty($old_data)) {
                if (!Ship_Depot_Helper::check_null_or_empty($new_data)) {
                    Ship_Depot_Logger::wrlog('[diff_data] diff = true');
                    return true;
                }
            } else {
                if ($old_data != $new_data) {
                    Ship_Depot_Logger::wrlog('[CompareData] diff = true');
                    return true;
                }
            }
            Ship_Depot_Logger::wrlog('[CompareData] diff = false');
            return false;
        }
    }
}

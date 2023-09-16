<?php
class Ship_Depot_Address_Helper
{
  public static function get_all_province()
  {
    $json_provinces = file_get_contents(SHIP_DEPOT_DIR_PATH . "src/all_VN_province.json");
    if (!Ship_Depot_Helper::check_null_or_empty($json_provinces)) {
      $all_pros = json_decode($json_provinces);
      return $all_pros;
    }
    return false;
  }

  public static function get_all_province_key_value()
  {
    $list_provinces = self::get_all_province();
    return (new self)->sanitize_address_to_array($list_provinces);
  }

  public static function get_province_by_id($province_code)
  {
    $all_province = self::get_all_province();
    if (!$all_province) return false;
    foreach ($all_province as $province) {
      if ($province->Code == $province_code) {
        return $province;
      }
    }
    return false;
  }

  public static function get_province_by_isn($province_isn)
  {
    $all_province = self::get_all_province();
    if (!$all_province) return false;
    foreach ($all_province as $province) {
      if ($province->LocationISN == $province_isn) {
        return $province;
      }
    }
    return false;
  }

  public static function get_all_district($province_code)
  {
    $province = self::get_province_by_id($province_code);
    if (is_null($province) || !$province) return false;
    //Ship_Depot_Logger::wrlog('[get_all_district] districts: ' . print_r($province->ListDistricts, true));
    return $province->ListDistricts;
  }

  public static function get_all_district_by_province_isn($province_isn)
  {
    $province = self::get_province_by_isn($province_isn);
    if (is_null($province) || !$province) return false;
    //Ship_Depot_Logger::wrlog('[get_all_district] districts: ' . print_r($province->ListDistricts, true));
    return $province->ListDistricts;
  }

  public static function get_all_district_key_value($province_code)
  {
    $list_districts = self::get_all_district($province_code);
    return (new self)->sanitize_address_to_array($list_districts);
  }

  public static function get_district_by_id($province_code, $district_code)
  {
    //Ship_Depot_Logger::wrlog('[get_district_by_id] province_code: ' . print_r($province_code, true));
    //Ship_Depot_Logger::wrlog('[get_district_by_id] district_code: ' . print_r($district_code, true));
    $all_district = self::get_all_district($province_code);
    if (is_null($all_district) || !$all_district) return false;
    foreach ($all_district as $district) {
      if ($district->Code == $district_code) {
        return $district;
      }
    }
    return false;
  }

  public static function get_all_wards($province_code, $district_code)
  {
    //Ship_Depot_Logger::wrlog('[get_all_wards] province_code: ' . print_r($province_code, true));
    //Ship_Depot_Logger::wrlog('[get_all_wards] district_code: ' . print_r($district_code, true));
    $district = self::get_district_by_id($province_code, $district_code);
    if (is_null($district) || !$district) return false;
    //Ship_Depot_Logger::wrlog('[get_all_wards] wards: ' . print_r($district->ListWards, true));
    return $district->ListWards;
  }

  public static function get_all_wards_key_value($province_code, $district_code)
  {
    //Ship_Depot_Logger::wrlog('[get_all_wards_key_value] province_code: ' . print_r($province_code, true));
    //Ship_Depot_Logger::wrlog('[get_all_wards_key_value] district_code: ' . print_r($district_code, true));
    $list_wards = self::get_all_wards($province_code, $district_code);
    return (new self)->sanitize_address_to_array($list_wards);
  }

  public static function get_ward_by_id($province_code, $district_code, $ward_code)
  {
    $all_ward = self::get_all_wards($province_code, $district_code);
    if (is_null($all_ward) || !$all_ward) return false;
    foreach ($all_ward as $ward) {
      if ($ward->Code == $ward_code) {
        return $ward;
      }
    }
    return false;
  }


  function sanitize_address_to_array($list_object)
  {
    $list_return = [];
    if (is_null($list_object) || !$list_object) return $list_return;
    foreach ($list_object as $obj) {
      $list_return[$obj->Code] = $obj->Name;
    }
    //Ship_Depot_Logger::wrlog('[sanitize_address_to_array] list_return: ' . print_r($list_return, true));
    return $list_return;
  }

  public static function can_shipping_vietnam()
  {
    $countries = WC()->countries->get_shipping_countries();
    return Ship_Depot_Helper::is_woocommerce_activated() && isset($countries['VN']);
  }

  public static function get_city_option()
  {
    echo '<option value="">' . esc_html(SD_SELECT_CITY_TEXT) . '</option>';
    $provinces = self::get_all_province_key_value();
    ksort($provinces);
    foreach ($provinces as $key => $value) {
      echo '<option value="' . esc_attr($key) . '">' . esc_html($value) . '</option>';
    }
  }

  public static function get_districts_option_by_province_code($province_code)
  {
    $province_code = sanitize_text_field($province_code);
    echo '<option value="">' . esc_html(SD_SELECT_DISTRICT_TEXT) . '</option>';
    if (isset($province_code) && $province_code) {
      $districts = self::get_all_district_key_value($province_code);
      ksort($districts);
      foreach ($districts as $key => $value) {
        echo '<option value="' . esc_attr($key) . '">' . esc_html($value) . '</option>';
      }
    }
  }

  public static function get_wards_option_by_district_code($province_code, $district_code)
  {
    $province_code = sanitize_text_field($province_code);
    $district_code = sanitize_text_field($district_code);
    //Ship_Depot_Logger::wrlog('[get_wards_option_by_district_code] province_code: ' . $province_code);
    //Ship_Depot_Logger::wrlog('[get_wards_option_by_district_code] district_code: ' . $district_code);
    echo '<option value="">' . esc_html(SD_SELECT_WARD_TEXT) . '</option>';
    if (isset($province_code) && $province_code && isset($district_code) && $district_code) {
      $wards = self::get_all_wards_key_value($province_code, $district_code);
      ksort($wards);
      foreach ($wards as $key => $value) {
        echo '<option value="' . esc_attr($key) . '">' . esc_html($value) . '</option>';
      }
    }
  }
}

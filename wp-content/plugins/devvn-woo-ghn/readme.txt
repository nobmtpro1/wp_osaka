== Changelog ==

= V2.0.6 - 03.03.2021 =

* Update dữ liệu tỉnh thành mới nhất 03.03.2021 từ GHN

= V2.0.5 - 06.01.2021 =

* Fix: Không load được quận huyện khi thêm đơn hàng trong admin

= V2.0.4 - 25.10.2020 =
* Update: Sắp xếp lại tên tỉnh thành, xã phường từ a-z
* Add: Thêm filter có thể đổi tên cho các gọi dịch vụ
    Ví dụ:
    add_filter('ghn_service_name', 'devvn_ghn_service_name', 10, 2);
    function devvn_ghn_service_name($service_name, $service_id){
        switch ($service_name){
            case 'Bay':
                $service_name = 'Giao hàng nhanh';
                break;
            case 'Đi bộ':
                $service_name = 'Giao hàng chuẩn';
                break;
        }
        return $service_name;
    }

= V2.0.3 - 03.10.2020 =

* Thêm filter ghn_custom_field để chỉnh sửa các field bằng hook
* Fix Tính phí vận chuyển tại trang checkout theo phí ký với GHN

= V2.0.2 - 07.09.2020 =

* Fix lỗi update tự động qua license

* Thêm hook loại bỏ gói dịch vụ nào đó

    add_filter('ghn_exclude_service', 'devvn_ghn_exclude_service');
    function devvn_ghn_exclude_service($services){
        //Loại bỏ gói dịch vụ khỏi kết quả
        // các giá trị gói là 1: Nhanh, 2: Chuẩn, 3: Tiết kiệm

        //Ví dụ muốn bỏ dịch vụ Nhanh thì thêm như sau
        $services = array(1);
        return $services;
    }

= V2.0.1 - 07.09.2020 =

* Fix lỗi không load phường xã khi lần đầu vào checkout
* Đổi trường họ và tên từ last_name sang first_name để tương thích với 1 số plugin khác
* Thêm phần chú ý cài đặt để việc cài đặt được chính xác hơn

= 2.0.0 - 06.09.2020 =

* Nâng cấp API GHN lên V2
* Phí vận chuyển sẽ ko tính phí khai giá khi khách chuyển khoản
* Fix lại cách tính ship theo kích thước sản phẩm

= 1.1.0 - 20.08.2020 =

* Fix: Sửa lỗi js với WordPress 5.5

= 1.0.9 - 10.04.2020 =

* Thêm URL tracking. Tương thích để gửi URL tracking qua tin nhắn với SMS Master

= 1.0.8 - 30.11.2019 =

* Update: Thay lại link lấy Token key

= 1.0.7 - 23.08.2019 =

* Update: Cập nhật cách tính phí ship dựa theo Kích thước (dài x rộng x cao)

= 1.0.6 - 14.08.2019 =

* Fix: Sửa lỗi với phiên bản Woocommerce 3.7.0

= 1.0.5 - 26.09.2018 =

* Fix: Thêm 1 số tỉnh thành, quận và xã phường còn thiếu
* Update: Bỏ tự động điền trường "Mã đơn hệ thống" khi đăng vận đơn

= 1.0.4 - 02.07.2018 =

* Fix: Mã liên kết sai định dạng => đã convert sang dạng int
* Fix: Sửa lỗi chọn các dịch vụ khi cập nhật đơn hàng

= 1.0.3 - 27.06.2018 =

* Add: Tạo vận đơn ngay trên trang danh sách đơn hàng. Không cần vào trong chi tiết đơn hàng nữa.
* Add: Tính toán và hiển thị tổng giá trị vận đơn trước khi đăng đơn.

= 1.0.2 - 14.06.2018 =

* ADD: Thêm Webhook - Tự động cập nhật trạng thái đơn hàng
* Cho phép tự sửa cân nặng, kích thước gói hàng trước lúc đăng đơn mới

= 1.0.0 - 21.04.2018 =

* Ra mắt plugin
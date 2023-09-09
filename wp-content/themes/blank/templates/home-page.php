<?php
/*
 Template Name: Home page
 */

$fields = get_fields();
// dd($fields)
?>
<?php get_header() ?>
<div class="page-home">
    <section class="banner g-container">
        <div class="swiper bannerSlider">
            <div class="swiper-wrapper">
                <?php foreach (@$fields["banner"] as $banner) : ?>
                    <div class="swiper-slide" data-swiper-autoplay="2000">
                        <a href="<?= @$banner["link"] ?>"><img src="<?= @$banner["image"] ?>" alt=""></a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <section class="grid-images">
        <div class="g-container">
            <div class="grid-1">
                <a class="grid-item" href="">
                    <div class="image">
                        <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/icon1.webp" alt="icon1" />
                    </div>
                    <div class="text">
                        <div class="title">
                            THANH TOÁN KHI NHẬN HÀNG
                        </div>
                        <div class="description">Bạn có thể thanh toán khi nhận hàng, không thích có thể trả lại.
                        </div>
                    </div>
                </a>
                <a class="grid-item" href="">
                    <div class="image">
                        <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/icon2.webp" alt="icon1" />
                    </div>
                    <div class="text">
                        <div class="title">
                            THẮC MẮC KHÁCH HÀNG
                        </div>
                        <div class="description">Mọi thắc mắc của bạn hãy gửi ngay cho chúng tôi theo địa chỉ bên dưới nhé.
                        </div>
                    </div>
                </a>
                <a class="grid-item" href="">
                    <div class="image">
                        <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/icon3.webp" alt="icon1" />
                    </div>
                    <div class="text">
                        <div class="title">
                            Giờ mở cửa
                        </div>
                        <div class="description">Từ 07:00 đến 21:00 từ thứ 2 - 7
                            Chủ nhật từ 07:00 đến 19:00
                        </div>
                    </div>
                </a>
            </div>
            <div class="grid-2">
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image1.webp" alt="image">
                </a>
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image1.webp" alt="image">
                </a>
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image1.webp" alt="image">
                </a>
            </div>
            <div class="grid-3">
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image2.webp" alt="image">
                </a>
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image2.webp" alt="image">
                </a>
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image2.webp" alt="image">
                </a>
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image2.webp" alt="image">
                </a>
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image2.webp" alt="image">
                </a>
                <a href="" class="grid-item">
                    <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image2.webp" alt="image">
                </a>
            </div>
        </div>
    </section>

    <section class="new-products g-container">
        <h2 class="title"><span class="line"></span> <span class="text"><i class="fa-solid fa-xmark"></i>SẢN PHẨM MỚI <i class="fa-solid fa-xmark"></i></span> <span class="line"></span></h2>
        <p class="description">MUA SẮM NGAY ĐI, HÀNG MỚI NHẬP KHẨU, MẪU MÃ ĐẸP, GIÁ SALE</p>
        <div class="tabs">
            <ul class="tab-titles">
                <li class="active">SẢN PHẨM MỚI</li>
                <li>SẢN PHẨM BÁN CHẠY</li>
                <li>TRỢ GIÁ</li>
            </ul>
            <ul class="tab-contents">
                <li class="active"> <?= do_shortcode('[products columns="4" orderby="id" order="DESC" visibility="visible" limit ="8"]') ?></li>
                <li><?= do_shortcode('[products columns="4" visibility="visible" limit ="8" best_selling="true"]') ?></li>
                <li><?= do_shortcode('[products columns="4" visibility="visible" limit ="8" on_sale="true" ]') ?></li>
            </ul>
        </div>
        <div class="button">
            <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="g-button">XEM TẤT CẢ</a>
        </div>
    </section>

    <section class="banner-image">
        <a href="">
            <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image3.webp" alt="banner">
        </a>
    </section>

    <section class="product-category g-container">
        <div class="left">
            <h2 class="title">NỒI CƠM - ÁP SUẤT</h2>
            <ul class="tabs">
                <li class="active">Nồi cơm điện 2D</li>
                <li>Nồi cơm điện 3D</li>
                <li>Nồi cơm Mê Kông</li>
            </ul>
            <div class="navigation">
                <div class="nav-left">
                    <div class="button">
                        <i class="fa-solid fa-chevron-left"></i>
                    </div>
                </div>
                <div class="nav-right">
                    <div class="button">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <ul class="tab-contents">
                <li class="active">
                    <?php
                    $products = get_products_by_category(16, 12);
                    // dd(get_products_by_category(17, 12))
                    ?>
                    <div class="woocommerce">
                        <ul class="products w-loop-1-row">
                            <?php
                            while ($products->have_posts()) {
                                $products->the_post();

                                /**
                                 * Hook: woocommerce_shop_loop.
                                 */
                                do_action('woocommerce_shop_loop');

                                wc_get_template_part('content', 'product');
                            }
                            ?>
                        </ul>
                    </div>
                </li>
                <li>
                    <?php
                    $products = get_products_by_category(17, 12);
                    // dd(get_products_by_category(17, 12))
                    ?>
                    <div class="woocommerce">
                        <ul class="products w-loop-1-row">
                            <?php
                            while ($products->have_posts()) {
                                $products->the_post();

                                /**
                                 * Hook: woocommerce_shop_loop.
                                 */
                                do_action('woocommerce_shop_loop');

                                wc_get_template_part('content', 'product');
                            }
                            ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</div>

<?php get_footer() ?>
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

    <section class="new-products g-container">
        <h2 class="title">SẢN PHẨM MỚI</h2>
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
    </section>
</div>

<?php get_footer() ?>
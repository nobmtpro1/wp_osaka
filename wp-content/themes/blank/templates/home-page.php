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
                <?php foreach (@$fields["banner"] ?? [] as $banner) : ?>
                    <div class="swiper-slide" data-swiper-autoplay="2000">
                        <a href="<?= @$banner["link"] ?>"><img src="<?= @$banner["image"]['url'] ?>" alt=""></a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <section class="grid-images">
        <div class="g-container">
            <div class="grid-1">
                <?php foreach (@$fields['row_1'] ?? [] as $item) : ?>
                    <a class="grid-item" href="<?= @$item['link']["url"] ?>" target="<?= @$item['link']["target"] ?>">
                        <div class="image">
                            <img src="<?= @$item['image']['url'] ?>" alt="icon1" />
                        </div>
                        <div class="text">
                            <div class="title">
                                <?= @$item['title'] ?>
                            </div>
                            <div class="description"><?= @$item['content'] ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
            <div class="grid-2">
                <?php foreach (@$fields['row_2'] ?? [] as $item) : ?>
                    <a href="<?= @$item['link']["url"] ?>" target="<?= @$item['link']["target"] ?>" class="grid-item">
                        <img src="<?= @$item['image']['url'] ?>" alt="image">
                    </a>
                <?php endforeach ?>
            </div>
            <div class="grid-3">
                <?php foreach (@$fields['row_3'] ?? [] as $item) : ?>
                    <a href="<?= @$item['link']["url"] ?>" target="<?= @$item['link']["target"] ?>" class="grid-item">
                        <img src="<?= @$item['image']['url'] ?>" alt="image">
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <section class="new-products g-container">
        <h2 class="g-title"><span class="line"></span> <span class="text"><i class="fa-solid fa-xmark"></i>SẢN PHẨM MỚI <i class="fa-solid fa-xmark"></i></span> <span class="line"></span></h2>
        <p class="g-description">MUA SẮM NGAY ĐI, HÀNG MỚI NHẬP KHẨU, MẪU MÃ ĐẸP, GIÁ SALE</p>
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
        <a href="<?= @$fields['link']["url"] ?>" target="<?= @$fields['link']["target"] ?>">
            <img src="<?= @$fields['image']["url"] ?>" alt="banner">
        </a>
    </section>

    <?php $all_categories =  @get_all_categories() ?? [] ?>
    <?php foreach ($all_categories as $category) : ?>
        <?php
        if ($category->parent !== 0) {
            continue;
        }
        $count_sub_category = 0;
        foreach ($all_categories as $sub_category) {
            if ($sub_category->parent == $category->term_id) {
                $count_sub_category++;
            }
        }
        if ($count_sub_category == 0) {
            continue;
        }
        ?>
        <section class="product-category">
            <div class="g-container">
                <div class="left">
                    <h2 class="title"><?= $category->name ?></h2>
                    <ul class="tabs">
                        <?php $i = 0; ?>
                        <?php foreach ($all_categories as $sub_category) : ?>
                            <?php
                            if ($sub_category->parent !== $category->term_id) {
                                continue;
                            }
                            $i++;
                            ?>
                            <li class="<?= $i == 1 ? "active" : "" ?>"><?= $sub_category->name ?></li>
                        <?php endforeach ?>
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
                        <?php $i = 0; ?>
                        <?php foreach ($all_categories as $sub_category) : ?>
                            <?php
                            if ($sub_category->parent !== $category->term_id) {
                                continue;
                            }
                            $i++;
                            ?>
                            <li class="<?= $i == 1 ? "active" : "" ?>">
                                <?php
                                $products = get_products_by_category($sub_category->term_id, 12);
                                ?>
                                <div class="woocommerce">
                                    <ul class="products w-loop-1-row">
                                        <?php
                                        while ($products->have_posts()) {
                                            $products->the_post();
                                            do_action('woocommerce_shop_loop');
                                            wc_get_template_part('content', 'product');
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php endforeach ?>

    <section class="blogs">
        <div class="g-container">
            <h2 class="g-title">
                <span class="line"></span> <span class="text"><i class="fa-solid fa-xmark"></i>TIN TỨC NỔI BẬT <i class="fa-solid fa-xmark"></i></span> <span class="line"></span>
            </h2>
            <p class="g-description">Cẩm nang mua sắm, góc chia sẻ</p>
            <div class="swiper blogs-slider">
                <div class="swiper-wrapper">


                    <?php
                    $query = new WP_Query([
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'post_count' => 12,
                        'order' => 'DESC',
                        'orderby' => 'ID',
                    ]);
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                    ?>
                            <div class="swiper-slide">
                                <div class="blog">
                                    <div class="image">
                                        <?= get_the_post_thumbnail() ?>
                                        <div class="date">
                                            <div class="day"><?= date("d", strtotime($post->post_date)); ?></div>
                                            <div class="year"><?= date("m/Y", strtotime($post->post_date)); ?></div>
                                        </div>
                                    </div>
                                    <h3 class="title"><?= the_title() ?></h3>
                                    <p class="description"><?= get_the_excerpt() ?></p>
                                    <a href="<?= get_the_permalink() ?>" class="g-button">Xem thêm</a>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
        <div class="button">
            <a href="<?= URL_BLOGS ?>" class="g-button">XEM TẤT CẢ</a>
        </div>
    </section>
</div>

<?php get_footer() ?>
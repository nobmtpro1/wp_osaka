<?php
/*
 Template Name: Blogs page
 */

$fields = get_fields();
// dd($fields)
?>
<?php get_header() ?>
<?php woocommerce_breadcrumb() ?>
<div class="page-blogs">
    <div class="g-container wrap">
        <div class="blogs">
            <?php foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $blog) : ?>
                <div class="blog">
                    <div class="image">
                        <img src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image4.webp" alt="blog">
                        <div class="date">
                            <div class="day">02</div>
                            <div class="year">10/2018</div>
                        </div>
                    </div>
                    <h3 class="title">Ấm áp cơm gia đình</h3>
                    <p class="description">"CƠM ĐÂU SAO BẰNG CƠM NHÀ - BÁT CƠM ẤM ÁP MÓN QUÀ TÌNH THÂN" hãy để Osaka sẻ...</p>
                    <a href="" class="g-button">Xem thêm</a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<?php get_footer() ?>
<?php get_header() ?>
<?php woocommerce_breadcrumb() ?>
<?php
$is_woocommerce_page = is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page();
?>
<div class="g-container <?= $is_woocommerce_page ? "" : "g-content" ?>" style="min-height: 50vh;padding-top:50px;padding-bottom:50px;">
    <?php the_content() ?>
</div>
<?php get_footer() ?>
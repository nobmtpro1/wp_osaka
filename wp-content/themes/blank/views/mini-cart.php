<a class="cart-contents-count" href="<?= WC()->cart->get_cart_url() ?>">
    <div class="image">
        <i class="fa-solid fa-cart-shopping"></i>
    </div>
    <div class="text">
        Giỏ hàng
    </div>
    <div class="cart-count">
        <?= WC()->cart->get_cart_contents_count() ?>
    </div>
    <!-- <div>
        <?= WC()->cart->cart_contents_total ?>
    </div> -->
</a>
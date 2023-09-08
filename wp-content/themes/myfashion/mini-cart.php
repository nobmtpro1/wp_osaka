<div class="cart-contents-count">
    <a href="<?= WC()->cart->get_cart_url() ?>"><img src="<?= bloginfo('template_directory') ?>/html/img/icon/cart.png" alt=""> <span><?= WC()->cart->get_cart_contents_count() ?></span></a>
    <div class="price">$<?= WC()->cart->cart_contents_total ?></div>
</div>
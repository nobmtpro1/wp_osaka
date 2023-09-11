<?php global $product; ?>

<?php if ($product->is_type('simple')) : ?>
    <button type="submit" name="add-to-cart" value="<?= $product->id ?>" class="w-buynow w-single-add-to-cart single_add_to_cart_button button alt">Mua ngay</button>
<?php elseif ($product->is_type('variable')) : ?>
    <button type="submit" class="w-buynow w-single-add-to-cart single_add_to_cart_button button alt wc-variation-selection-needed">Mua ngay</button>
<?php endif ?>
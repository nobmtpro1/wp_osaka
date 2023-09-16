<?php

/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
	return;
}

global $product;

$columns           = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
		'woocommerce-product-gallery--columns-' . absint($columns),
		'images',
	)
);

global $product;
$attachment_ids = $product->get_gallery_image_ids();
$feature_image = wp_get_attachment_image(get_post_thumbnail_id($product->id));
$random_string = generateRandomString(5)


?>
<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>" >

	<div class="w-product-modal-content-left" data-productid="<?= $random_string ?>">
		<div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper w-product-gallery-2-<?= $random_string ?> w-product-gallery-2">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<?= $feature_image ?>
				</div>
				<?php foreach ($attachment_ids as $image_id) : ?>
					<div class="swiper-slide">
						<?= wp_get_attachment_image($image_id); ?>
					</div>
				<?php endforeach ?>
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
		<div thumbsSlider="" class="w-product-gallery swiper w-product-gallery-<?= $random_string ?>">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<?= $feature_image ?>
				</div>
				<?php foreach ($attachment_ids as $image_id) : ?>
					<div class="swiper-slide">
						<?= wp_get_attachment_image($image_id); ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>

</div>
<?php

/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $product;
$attachment_ids = $product->get_gallery_image_ids();
$feature_image = wp_get_attachment_image(get_post_thumbnail_id($product->id));
$random_string = generateRandomString(5)
?>
<div class="w-loop-buttons">
	<a href="" class="w-loop-preview-button"><i class="fa-solid fa-magnifying-glass-plus"></i></a>
	<a href="<?= get_permalink() ?>" class="w-loop-redirect-button"><i class="fa-solid fa-eye"></i></a>
	<?php

	echo apply_filters(
		'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
		sprintf(
			'<a href="%s" data-quantity="%s" class="w-loop-add-to-cart %s" %s>%s</a>',
			esc_url($product->add_to_cart_url()),
			esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
			esc_attr(isset($args['class']) ? $args['class'] : 'button'),
			isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
			'<i class="fa-solid fa-cart-plus"></i>'
		),
		$product,
		$args
	);
	?>
</div>

<div class="component-modal w-loop-preview-modal" data-productid="<?= $random_string ?>">
	<div class="content w-loop-preview-content">
		<div class="close"><i class="fa-solid fa-xmark"></i></div>
		<div class="w-product-modal-content-left">
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
		<div class="w-product-modal-content-right w-product-summary summary entry-summary">
			<?php do_action('woocommerce_single_product_summary'); ?>
		</div>
	</div>
</div>
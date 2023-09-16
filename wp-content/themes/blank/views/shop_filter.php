<div class="g-shop-filter">
    <button class="g-button"><i class="fa-solid fa-filter"></i> Lọc sản phẩm</button>
    <div class="tags">
        <div>

        </div>
    </div>
</div>

<div class="component-modal g-shop-filter-modal">
    <div class="content w-loop-preview-content">
        <div class="close"><i class="fa-solid fa-xmark"></i></div>
        <form action="">
            <input type="hidden" name="paged" value="1">
            <?php foreach ($_GET as $key => $value) : ?>
                <?php if ($key != "price_range" && $key != "paged" && $key != "product_cat") : ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>">
                <?php endif ?>
            <?php endforeach ?>

            <select name="product_cat" id="">
                <option value="">Chọn danh mục sản phẩm</option>
                <?php
                $categories = get_all_categories();
                $current_category = get_queried_object();
                ?>
                <?php foreach ($categories as $category) : ?>
                    <option <?= $current_category->slug == $category->slug ? "selected" : "" ?> value="<?= $category->slug ?>"><?= $category->name ?></option>
                <?php endforeach ?>
            </select>
            <select name="price_range" id="">
                <option value="">Chọn mức giá</option>
                <option <?= $_GET["price_range"] == "0-100000" ? "selected" : "" ?> value="0-100000">Dưới 100,000₫</option>
                <option <?= $_GET["price_range"] == "100000-300000" ? "selected" : "" ?> value="100000-300000">100,000₫ - 300,000₫</option>
                <option <?= $_GET["price_range"] == "300000-500000" ? "selected" : "" ?> value="300000-500000">300,000₫ - 500,000₫</option>
                <option <?= $_GET["price_range"] == "500000-1000000" ? "selected" : "" ?> value="500000-1000000">500,000₫ - 1,000,000₫</option>
                <option <?= $_GET["price_range"] == "1000000-999999999" ? "selected" : "" ?> value="1000000-999999999">Trên 1,000,000₫</option>
            </select>
            <button class="g-button"><i class="fa-solid fa-filter"></i> Lọc</button>
        </form>
    </div>
</div>
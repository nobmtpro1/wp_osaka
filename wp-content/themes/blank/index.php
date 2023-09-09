<?php get_header() ?>
<div class="">
    <div class="g-container">
        <h1>Sản phẩm mới nhất</h1>
        <?= do_shortcode('[products columns="4" orderby="id" order="DESC" visibility="visible" paginate="true" per_page="12"]') ?>
    </div>
</div>
<?php get_footer() ?>
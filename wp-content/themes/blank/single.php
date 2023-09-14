<?php get_header() ?>
<?php woocommerce_breadcrumb() ?>
<div class="g-container" style="min-height: 100vh;padding-top:50px;padding-bottom:50px;">
    <div style="display:flex; flex-direction:column;align-items:center;gap:30px">
        <a href="<?= get_category_link($category) ?>" class="category"><?= $category->name ?></a>
        <div>
            <h1 class="title" style="text-align: center;"><?php the_title() ?> <br></h1>
            <div class="date" style="text-align: center;"><i class="fa-solid fa-calendar-days"></i> <?= get_the_date() ?></div>
        </div>

        <div>
            <?= get_the_post_thumbnail() ?>
        </div>
        <div>
            <?php the_content() ?>
        </div>
    </div>
</div>
<?php get_footer() ?>
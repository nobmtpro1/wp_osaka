<?php get_header() ?>
<?php woocommerce_breadcrumb() ?>
<div class="page-blogs">
    <div class="g-container wrap">
        <div class="blogs">

            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
            ?>
                    <div class="blog">
                        <div class="image">
                            <?= get_the_post_thumbnail() ?>
                            <div class="date">
                                <div class="day"><?= date("d", strtotime($post->post_date)); ?></div>
                                <div class="year"><?= date("m/Y", strtotime($post->post_date)); ?></div>
                            </div>
                        </div>
                        <h3 class="title"><?= the_title() ?></h3>
                        <p class="description"><?= get_the_excerpt() ?></p>
                        <a href="<?= get_the_permalink() ?>" class="g-button">Xem thêm</a>
                    </div>
            <?php
                }
            }
            ?>


        </div>
        <div class="g-paginate">
            <?= paginate_links(); ?>
        </div>
    </div>
</div>

<?php get_footer() ?>
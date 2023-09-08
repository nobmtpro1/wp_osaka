<?php get_header() ?>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4><?php the_title() ?></h4>
                    <?php
                    if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<div class="breadcrumb__links">', '</div>');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<section class="about spad">
    <div class="container">
        <?php the_content() ?>
    </div>
</section>
<?php get_footer() ?>
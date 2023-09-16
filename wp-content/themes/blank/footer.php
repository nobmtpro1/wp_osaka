<?php global $template; ?>

<footer class="component-footer">
    <section class="top">
        <div class="wrap g-container">
            <div class="left">
                <div class="title">
                    THÔNG TIN
                </div>
                <div class="content">
                    <div><?= get_field('address', 'option') ?></div>
                    <div class="map">
                        <iframe src="<?= get_field('map_embed', 'option') ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </iframe>
                    </div>

                    <div>
                        <?php
                        $info = get_field('thong_tin', 'option');
                        echo $info;
                        ?>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="title">
                                LIÊN KẾT
                            </div>
                            <ul class="socials">
                                <?php
                                $facebook = get_field('facebook', 'option');
                                $twitter = get_field('twitter', 'option');
                                $googleplus = get_field('googleplus', 'option');
                                $youtube = get_field('youtube', 'option');
                                $instagram = get_field('instagram', 'option');
                                ?>
                                <?php if ($facebook) : ?>
                                    <li>
                                        <a href="<?= $facebook ?>" target="_blank" title="OSAKA VIỆT NAM">
                                            <i class="fa-brands fa-facebook"></i>
                                        </a>
                                    </li>
                                <?php endif ?>
                                <?php if ($twitter) : ?>
                                    <li>
                                        <a href="<?= $twitter ?>" target="_blank" title="OSAKA VIỆT NAM">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </li>
                                <?php endif ?>
                                <?php if ($googleplus) : ?>
                                    <li>
                                        <a href="<?= $googleplus ?>" target="_blank" title="OSAKA VIỆT NAM">
                                            <i class="fa-brands fa-google-plus-g"></i>
                                        </a>
                                    </li>
                                <?php endif ?>
                                <?php if ($youtube) : ?>
                                    <li>
                                        <a href="<?= $youtube ?>" target="_blank" title="OSAKA VIỆT NAM">
                                            <i class="fa-brands fa-youtube"></i>
                                        </a>
                                    </li>
                                <?php endif ?>
                                <?php if ($instagram) : ?>
                                    <li>
                                        <a href="<?= $instagram ?>" target="_blank" title="OSAKA VIỆT NAM">
                                            <i class="fa-brands fa-instagram"></i>
                                        </a>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </div>
                        <div class="col">
                            <div class="title">
                                THANH TOÁN
                            </div>
                            <div class="image">
                                <img alt="Các phương thức thanh toán" src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image5.webp">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="above">
                    <div class="col">
                        <?php
                        $links = get_field('links_cot_2', 'option');
                        $title = get_field('tieu_de_cot_2', 'option');
                        ?>
                        <div class="title"><?= $title ?></div>
                        <ul class="links">
                            <?php foreach ($links as $link) : ?>
                                <?php $link = $link['link'] ?>
                                <li><a target="<?= @$link['target'] ?>" href="<?= @$link['url'] ?>"><?= @$link['title'] ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>

                    <div class="col">
                        <?php
                        $links = get_field('links_cot_3', 'option');
                        $title = get_field('tieu_de_cot_3', 'option');
                        ?>
                        <div class="title"><?= $title ?></div>
                        <ul class="links">
                            <?php foreach ($links as $link) : ?>
                                <?php $link = $link['link'] ?>
                                <li><a target="<?= @$link['target'] ?>" href="<?= @$link['url'] ?>"><?= @$link['title'] ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>

                    <div class="col">
                        <?php
                        $links = get_field('links_cot_4', 'option');
                        $title = get_field('tieu_de_cot_4', 'option');
                        ?>
                        <div class="title"><?= $title ?></div>
                        <ul class="links">
                            <?php foreach ($links as $link) : ?>
                                <?php $link = $link['link'] ?>
                                <li><a target="<?= @$link['target'] ?>" href="<?= @$link['url'] ?>"><?= @$link['title'] ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="below">
                    <div class="title">
                        HÃY ĐỂ LẠI MAIL NHẬN NHIỀU ƯU ĐÃI HƠN
                    </div>
                    <form action="" class="form" id="newletters-form">
                        <input type="email" required placeholder="Đăng ký email">
                        <button>Đăng ký</button>
                    </form>
                    <div class="help-text">* Hãy để lại email để nhận được những khuyến mãi mới nhất</div>
                </div>
            </div>
        </div>
    </section>
    <section class="bot">
        <div class="wrap g-container">
            <div class="image">
                <img alt="OSAKA VIỆT NAM" src="<?= TEMPLATE_DIRECTORY ?>/assets/images/image6.webp">
            </div>
            <div class="content">
                <?php
                echo get_field('copyright', 'option');
                ?>
            </div>
            <div class="copyright">
                © Bản quyền thuộc về CoDev Service Co., LTD.
            </div>
        </div>
    </section>
</footer>

<?php include 'views/button-contact-vr.php' ?>



<script src="<?= TEMPLATE_DIRECTORY ?>/assets/libs/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= TEMPLATE_DIRECTORY ?>/assets/libs/swiper.js"></script>
<script src="<?= TEMPLATE_DIRECTORY ?>/assets/js/main.js?v=<?= time() ?>"></script>
<script src="<?= TEMPLATE_DIRECTORY ?>/assets/js/woocommerce.js?v=<?= time() ?>"></script>

<?php if (basename($template) == TEMPLATE_HOME_PAGE) : ?>
    <script src="<?= TEMPLATE_DIRECTORY ?>/assets/js/home-page.js?v=<?= time() ?>"></script>
<?php endif ?>


<?php
$zalo_id = get_field('zalo_id', 'option');
$zalo_welcome_message = get_field('zalo_welcome_message', 'option');
?>
<div class="zalo-chat-widget" data-oaid="<?= $zalo_id ?>" data-welcome-message="<?= $zalo_welcome_message ?>" data-autopopup="03" data-width="350" data-height="420"></div>
<script src="https://sp.zalo.me/plugins/sdk.js"></script>


<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v7.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat" attribution=setup_tool page_id="465686066787432" logged_in_greeting="Osaka Việt Nam thân chào quý khách, cảm ơn quý khách đã liên hệ." logged_out_greeting="Osaka Việt Nam thân chào quý khách, cảm ơn quý khách đã liên hệ.">
</div>

<?php wp_footer() ?>
</body>

</html>
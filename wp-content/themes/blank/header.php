<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= get_the_title(); ?> - OSAKA VIỆT NAM</title>
    <?= wp_head() ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?= TEMPLATE_DIRECTORY ?>/assets/libs/swiper.css" rel="stylesheet" />
    <link href="<?= TEMPLATE_DIRECTORY ?>/assets/css/button-contact-vr.css" rel="stylesheet" />
    <link href="<?= TEMPLATE_DIRECTORY ?>/assets/css/main.css?v=<?= time() ?>" rel="stylesheet" />
</head>

<body <?php body_class() ?>>
    <header class="component-header">
        <div class="top">
            <div class="g-container">
                <ul>
                    <li> <i class="fa-solid fa-location-dot"></i> <?= get_field('address', 'option') ?>
                    </li>
                    <li><i class="fa-solid fa-envelope"></i><?= get_field('email', 'option') ?></li>
                    <li><i class="fa-solid fa-phone"></i><?= get_field('phone', 'option') ?></li>
                </ul>
            </div>
        </div>
        <div class="mid">
            <div class="g-container">
                <div class="menu-button">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <div class="logo">
                    <?= the_custom_logo() ?>
                </div>
                <form class="search" action="<?= BASE_URL ?>">
                    <div class="icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="hidden" name="post_type" value="product">
                    <input type="text" placeholder="Nhập tên sản phẩm..." name="s">
                    <button>Tìm kiếm</button>
                </form>
                <div class="right">
                    <a class="link" href="" id="check-order">
                        <div class="image">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <div class="text">
                            Kiểm tra <br> đơn hàng
                        </div>
                    </a>
                    <a class="link" href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>
">
                        <div class="image">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                        <div class="text">
                            <b>Đăng nhập</b><br>
                            Chi tiết tài khoản
                        </div>
                    </a>
                    <a class="cart" href="<?= BASE_URL ?>/cart">
                        <?php include 'views/mini-cart.php' ?>
                    </a>
                </div>

            </div>
        </div>
        <div class="bot">
            <div class="mobile-backdrop"></div>
            <div class="g-container">
                <div class="left">
                    <div class="menu-button">
                        <i class="fa-solid fa-bars"></i> <span class="text">DANH MỤC SẢN PHẨM</span>
                    </div>

                    <?php wp_nav_menu() ?>
                    <script>
                        document.querySelector(".component-header .menu")?.classList?.add("hide-desktop")
                    </script>
                </div>
                <div class="right">
                    <div class="info">
                        <i class="fa fa-truck"></i>
                        Giao Hàng Toàn Quốc
                    </div>
                    <div class="info">
                        <i class="fa-solid fa-money-bill"></i>
                        Đổi trong vòng 7 ngày
                    </div>
                    <div class="info">
                        <i class="fa fa-umbrella"></i>
                        100% sản phẩm chính hãng
                    </div>
                </div>
            </div>
        </div>
    </header>
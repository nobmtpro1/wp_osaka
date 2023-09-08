<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <?= wp_head() ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?= bloginfo('template_directory') ?>/assets/css/style.css?a<?= time() ?>=<?= time() ?>" rel="stylesheet" />
</head>

<body <?php body_class() ?>>

    <header class="header">
        <div class="logo">
            <?= the_custom_logo() ?>
        </div>
        <?php wp_nav_menu() ?>
        <div class="links">
            <form class="search" action="<?= bloginfo('url') ?>">
                <input type="hidden" name="post_type" value="product">
                <input type="text" id="search-input" placeholder="Tìm kiếm....." name="s">
            </form>
            <!-- <a href="<?= bloginfo('url') ?>/wishlist" class="account">
                <i class="fa-solid fa-heart"></i>
            </a> -->
            <a href="<?= bloginfo('url') ?>/my-account" class="account">
                <i class="fa-solid fa-user"></i>
            </a>
            <?php include 'mini-cart.php' ?>
            <div class="hamburger">
                <i class="fa-solid fa-bars fa-2xl"></i>
            </div>
        </div>
    </header>
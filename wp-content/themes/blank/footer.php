<?php global $template; ?>

<footer class="footer">

</footer>

<script src="<?= TEMPLATE_DIRECTORY ?>/assets/libs/jquery.js"></script>
<script src="<?= TEMPLATE_DIRECTORY ?>/assets/libs/swiper.js"></script>
<script src="<?= TEMPLATE_DIRECTORY ?>/assets/js/main.js?v=<?= time() ?>"></script>


<?php if (basename($template) == "home-page.php") : ?>
    <script src="<?= TEMPLATE_DIRECTORY ?>/assets/js/home-page.js?v=<?= time() ?>"></script>
<?php endif ?>

<?php wp_footer() ?>

</body>

</html>
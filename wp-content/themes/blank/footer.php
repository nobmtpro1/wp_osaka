<footer class="footer">
    <div class="row">
        <div class="info">
            <h3><?= get_theme_mod('footer_col1_title') ?></h3> <br>
            <?= get_theme_mod('footer_col1_description') ?>
        </div>
        <ul>
            <li>
                <h3><?= get_theme_mod('footer_col2_title') ?> </h3>
            </li>
            <?php for ($i = 1; $i < 10; $i++) : ?>
                <?php
                $link_name = get_theme_mod('footer_col2_link_name_' . $i);
                $link = get_theme_mod('footer_col2_link_' . $i);
                if (!$link_name && !$link) {
                    continue;
                }
                ?>
                <li><a href="<?= $link ?>"><?= $link_name ?></a> </li>
            <?php endfor ?>
        </ul>
        <ul>
            <li>
                <h3><?= get_theme_mod('footer_col3_title') ?> </h3>
            </li>
            <?php for ($i = 1; $i < 10; $i++) : ?>
                <?php
                $link_name = get_theme_mod('footer_col3_link_name_' . $i);
                $link = get_theme_mod('footer_col3_link_' . $i);
                if (!$link_name && !$link) {
                    continue;
                }
                ?>
                <li><a href="<?= $link ?>"><?= $link_name ?></a> </li>
            <?php endfor ?>
        </ul>
        <ul>
            <li>
                <h3><?= get_theme_mod('footer_col4_title') ?> </h3>
            </li>
            <?php for ($i = 1; $i < 10; $i++) : ?>
                <?php
                $link_name = get_theme_mod('footer_col4_link_name_' . $i);
                $link = get_theme_mod('footer_col4_link_' . $i);
                if (!$link_name && !$link) {
                    continue;
                }
                ?>
                <li><a href="<?= $link ?>"><?= $link_name ?></a> </li>
            <?php endfor ?>
        </ul>
    </div>
    <div class="copyright">
        <?= get_theme_mod('footer_copyright') ?>
    </div>
</footer>

<?php wp_footer() ?>
<script src="<?= bloginfo('template_directory') ?>/assets/js/main.js"></script>
</body>

</html>
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2>
        <?php _e('Newsletters', 'wpbc') ?>
        <!-- <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=aim_newsletter&my_action=add_or_edit'); ?>"><?php _e('Add new', 'wpbc') ?></a> -->
    </h2>
    <?php echo $message; ?>
    <form id="contacts-table" method="GET">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $table->search_box('Search', 'Search') ?>
        <?php $table->display() ?>
    </form>
</div>
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

<script>
    const form = document.querySelector("#contacts-table");
    form?.addEventListener("click", function(element) {
        if (element.target && element.target.classList?.contains("sync-newsletter")) {
            let data = new FormData();
            data.append("action", "sync_newsletter");
            data.append("id", element.target?.getAttribute("data-id"));
            fetch('<?= admin_url('admin-ajax.php') ?>', {
                    method: 'POST',
                    body: data
                }).then(res => res.json())
                .then(res => {
                    alert(res?.data)
                })
        }
        if (element.target && element.target.classList?.contains("delete-newsletter")) {
            if (confirm("Are you sure?")) {
                let data = new FormData();
                data.append("action", "delete_newsletter");
                data.append("id", element.target?.getAttribute("data-id"));
                fetch('<?= admin_url('admin-ajax.php') ?>', {
                        method: 'POST',
                        body: data
                    }).then(res => res.json())
                    .then(res => {
                        if (res?.success) {
                            window.location.href = window.location.href
                        } else {
                            alert(res?.data)
                        }
                    })
            }
        }
    })
</script>
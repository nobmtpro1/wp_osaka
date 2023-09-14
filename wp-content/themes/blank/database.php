<?php

$sql = "CREATE TABLE " . NEWSLETTER_TABLE . " (
    id int(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(200) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE (email)
);";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

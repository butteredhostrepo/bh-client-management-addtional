<?php
if (!defined('WPINC')) {
    die;
}

add_role(
    'archived_manager',
    __('Archived Manager'),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
    )
);

add_role(
    'archived_counsellor',
    __('Archived Counsellor'),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
    )
);

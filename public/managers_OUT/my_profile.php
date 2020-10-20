<?php
if (!defined('WPINC')) {
    die;
}


add_action('wp_loaded', 'h4h_update_client_profile');
function h4h_update_my_profile()
{
    die("sdf");
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['curent_page'] !== null) {
        $curent_page = $_POST['curent_page'];
        $ID = intval($_POST['my_profile']);

        update_user_meta($ID, 'first_name', $_POST['first_name']);
        update_user_meta($ID, 'last_name', $_POST['last_name']);
        update_user_meta($ID, '_wpc_mobile_number', $_POST['_wpc_mobile_number']);

        wp_redirect($curent_page . "&updated=true");
        exit();
    }
}


function my_profile()
{
    $current_user = wp_get_current_user();
    $ID = $current_user->ID;

    ob_start();
    include 'templates/my_profile.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}

add_shortcode('my_profile', 'my_profile');

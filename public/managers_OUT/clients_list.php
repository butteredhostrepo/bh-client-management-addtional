<?php

if (!defined('WPINC')) {
    die;
}

function manager_my_clients()
{
    global $wpdb;
    $current_user = wp_get_current_user();
    $manager_id = $current_user->ID;

    $sql_get_clients = "SELECT  `assign_id` as ID 
    FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
    WHERE `object_id`= '$manager_id' AND `assign_type`='client'
    ORDER BY id DESC ";

    if (get_query_var('search')) {
        $search_string = esc_attr(get_query_var('search'));

        $sql_get_clients = "SELECT  `assign_id` as ID 
        FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
        WHERE `object_id`= '$manager_id' and `assign_type`='client' 
        AND `assign_id` IN(
            SELECT DISTINCT ID FROM `{$wpdb->prefix}users` u
            LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID = um.user_id
            WHERE u.`user_email` like '%$search_string%' 
            OR u.`user_login` like '%$search_string%'  OR u.`display_name` like '%$search_string%'
            OR (um.meta_key='first_name' AND um.meta_value like '%$search_string%') 
            OR (um.meta_key='last_name' AND um.meta_value like '%$search_string%')
        )";
    }

    if (isset($_REQUEST['status'])) {
        $status_filter = esc_attr($_REQUEST['status']);
        $sql_get_clients = "SELECT  `assign_id` as ID 
        FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
        WHERE `object_id`= '$manager_id' and `assign_type`='client' AND `assign_id` IN(
            SELECT DISTINCT ID FROM `{$wpdb->prefix}users` u
            LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID = um.user_id
            WHERE (um.meta_key='wpc_cf_status' AND um.meta_value = '$status_filter')
        )";
    }

    $my_clients = $wpdb->get_results($sql_get_clients);


    ob_start();
    include 'templates/client_list.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}

add_shortcode('manager_my_clients', 'manager_my_clients');



add_action('wp_loaded', 'h4h_update_client_profile');
function h4h_update_client_profile()
{


    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['curent_page'] !== null) {

        $curent_page = $_POST['curent_page'];

        switch ($_POST['action']) {
            case 'update':
                $client_id = intval($_POST['client']);


                update_user_meta($client_id, 'first_name', $_POST['first_name']);
                update_user_meta($client_id, 'last_name', $_POST['last_name']);
                update_user_meta($client_id, '_wpc_mobile_number', $_POST['_wpc_mobile_number']);
                update_user_meta($client_id, 'wpc_cf_status', $_POST['wpc_cf_status']);
                //update_user_meta($client_id, 'wpc_cf_counsellor', $_POST['wpc_cf_counsellor']);

                $args = array(
                    'ID'         => $client_id,
                    'user_email' => esc_attr($_POST['user_email'])
                );
                wp_update_user($args);

                $counsellor = get_user_meta($client_id, 'wpc_cf_counsellor', true);
                if ($counsellor !== $_POST['wpc_cf_counsellor']) {

                    $client = get_userdata(esc_attr($_POST['wpc_cf_counsellor']));
                    update_user_meta($client_id, 'wpc_cf_counsellor', $_POST['wpc_cf_counsellor']);
                    if (isset($client->user_email)) {
                        $current_user = wp_get_current_user();
                        $current_email = $current_user->user_email;
                        $msg = "
                        Hi,
                        
                        You have a new client. Please check on the dashboard https://admin.healingfortheheart.co.uk.

                        Thank you.
                        ";

                        //h4h_mail($client->user_email, $current_email, 'New Client Assignment', $msg, 'NOTIFICATION');
                    }
                }



                wp_redirect($curent_page . "&updated=true");
                exit();

                break;

            case "add":
                $current_user = wp_get_current_user();
                $email = $current_user->user_email;

                //$headers = array("From: Healing for the Heart <$email>", "Content-Type: text/html; charset=UTF-8");
                // wp_mail('winnard@butteredhost.com', 'Account', 'Test', $headers);
                //  wp_mail('casiplewinnard@gmail.com', 'Account', $msg, $headers);

                if (!username_exists($_POST['user_email']) and  !email_exists($_POST['user_email'])) {
                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $new_user = array(
                        'user_pass' => $random_password,
                        'user_login' => $_POST['user_email'],
                        'user_email' => $_POST['user_email'],
                        'display_name' => $_POST['first_name'] . " " . $_POST['last_name'],
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'role' => 'wpc_client',
                    );

                    $new_user_id = wp_insert_user($new_user);

                    update_user_meta($new_user_id, '_wpc_mobile_number', esc_attr($_POST['_wpc_mobile_number']));
                    update_user_meta($new_user_id, 'wpc_cf_status', esc_attr($_POST['wpc_cf_status']));
                    update_user_meta($client_id, 'wpc_cf_counsellor', esc_attr($_POST['wpc_cf_counsellor']));


                    $msg = "                
                    Hi,<br>
                    <br>
                    Your account has been created. See details below:<br>
                    Username: " . $_POST['user_email'] . "<br>
                    Temporary Password: $random_password<br>
                    Login link: https://admin.healingfortheheart.co.uk/<br>
                    <br>  
                    ";

                    //h4h_mail($_POST['user_email'], $email, 'New Account', $msg, 'WELCOME');

                    assign_client_to_manager($new_user_id);

                    wp_redirect($curent_page . "$new_user_id&added=true");
                    exit();
                } else {
                    wp_redirect($curent_page . "&added=false");
                    exit();
                }

                break;

            case 'update_my_profile':

                //$ID = intval($_POST['my_profile']);
                $current_user = wp_get_current_user();
                $ID  = $current_user->ID;

                //check if pass is correct then update other info 
                //else if pass is empty update other info
                if (!empty($_POST['password']) && !empty($_POST['_password'])) {
                    if (isset($_POST['update_pass'])) {
                        if (wp_check_password($_POST['password'], $current_user->user_pass, $ID)) {
                            wp_set_password($_POST['_password'], $ID);
                            wp_redirect(home_url());
                            exit();
                        } else {
                            $error = "?err=1";
                            wp_redirect($curent_page . "$error");
                            exit();
                        }
                    }
                } else {
                    if (isset($_POST['update_profile'])) {
                        update_user_meta($ID, 'first_name', esc_attr($_POST['first_name']));
                        update_user_meta($ID, 'last_name', esc_attr($_POST['last_name']));
                        update_user_meta($ID, '_wpc_mobile_number', $_POST['wpc_mobile_number']);
                        update_user_meta($ID, 'description', esc_attr($_POST['description']));

                        // $my_phone = get_user_meta($ID, '_wpc_phone_number', true);
                        //$my_phone = empty($my_phone) ? 'empty' : $my_phone;

                        //if ($my_phone === 'empty') {
                        delete_user_meta($ID, '_wpc_phone_number');
                        add_user_meta($ID, '_wpc_phone_number', $_POST['wpc_phone_number']);
                        //} else {
                        //update_user_meta($ID, '_wpc_phone_number', $_POST['wpc_phone_number']);
                        //}


                        $args = array(
                            'ID' => $ID,
                            'user_email' => esc_attr($_POST['user_email'])
                        );
                        wp_update_user($args);

                        wp_redirect($curent_page . "?updated=true");
                        exit();
                    }
                }

                break;

            case 'add_client_notes':
                global $wpdb;

                $current_user = wp_get_current_user();
                $ID  = $current_user->ID;

                $wpdb->insert("{$wpdb->prefix}wpc_bh_client_notes", array(
                    "client_id" => esc_attr($_POST['client']),
                    "by_user_id" => $ID,
                    "session_date" => esc_attr($_POST['session_date']),
                    "note" => esc_attr($_POST['note']),
                ));

                wp_redirect($curent_page . "&addednote=true");
                exit();
                break;

            default:
        }
    }
}

function client_profile()
{
    global $wpdb;
    global $wp;
    ob_start();
    $client = isset($_REQUEST['client']) ? $_REQUEST['client'] : '';
    $client_id = esc_attr($client);

    $current_url = home_url(add_query_arg(array(), $wp->request)) . "/?client=" . $client_id;


    $client = get_userdata($client_id);

    $current_status = get_user_meta($client_id, 'wpc_cf_status', true);

    $statuses =  get_statuses_for_clients();



    include 'templates/client_profile.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('client_profile', 'client_profile');


function client_forms()
{
    global $wpdb;

    $client = isset($_REQUEST['client']) ? $_REQUEST['client'] : '';
    $client_id = esc_attr($client);

    $client_forms = array();

    if ($client_id !== '') {
        /*$sql = "SELECT fa.*, f.title FROM `{$wpdb->prefix}wpc_frmw_answers` fa
        LEFT JOIN `{$wpdb->prefix}wpc_frmw_forms` f ON fa.form_id=f.id
        WHERE `user_id`='$client_id'
        ORDER BY `id` DESC";*/

        $sql = "SELECT * FROM `{$wpdb->prefix}wpc_frmw_forms`        
        WHERE `id`!='1'
        ORDER BY `id` ASC";

        $client_forms = $wpdb->get_results($sql);
    }

    ob_start();
    include 'templates/client_forms.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('client_forms', 'client_forms');


function view_answered_form()
{
    global $wpdb;
    $form_id = esc_attr($_REQUEST['form']);
    $answer_id = esc_attr($_REQUEST['answer']);
    $client_id = esc_attr($_REQUEST['client']);

    //get form id for wpc_frmw_fields
    $sql = "SELECT * FROM `{$wpdb->prefix}wpc_frmw_answers` 
    WHERE `user_id`='$client_id'  AND `form_id`='$form_id'";

    $form = $wpdb->get_row($sql);
    $form_id = $form->form_id;

    //get form fields by id
    $sql = "SELECT * FROM `{$wpdb->prefix}wpc_frmw_fields` 
    WHERE `form_id`='$form_id'
    ORDER BY order_id ASC";

    $fields = $wpdb->get_results($sql);

    ob_start();
    include 'templates/client_form_answers.php';
    $output = ob_get_contents();
    ob_end_clean();
    return  $output;
}
add_shortcode('view_answered_form', 'view_answered_form');

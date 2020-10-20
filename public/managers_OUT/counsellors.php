<?php

if (!defined('WPINC')) {
    die;
}


function manager_counsellors()
{

    if (get_query_var('search')) {


        $str = get_query_var('search');
        $wp_user_query = new WP_User_Query(
            array(
                'role' => 'wpc_client_staff',
                'search' => "*{$str}*",
                'search_columns' => array(
                    'user_login',
                    'user_nicename',
                    'user_email',
                    'display_name'
                ),

            )
        );
        $users = $wp_user_query->get_results();

        //search usermeta
        $wp_user_query2 = new WP_User_Query(
            array(
                'role' => 'wpc_client_staff',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'first_name',
                        'value' => $str,
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'last_name',
                        'value' => $str,
                        'compare' => 'LIKE'
                    )
                )
            )
        );

        $users2 = $wp_user_query2->get_results();

        $totalusers_dup = array_merge($users, $users2);

        $my_counsellors = array_unique($totalusers_dup, SORT_REGULAR);


        //   $my_counsellors = array_unique(array_merge($my_counsellors1, $my_counsellors2), SORT_REGULAR);
    } else {
        $args = array(
            'role' => 'wpc_client_staff',
            'orderby' => 'user_nicename',
            'order' => 'ASC'
        );
        $my_counsellors = get_users($args);
    }




    ob_start();
    include 'templates/counsellors_list.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}

add_shortcode('manager_counsellors', 'manager_counsellors');


function counsellor_profile()
{
    $counsellor = isset($_REQUEST['counsellor']) ? $_REQUEST['counsellor'] : '';
    $counsellor_id = intval($counsellor);

    $counsellor = get_userdata($counsellor_id);

    ob_start();
    include 'templates/counsellor_profile.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('counsellor_profile', 'counsellor_profile');


/// @Counsellor -> client list
/// @Manager -> Counsellor -> client list
function counsellor_client_list()
{
    global $wpdb;
    $current_user = wp_get_current_user();
    $counsellor_id = $current_user->ID;

    $counsellor = isset($_REQUEST['counsellor']) ? $_REQUEST['counsellor'] : '';
    if ($counsellor !== '') {
        $counsellor_id = intval($counsellor);
    }


    $sql = "SELECT user_id as ID FROM `{$wpdb->prefix}usermeta` 
    WHERE `meta_key`='wpc_cf_counsellor' 
    AND `meta_value`='$counsellor_id'";


    $my_clients = $wpdb->get_results($sql);

    ob_start();

    if (current_user_can('wpc_manager'))
        include 'templates/counsellor_clients_list.php';
    else if (current_user_can('wpc_client_staff'))
        include 'templates/counsellor/counsellor_clients_list.php';

    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('counsellor_client_list', 'counsellor_client_list');



function counsellor_add_notes_client()
{
    global $wpdb;

    $client_id = isset($_REQUEST['client']) ? $_REQUEST['client'] : '';

    $sql = "SELECT cn.id, u.display_name , cn.`session_date`, cn.`note` 
    FROM `{$wpdb->prefix}wpc_bh_client_notes` cn
    LEFT JOIN wp_users u ON cn.`client_id`=u.`ID`
    WHERE client_id='$client_id'
    ORDER BY cn.id DESC";

    $notes = $wpdb->get_results($sql);

    ob_start();

    if (current_user_can('wpc_client_staff'))
        include 'templates/counsellor/counsellor_client_notes.php';


    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('counsellor_add_notes_client', 'counsellor_add_notes_client');

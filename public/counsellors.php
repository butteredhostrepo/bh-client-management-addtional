<?php

if (!defined('WPINC')) {
    die;
}


function manager_counsellors()
{
    global $wpdb, $max_num_pages;


    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $post_per_page = 20;
    $offset = ($paged - 1) * $post_per_page;

    $limit = " LIMIT " . $offset . ", " . $post_per_page;


    /*if (get_query_var('search')) {


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
    */
    $seach_sql = "";

    if (isset($_GET['search']) && $_GET['search'] != '') {

        $keyword = esc_sql($_GET['search']);

        $seach_sql = " AND (u.user_email like '%$keyword%' 
        OR u.display_name like '%$keyword%' 
        OR um1.meta_value like '%$keyword%' 
        OR um2.meta_value like '%$keyword%' )";
    }


    $sql = "SELECT u.ID, u.user_email, 
        um1.meta_value as first_name,
        um2.meta_value as last_name, 
        u.user_registered 
        FROM `{$wpdb->prefix}users` u
        LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID= um.user_id
        LEFT JOIN `{$wpdb->prefix}usermeta` um1 ON u.ID= um1.user_id AND um1.`meta_key`='first_name' 
        LEFT JOIN `{$wpdb->prefix}usermeta` um2 ON u.ID= um2.user_id AND um2.`meta_key`='last_name' 
        WHERE um.`meta_key`='wp_capabilities' and um.`meta_value` like '%wpc_client_staff%'  $seach_sql 
        ORDER BY u.ID DESC";

    $my_counsellors = $wpdb->get_results($sql . $limit);

    $sql_posts_total = $wpdb->get_results($sql);
    $sql_posts_total = count($sql_posts_total);

    $max_num_pages = ceil($sql_posts_total / $post_per_page);





    ob_start();
    include 'templates/manager/counsellors_list.php';
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

    $availability = get_user_meta($counsellor_id, 'wpc_cf_availability_day');
    $availability = !empty($availability[0]) ? $availability[0] : "";

    $student = get_user_meta($counsellor_id, 'wpc_cf_student');


    ob_start();
    include 'templates/manager/counsellor_profile.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('counsellor_profile', 'counsellor_profile');



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
    AND `meta_value`='$counsellor_id'
    AND `user_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )";


    $my_clients = $wpdb->get_results($sql);

    ob_start();


    include 'templates/manager/counsellor_clients_list.php';


    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('counsellor_client_list', 'counsellor_client_list');



/// @Manager -> Counsellor -> Add Counsellor
function add_counsellor()
{

    ob_start();


    include 'templates/manager/counsellor_add_form.php';


    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('add_counsellor', 'add_counsellor');

<?php

if (!defined('WPINC')) {
    die;
}

//@ reports.php
function report_client_statuses()
{
    $current_user = wp_get_current_user();
    $ID = $current_user->ID;

    $statuses = get_statuses_for_clients();

    ob_start();
    include 'templates/report/clients.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}

add_shortcode('report_client_status', 'report_client_statuses');



function report_counsellors()
{

    $args = array(
        'role' => 'wpc_client_staff',
        'orderby' => 'user_nicename',
        'order' => 'ASC'
    );
    $my_counsellors = get_users($args);

    ob_start();
    include 'templates/report/counsellors.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}

add_shortcode('report_counsellors', 'report_counsellors');


function report_donations($atts)
{
    global $wpdb;


    $sql = "SELECT ROUND(SUM(amount), 2) as total 
        FROM `{$wpdb->prefix}wpc_bh_client_donations`";

    $all = $wpdb->get_row($sql)->total;

    $sql = "SELECT ROUND(SUM(amount), 2) as total 
        FROM `{$wpdb->prefix}wpc_bh_client_donations` WHERE YEARWEEK(`date`, 1) = YEARWEEK(CURDATE(), 1)";

    $weekly = $wpdb->get_row($sql)->total;

    $sql = "SELECT ROUND(SUM(amount), 2)  as total 
        FROM `{$wpdb->prefix}wpc_bh_client_donations`
        WHERE MONTH(date) = MONTH(CURRENT_DATE())
        AND YEAR(date) = YEAR(CURRENT_DATE())";

    $monthly = $wpdb->get_row($sql)->total;

    $sql = "SELECT  u_client.display_name as client, ROUND(SUM(amount),2) as total_donated
    FROM `{$wpdb->prefix}wpc_bh_client_donations` cd
    LEFT JOIN `{$wpdb->prefix}users` u_client ON cd.client_id = u_client.ID
    LEFT JOIN `{$wpdb->prefix}users` u_addedby ON cd.by_user_id = u_addedby.ID
    GROUP BY client
    Order by total_donated DESC";

    //$top_donor = $wpdb->get_row($sql);
    $top_donor_client = '';
    //$top_donor_client = $top_donor->client;
    //$top_donor_amount = $top_donor->total_donated;

    ob_start();
    include 'templates/report/donations.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}

add_shortcode('report_donations', 'report_donations');



function report_open_risk_report()
{
    $current_user = wp_get_current_user();
    $ID = $current_user->ID;

    global $wpdb;
    $where = "";

    $where = "WHERE (um.meta_key='wpc_cf_risk_report_viewed' AND um.meta_value = '0')";



    $sql_risk_report_clients = "SELECT  DISTINCT `assign_id` as id
        FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
        WHERE `object_id`= '$ID' and `assign_type`='client' AND `assign_id` IN(
            SELECT DISTINCT ID FROM `{$wpdb->prefix}users` u
            LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID = um.user_id
            $where
        )  AND `assign_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )";


    $sql_risk_report_clients = "SELECT DISTINCT ID as id FROM `wp_users` u
    LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID = um.user_id   
    WHERE (um.meta_key='wpc_cf_risk_report_viewed' AND um.meta_value = '0')";



    $open_risk_report = $wpdb->get_results($sql_risk_report_clients);



    ob_start();
    include 'templates/report/risk_report.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}

add_shortcode('report_open_risk_report', 'report_open_risk_report');


function get_clients_core_om($return_type = "OBJECT", $paginated = true)
{
    global $wpdb, $max_num_pages;
    $current_user = wp_get_current_user();
    $manager_id = $current_user->ID;


    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $post_per_page = 20;
    $offset = ($paged - 1) * $post_per_page;

    $limit = " LIMIT " . $offset . ", " . $post_per_page;



    $sql_get_clients = "SELECT DISTINCT `assign_id` as ID 
    FROM `{$wpdb->prefix}wpc_client_objects_assigns`     
    WHERE `object_id`= '$manager_id' AND `assign_type`='client'
    AND `assign_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
    ORDER BY id DESC ";

    if (get_query_var('search')) {
        $search_string = esc_attr(get_query_var('search'));

        $sql_get_clients = "SELECT DISTINCT `assign_id` as ID 
        FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
        WHERE `object_id`= '$manager_id' and `assign_type`='client' 
        AND `assign_id` IN(
            SELECT DISTINCT ID FROM `{$wpdb->prefix}users` u
            LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID = um.user_id
            WHERE u.`user_email` like '%$search_string%' 
            OR u.`user_login` like '%$search_string%'  OR u.`display_name` like '%$search_string%'
            OR (um.meta_key='first_name' AND um.meta_value like '%$search_string%') 
            OR (um.meta_key='last_name' AND um.meta_value like '%$search_string%') AND (um.meta_key='archive' AND um.meta_value!='1')
        ) AND `assign_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
        ORDER BY id DESC ";
    }

    if (isset($_REQUEST['status'])) {
        $status_filter = esc_attr($_REQUEST['status']);
        $sql_get_clients = "SELECT DISTINCT `assign_id` as ID 
        FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
        WHERE `object_id`= '$manager_id' and `assign_type`='client' AND `assign_id` IN(
            SELECT DISTINCT ID FROM `{$wpdb->prefix}users` u
            LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID = um.user_id          
            WHERE (um.meta_key='wpc_cf_status' AND um.meta_value = '$status_filter') 
        )  AND `assign_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
        ORDER BY id DESC ";
    }

    if ($paginated) {
        $sql_posts_total = $wpdb->get_results($sql_get_clients);
        $sql_posts_total = count($sql_posts_total);

        $max_num_pages = ceil($sql_posts_total / $post_per_page);


        return $my_clients = $wpdb->get_results($sql_get_clients . $limit, $return_type);
    } else {
        $my_clients = $wpdb->get_results($sql_get_clients, $return_type);
        foreach ($my_clients as $my_client) {
            $client_info = get_userdata($my_client->ID);
            $core_om1 = floatval(get_user_meta($my_client->ID, 'wpc_cf_core_om1', true)  !==  null ? get_user_meta($my_client->ID, 'wpc_cf_core_om1', true) : 0);
            $core_om2 = floatval(get_user_meta($my_client->ID, 'wpc_cf_core_om2', true)  !==  null ? get_user_meta($my_client->ID, 'wpc_cf_core_om2', true) : 0);
            $core_diff = $core_om2 - $core_om1;


            $values['client_name'] = get_user_meta($my_client->ID, 'first_name', true) . ' ' . get_user_meta($my_client->ID, 'last_name', true);
            //$values['client_email'] = $client_info->user_email;
            $values['counsellor'] = get_counsellor_name(get_user_meta($my_client->ID, 'wpc_cf_counsellor', true));
            $values['core_om1'] = $core_om1;
            $values['core_om2'] = $core_om2;
            $values['core_om_difference'] = $core_diff;
            $return[] = $values;
        }

        return $return;
    }
}

function report_core_om_difference()
{
    global $wpdb, $max_num_pages;

    $current_user = wp_get_current_user();
    $manager_id = $current_user->ID;

    $my_clients = get_clients_core_om();



    ob_start();
    include 'templates/report/core_om_difference.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('report_core_om_difference', 'report_core_om_difference');

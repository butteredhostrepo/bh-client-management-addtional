<?php

if (!defined('WPINC')) {
    die;
}


function donation_list()
{

    global $wpdb, $max_num_pages;
    $current_user = wp_get_current_user();
    $manager_id = $current_user->ID;


    $counsellor_id = isset($_GET['counsellor']) ? esc_attr($_GET['counsellor']) : "";
    $client_id = isset($_GET['client']) ? esc_attr($_GET['client']) : "";
    $date_from = isset($_GET['from']) ? esc_attr($_GET['from']) : "";
    $date_to = isset($_GET['to']) ? esc_attr($_GET['to']) : "";

    $donations = get_donations('OBJECT', true);

    /*$sql = "SELECT DISTINCT u_addedby.display_name as addedby, cd.by_user_id
    FROM `{$wpdb->prefix}wpc_bh_client_donations` cd    
    LEFT JOIN `{$wpdb->prefix}users` u_addedby ON cd.by_user_id = u_addedby.ID";*/

    $cousellors = get_counsellors();


    $sql_get_clients = "SELECT DISTINCT `assign_id` as ID, u_client.display_name
    FROM `{$wpdb->prefix}wpc_client_objects_assigns` coa
    LEFT JOIN `{$wpdb->prefix}users` u_client ON coa.assign_id = u_client.ID
    WHERE `object_id`= '$manager_id' AND `assign_type`='client'
    ORDER BY u_client.display_name ASC
";

    $clients = $wpdb->get_results($sql_get_clients);

    $base_link = get_permalink() . "?counsellor=$counsellor_id&client=$client_id&from=$date_from&to=$date_to";

    ob_start();
    include 'templates/donation/donation_list.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('donations_list', 'donation_list');


///@ THIS donation_list
///@ POST action download_donation_csv
function get_donations($return_type = "OBJECT", $paginated = false)
{

    global $wpdb, $max_num_pages;


    $where = "";
    $condition = "";

    $counsellor_id = "";
    $client_id = "";
    $date_from = "";
    $date_to = "";
    $limit = "";

    if ($paginated) {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $post_per_page = 20;
        $offset = ($paged - 1) * $post_per_page;


        $limit = " LIMIT " . $offset . ", " . $post_per_page;
    }

    $orderby = "ORDER BY cd.id DESC";

    if (isset($_GET['counsellor']) && $_GET['counsellor'] !== "") {

        $counsellor_id = esc_attr($_GET['counsellor']);

        if ($where === "") {
            $where .= ' WHERE ';
            $condition .= " cd.by_user_id = '$counsellor_id'";
        } else {
            $condition .= " AND cd.by_user_id = '$counsellor_id'";
        }
    }

    if (isset($_GET['client']) && $_GET['client'] !== "") {

        $client_id = esc_attr($_GET['client']);

        if ($where === "") {
            $where .= ' WHERE ';
            $condition .= " cd.client_id = '$client_id'";
        } else {
            $condition .= " AND cd.client_id = '$client_id'";
        }
    }

    if (isset($_GET['from']) && $_GET['from'] !== "" && isset($_GET['to']) && $_GET['to'] !== "") {

        $date_from = esc_attr($_GET['from']);
        $date_to = esc_attr($_GET['to']);

        if ($where === "") {
            $where .= ' WHERE ';
            $condition .= " cd.date BETWEEN '$date_from' AND '$date_to' ";
        } else {
            $condition .= " AND cd.date BETWEEN '$date_from' AND '$date_to' ";
        }
    }

    if (isset($_GET['orderby']) && $_GET['orderby'] == "date") {
        if ($_GET['order'] == 'desc')
            $orderby = "ORDER BY cd.date DESC";
        else
            $orderby = "ORDER BY cd.date ASC";
    }

    if (isset($_GET['orderby']) && $_GET['orderby'] == "amount") {
        if ($_GET['order'] == 'desc')
            $orderby = "ORDER BY cd.amount DESC";
        else
            $orderby = "ORDER BY cd.amount ASC";
    }

    $sql = "SELECT cd.*, u_client.display_name as client, u_addedby.display_name as addedby 
    FROM `{$wpdb->prefix}wpc_bh_client_donations` cd
    LEFT JOIN `{$wpdb->prefix}users` u_client ON cd.client_id = u_client.ID
    LEFT JOIN `{$wpdb->prefix}users` u_addedby ON cd.by_user_id = u_addedby.ID
    $where
    $condition
    $orderby 
    $limit
    ";

    if ($paginated) {
        $sql_posts_total = $wpdb->get_row("SELECT COUNT(cd.id) AS total
        FROM `{$wpdb->prefix}wpc_bh_client_donations` cd
        LEFT JOIN `{$wpdb->prefix}users` u_client ON cd.client_id = u_client.ID
        LEFT JOIN `{$wpdb->prefix}users` u_addedby ON cd.by_user_id = u_addedby.ID
        $where
        $condition")->total;

        $max_num_pages = ceil($sql_posts_total / $post_per_page);
    }

    //$sql = $wpdb->prepare($sql);

    return $wpdb->get_results($sql, $return_type);
}

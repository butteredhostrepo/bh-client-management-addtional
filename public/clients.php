<?php

if (!defined('WPINC')) {
    die;
}

/// @Manager -> client list
function clients_list()
{
    global $wpdb, $max_num_pages;
    $current_user = wp_get_current_user();
    $manager_id = $current_user->ID;


    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $post_per_page = 20;
    $offset = ($paged - 1) * $post_per_page;

    $limit = " LIMIT " . $offset . ", " . $post_per_page;


    //WHERE `object_id`= '$manager_id' AND `assign_type`='client' (FILTER BY MANAGER ID [`object_id`= '$manager_id'])
    $sql_get_clients = "SELECT DISTINCT `assign_id` as ID, um1.meta_value as first_appointment 
    FROM `{$wpdb->prefix}wpc_client_objects_assigns` oa    
    LEFT JOIN wp_usermeta um ON oa.assign_id = um.user_id
    LEFT JOIN wp_usermeta um1 ON oa.assign_id = um1.user_id 
    WHERE  `assign_type`='client'
    AND um.meta_key='wp_capabilities' and um.meta_value like '%wpc_client%'
    AND `assign_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
    AND um1.meta_key='wpc_cf_first_appointment'
    ORDER BY first_appointment DESC ";

    if (get_query_var('search')) {
        $search_string = esc_attr(get_query_var('search'));

        $sql_get_clients = "SELECT DISTINCT `assign_id` as ID 
        FROM `{$wpdb->prefix}wpc_client_objects_assigns` oa
        LEFT JOIN wp_usermeta um ON oa.assign_id = um.user_id
        WHERE `assign_type`='client' 
        AND um.meta_key='wp_capabilities' and um.meta_value like '%wpc_client%'
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
        FROM `{$wpdb->prefix}wpc_client_objects_assigns` oa
        LEFT JOIN wp_usermeta um ON oa.assign_id = um.user_id
        WHERE  `assign_type`='client' 
        AND um.meta_key='wp_capabilities' and um.meta_value like '%wpc_client%'
        AND `assign_id` IN(
            SELECT DISTINCT ID FROM `{$wpdb->prefix}users` u
            LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID = um.user_id          
            WHERE (um.meta_key='wpc_cf_status' AND um.meta_value = '$status_filter') 
        )  AND `assign_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
        ORDER BY id DESC ";
    }

    $my_clients = $wpdb->get_results($sql_get_clients . $limit);

    $sql_posts_total = $wpdb->get_results($sql_get_clients);
    $sql_posts_total = count($sql_posts_total);

    $max_num_pages = ceil($sql_posts_total / $post_per_page);


    ob_start();
    include 'templates/manager/client_list.php';
    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}

add_shortcode('clients_list', 'clients_list');

/// @Counsellor -> client list
function client_list_for_counsellor()
{
    global $wpdb;
    $current_user = wp_get_current_user();
    $counsellor_id = $current_user->ID;

    /*$sql = "SELECT user_id as ID FROM `{$wpdb->prefix}usermeta` 
    WHERE `meta_key`='wpc_cf_counsellor' 
    AND `meta_value`='$counsellor_id' 
    AND `user_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
    ORDER BY user_id DESC";*/


    $sql = "SELECT um1.user_id as ID , um3.meta_value as first_appointment 
    
    FROM `{$wpdb->prefix}usermeta` um1
    
    LEFT JOIN `{$wpdb->prefix}usermeta` um2 ON um1.user_id=um2.user_id
    LEFT JOIN `{$wpdb->prefix}usermeta` um3 ON um1.user_id=um3.user_id 

    WHERE um1.`meta_key`='wpc_cf_counsellor' AND um1.`meta_value`='$counsellor_id' 
    
    AND um1.`meta_value`='$counsellor_id' 
    AND um1.`user_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
    
    AND (um2.`meta_key`='wpc_cf_status' AND um2.`meta_value`!='Completed')

    AND um3.meta_key='wpc_cf_first_appointment'
    
   ORDER BY first_appointment DESC";



    if (isset($_REQUEST['status'])) {

        $status = esc_attr($_REQUEST['status']);

        $sql = "SELECT um1.user_id as ID FROM `wp_usermeta` um1
        LEFT JOIN `wp_usermeta` um2 ON um1.user_id=um2.user_id
        WHERE (um1.`meta_key`='wpc_cf_counsellor' AND um1.`meta_value`='$counsellor_id') 
        AND (um2.`meta_key`='wpc_cf_status' AND um2.`meta_value`='$status')
        AND `user_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
        ORDER BY um1.user_id DESC";
    }

    if (isset($_REQUEST['search'])) {

        $search = esc_attr($_REQUEST['search']);

        $sql = "SELECT um1.user_id as ID FROM `wp_usermeta` um1 
        LEFT JOIN `wp_usermeta` um2 ON um1.user_id=um2.user_id 
        LEFT JOIN `wp_users` um3 ON um1.user_id=um3.ID 
        WHERE (um1.`meta_key`='wpc_cf_counsellor' AND um1.`meta_value`='$counsellor_id') 
        AND (
                (um2.`meta_key`='first_name' AND um2.`meta_value` like '%$search%') OR (um2.`meta_key`='last_name' AND um2.`meta_value` like '%$search%') 
                OR (um3.display_name like '%$search%' OR um3.user_email like '%$search%')
            )
            AND um1.`user_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
        GROUP BY ID
        ORDER BY um1.user_id DESC";
    }



    $my_clients = $wpdb->get_results($sql);

    ob_start();


    include 'templates/counsellor/cn_client_list.php';


    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('client_list_for_counsellor', 'client_list_for_counsellor');





///@ Manager -> Client -> Profile
///@ Counsellor -> Client -> Profile
function client_profile()
{
    global $wpdb;
    global $wp;
    ob_start();
    $client = isset($_REQUEST['client']) ? $_REQUEST['client'] : '';
    $client_id = intval($client);

    $current_url = home_url(add_query_arg(array(), $wp->request)) . "/?client=" . $client_id;


    $client = get_userdata($client_id);

    $current_status = get_user_meta($client_id, 'wpc_cf_status', true);

    $statuses =  get_statuses_for_clients();


    if (current_user_can('wpc_manager'))
        include 'templates/manager/client_profile.php';
    else if (current_user_can('wpc_client_staff'))
        include 'templates/counsellor/cn_client_profile.php';


    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('client_profile', 'client_profile');


///@ Manager -> Client -> forms
///@ Client -> forms
function client_forms()
{
    global $wpdb;

    if (current_user_can('wpc_client')) {
        $current_user = wp_get_current_user();
        $client_id = $current_user->ID;
    } else {
        $client = isset($_REQUEST['client']) ? $_REQUEST['client'] : '';
        $client_id = intval(esc_attr($client));
    }


    //$client_forms = array();
    $sql = "";
    if ($client_id !== '') {
        /*$sql = "SELECT fa.*, f.title FROM `{$wpdb->prefix}wpc_frmw_answers` fa
        LEFT JOIN `{$wpdb->prefix}wpc_frmw_forms` f ON fa.form_id=f.id
        WHERE `user_id`='$client_id'
        ORDER BY `id` DESC";*/

        /*  $sql = 'SELECT *
        FROM `' . $wpdb->prefix . 'wpc_frmw_forms`        
        WHERE `id`!="1" and JSON_CONTAINS(`settings`,' . "'" . '{ "permission":"logged-in"}' . "'" . ')  AND id!="7" AND status="publish"
        UNION
        SELECT * FROM `' . $wpdb->prefix . 'wpc_frmw_forms`        
        WHERE `id`!="1" AND id!="7" AND status="publish"
        UNION
        SELECT * FROM `' . $wpdb->prefix . 'wpc_frmw_forms` 
        WHERE JSON_CONTAINS(`settings`,' . "'" . '{ "permission":"logged-in"}' . "'" . ') AND id="7" AND status="publish"

        GROUP BY `id`';*/

        $sql = 'SELECT *
        FROM `' . $wpdb->prefix . 'wpc_frmw_forms`        
        WHERE `id`!="1" and JSON_CONTAINS(`settings`,' . "'" . '{ "permission":"logged-in"}' . "'" . ')  AND status="publish"
        UNION
        SELECT * FROM `' . $wpdb->prefix . 'wpc_frmw_forms`        
        WHERE `id`!="1" AND id!="7" AND status="publish"
        
        GROUP BY `id`';
    }

    //AND id!="7" -> For DOnation form to display at the bottom of the list
    if (current_user_can('wpc_client')) {
        /* $sql = 'SELECT * FROM `' . $wpdb->prefix . 'wpc_frmw_forms` 
        WHERE JSON_CONTAINS(`settings`,' . "'" . '{ "permission":"logged-in"}' . "'" . ') AND id!="7"  AND status="publish"
        UNION
        SELECT f.* FROM `' . $wpdb->prefix . 'wpc_client_objects_assigns` oa
        LEFT JOIN `wp_wpc_frmw_forms` f ON oa.object_id=f.id
        WHERE oa.assign_type="client" AND oa.assign_id="' . $client_id . '" AND object_type="form" AND f.status="publish"
        UNION
        SELECT * FROM `' . $wpdb->prefix . 'wpc_frmw_forms` 
        WHERE JSON_CONTAINS(`settings`,' . "'" . '{ "permission":"logged-in"}' . "'" . ') AND id="7" AND status="publish"
        ';*/

        $sql = 'SELECT * FROM `' . $wpdb->prefix . 'wpc_frmw_forms` 
        WHERE JSON_CONTAINS(`settings`,' . "'" . '{ "permission":"logged-in"}' . "'" . ') AND status="publish"
        UNION
        SELECT f.* FROM `' . $wpdb->prefix . 'wpc_client_objects_assigns` oa
        LEFT JOIN `wp_wpc_frmw_forms` f ON oa.object_id=f.id
        WHERE oa.assign_type="client" AND oa.assign_id="' . $client_id . '" AND object_type="form" AND f.status="publish"
       
        ';
    }


    $client_forms = $wpdb->get_results($sql);


    ob_start();


    if (current_user_can('wpc_client'))
        include 'templates/client/c_client_forms.php';
    else
        include 'templates/manager/client_forms.php';


    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('client_forms', 'client_forms');


///@ Manager -> Client -> forms > view answered form
///@ Client -> forms > view answered form
function view_answered_form()
{
    global $wpdb;
    $form_id = intval(esc_attr($_REQUEST['form']));
    $answer_id = intval(esc_attr($_REQUEST['answer']));
    $client_id = intval(esc_attr($_REQUEST['client']));

    /*
    //get form id for wpc_frmw_fields
    $sql = "SELECT * FROM `{$wpdb->prefix}wpc_frmw_answers` 
    WHERE `user_id`='$client_id'  AND `form_id`='$form_id'";

    $form = $wpdb->get_row($sql);
    $form_id = $form->form_id;

    //get form fields by id
    $sql = "SELECT * FROM `{$wpdb->prefix}wpc_frmw_fields` 
    WHERE `form_id`='$form_id' and `deleted` ='0'
    ORDER BY order_id ASC";
    */

    $sql = "SELECT a.id, a.user_id, a.form_id, a.user_id, am.field_id, 
    am.answer, ff.label, ff.field_options, ff.deleted, ff.type 
    FROM `{$wpdb->prefix}wpc_frmw_answers` a
    LEFT JOIN `{$wpdb->prefix}wpc_frmw_answer_meta` am ON a.id = am.`answer_id`
    LEFT JOIN `{$wpdb->prefix}wpc_frmw_fields` ff ON am.field_id = ff.`id`
    WHERE a.`form_id`='%d' and a.`id`='%d' and `user_id`='%d'";

    $sql = $wpdb->prepare($sql, $form_id, $answer_id, $client_id);


    $fields = $wpdb->get_results($sql);

    if (current_user_can('wpc_client'))
        $back_link = "/client/forms/#profile|0";
    else if (current_user_can('wpc_client_staff'))
        $back_link = "/counsellor/clients/client-profile/?client=$client_id#profile|1";
    else if (current_user_can('wpc_manager'))
        $back_link = "/manager/my-clients/client-profile/?client=$client_id#profile|1";


    ob_start();
    include 'templates/manager/client_form_answers.php';
    $output = ob_get_contents();
    ob_end_clean();
    return  $output;
}
add_shortcode('view_answered_form', 'view_answered_form');


///@ Client -> forms > answer this form
function answer_this_form()
{
    global $wpdb;

    $form_id = intval(esc_attr($_GET['form']));

    $sql = "SELECT title FROM `{$wpdb->prefix}wpc_frmw_forms`        
    WHERE `id`='$form_id'";
    $form = $wpdb->get_row($sql);


    ob_start();
    echo '<h2 style="text-align: center; font-size: 35px; padding-bottom: 35px;">' . $form->title . '</h2>';
    echo do_shortcode('[wpc_client_form id="' . $form_id . '" /]');
    $output = ob_get_contents();
    ob_end_clean();
    return  $output;
}
add_shortcode('answer_this_form', 'answer_this_form');



/// @Manager -> Clients -> Notes
/// @Counsellor -> Clients -> Notes
function counsellor_add_notes_client()
{
    global $wpdb;

    $current_user = wp_get_current_user();
    $ID  = $current_user->ID;

    $client_id = isset($_REQUEST['client']) ? $_REQUEST['client'] : '';
    $client_id = intval($client_id);

    $sql = "SELECT cn.id, u.display_name , cn.`session_date`, cn.`note`, u1.display_name as counsellor_name , cn.by_user_id
    FROM `{$wpdb->prefix}wpc_bh_client_notes` cn
    LEFT JOIN wp_users u ON cn.`client_id`=u.`ID`
    LEFT JOIN wp_users u1 ON cn.`by_user_id`=u1.`ID`
    WHERE client_id='$client_id'AND status='published'
    ORDER BY cn.id DESC";

    $notes = $wpdb->get_results($sql);

    ob_start();

    if (current_user_can('wpc_client_staff'))
        include 'templates/counsellor/counsellor_client_notes.php';
    else if (current_user_can('wpc_manager'))
        include 'templates/manager/counsellor_client_notes.php';


    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('counsellor_add_notes_client', 'counsellor_add_notes_client');


/// @manager -> Clients -> Donation
/// @Counsellor -> Clients -> Donation
/// @Clients -> Donation
function client_donation()
{
    global $wpdb;

    $current_user = wp_get_current_user();
    $ID  = $current_user->ID;

    $client_id = isset($_GET['client']) ? esc_attr($_GET['client']) : '';
    $client_id = intval($client_id);

    if (current_user_can('wpc_client'))
        $client_id = $ID;

    $sql = "SELECT cd.*, u_client.display_name as client, u_addedby.display_name as addedby 
    FROM `{$wpdb->prefix}wpc_bh_client_donations` cd
    LEFT JOIN `{$wpdb->prefix}users` u_client ON cd.client_id = u_client.ID
    LEFT JOIN `{$wpdb->prefix}users` u_addedby ON cd.by_user_id = u_addedby.ID
    WHERE `client_id`='%d' 
    ORDER BY cd.id DESC";

    $sql = $wpdb->prepare($sql, $client_id);

    $donations =  $wpdb->get_results($sql);

    ob_start();

    if (current_user_can('wpc_client_staff') || current_user_can('wpc_manager'))
        include 'templates/counsellor/cn_donations.php';
    else if (current_user_can('wpc_client'))
        include 'templates/client/c_donations.php';


    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('client_donation', 'client_donation');



/// @manager -> Clients -> Referral Assessment
function client_referral_assessment()
{
    global $wpdb,  $wp;

    $client_id = isset($_GET['client']) ? esc_attr($_GET['client']) : '';
    $client_id = intval($client_id);

    $current_url = home_url(add_query_arg(array(), $wp->request)) . "/?client=" . $client_id;

    $referral_assessment = get_user_meta($client_id, 'wpc_cf_referral_assessment', false);
    $referral_assessment = isset($referral_assessment[0]) ? $referral_assessment[0] :  $referral_assessment[0] = '';
    //$referral_assessment = $referral_assessment[0];

    if (current_user_can('wpc_manager'))
        $readOnly = '';
    else
        $readOnly = 'disabled=="disabled "';


    ob_start();

    include 'templates/manager/client_assessment.php';

    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('client_referral_assessment', 'client_referral_assessment');


/// @manager -> Clients -> Risk Report
function client_risk_report()
{
    global $wp, $wpdb;
    ob_start();

    $current_user = wp_get_current_user();
    $ID  = $current_user->ID;


    $client_id = isset($_GET['client']) ? esc_attr($_GET['client']) : '';
    $client_id = intval($client_id);


    $current_url = home_url(add_query_arg(array(), $wp->request)) . "/?client=" . $client_id;

    $risk_report = array();
    $risk_report = get_user_meta(esc_sql($client_id), 'wpc_cf_risk_report', false);
    //$risk_report = $risk_report[0];
    $risk_report = isset($risk_report[0]) ? $risk_report[0] :  $risk_report[0] = '';

    $risk_reports = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}usermeta` WHERE user_id='$client_id' and `meta_key`='wpc_cf_risk_report' ORDER BY umeta_id DESC");


    ///set the risk report as viewed
    if (isset($_GET['view_risk']) && $_GET['view_risk'] == 'true') {
        update_user_meta($client_id, 'wpc_cf_risk_report_viewed', 1, 0);
    }

    include 'templates/manager/client_risk_report.php';

    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('client_risk_report', 'client_risk_report');


/// @manager -> Clients -> Add Clients
function add_clients()
{

    global $wp, $wpdb;
    ob_start();
    include 'templates/manager/client_add_bulk.php';

    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('add_clients', 'add_clients');



/// @manager -> DNA LISTS
function dna_lists()
{

    global $wp, $wpdb, $max_num_pages;
    ob_start();

    $my_clients = $wpdb->get_results("SELECT DISTINCT user_id as ID FROM `{$wpdb->prefix}usermeta` WHERE `meta_key`='dna_status' AND `meta_value`='1'");

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $post_per_page = 20;
    $offset = ($paged - 1) * $post_per_page;

    $limit = " LIMIT " . $offset . ", " . $post_per_page;

    $my_clients_history_sql = "SELECT DISTINCT user_id as ID FROM `{$wpdb->prefix}usermeta` WHERE `meta_key`='dna_history' AND `meta_value`='1'";

    $my_clients_history = $wpdb->get_results($my_clients_history_sql . $limit);

    $sql_posts_total = $wpdb->get_results($my_clients_history_sql);
    $sql_posts_total = count($sql_posts_total);

    $max_num_pages = ceil($sql_posts_total / $post_per_page);

    include 'templates/manager/client_dna_list.php';

    $output = ob_get_contents();
    ob_end_clean();

    return  $output;
}
add_shortcode('clients_dna_list', 'dna_lists');

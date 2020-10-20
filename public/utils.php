<?php

if (!defined('WPINC')) {
    die;
}

/// @ h4h_update_client_profile client.php
function assign_client_to_manager($client_id)
{
    global $wpdb;
    $current_user = wp_get_current_user();
    $manager_id = $current_user->ID;

    $sql = "INSERT INTO `{$wpdb->prefix}wpc_client_objects_assigns`(`object_type`, `object_id`, 
    `assign_type`, `assign_id`) 
    VALUES ('manager','$manager_id','client',$client_id)";

    $wpdb->insert("{$wpdb->prefix}wpc_client_objects_assigns", array(
        "object_type" => 'manager',
        "object_id" => $manager_id,
        "assign_type" => 'client',
        "assign_id" => $client_id,
    ));
}

/// @client_form_answers.php
function generate_answer_html($field_options, $type, $field_id, $answer_id)
{
    global $wpdb;

    //get the answer
    $sql = "SELECT answer FROM `{$wpdb->prefix}wpc_frmw_answer_meta`
    WHERE field_id='$field_id' AND answer_id='$answer_id'";

    $ans = $wpdb->get_row($sql);
    $answer = isset($ans->answer) ? $ans->answer : "";

    if ($type == "checkbox" || $type == "radio") {
        $field_options = json_decode($field_options);

        //  print_r($field_options);
        return isset($field_options->values->$answer->label) ? $field_options->values->$answer->label : "NO ANSWER";
        //print_r($field_options->values->$val->label);     
    } else {
        return $answer;
    }
}

/// @client_form_answers.php
function get_form_title($id)
{
    global $wpdb;

    $sql = "SELECT * FROM `{$wpdb->prefix}wpc_frmw_forms` WHERE id='$id'";
    $form = $wpdb->get_row($sql);
    return $form->title;
}

/// @client_profile.php
function get_counsellors()
{
    $args = array(
        'role' => 'wpc_client_staff',
        'orderby' => 'user_nicename',
        'order' => 'ASC'
    );
    return get_users($args);
}

/// @client_profile.php
function get_counsellors_to_clients()
{
    $args = array(
        'role__in' => ['wpc_client_staff', 'wpc_manager'],
        'orderby' => 'user_nicename',
        'order' => 'ASC'
    );
    return get_users($args);
}

/// @clients.php
/// @reports.php
function count_client_status($status, $user_id)
{
    global $wpdb;
    $where = "";
    if ($status !== '') {
        $where = "WHERE (um.meta_key='wpc_cf_status' AND um.meta_value = '$status')";
    }

    //WHERE `object_id`= '$user_id' and `assign_type`='client' AND `assign_id` IN( :(FILTER BY MANAGER ID [`object_id`= '$manager_id']):
    if (current_user_can('wpc_manager'))
        $sql_filter_clients = "SELECT  COUNT(DISTINCT `assign_id`) as total
        FROM `{$wpdb->prefix}wpc_client_objects_assigns` oa
        LEFT JOIN wp_usermeta um ON oa.assign_id = um.user_id
        WHERE  `assign_type`='client' 
        AND um.meta_key='wp_capabilities' and um.meta_value like '%wpc_client%'
        AND `assign_id` IN(
            SELECT DISTINCT ID FROM `{$wpdb->prefix}users` u
            LEFT JOIN `{$wpdb->prefix}usermeta` um ON u.ID = um.user_id
            $where
        )  AND `assign_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )";
    else
        $sql_filter_clients = "SELECT COUNT( DISTINCT um.user_id) as total
        FROM `wp_usermeta` um1
        LEFT JOIN  `wp_usermeta` um ON um1.`user_id`=um.`user_id`
        $where
        AND (um1.`meta_key`='wpc_cf_counsellor' AND um1.`meta_value`='$user_id')  
        AND um1.`user_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )
        ";


    $clients = $wpdb->get_row($sql_filter_clients);
    return $clients->total;
}


/// @client_list.php
/// @client.php client_profile
function get_statuses_for_clients()
{
    $wpclient_option = get_option('wpc_custom_fields');
    return $wpclient_option['wpc_cf_status']['options'];
}

/// @counsellor_clients_list.php
/// @my_profile.php
function get_counsellor_name($id)
{
    $user = get_user_by('ID', $id);
    $fname =  isset($user->first_name) ? $user->first_name : "-";
    $lname =  isset($user->last_name) ? $user->last_name : "-";
    return  $fname . ' ' . $lname;
}

/// @reports.php
function get_client_name($id)
{
    $user = get_user_by('ID', $id);
    $fname =  isset($user->first_name) ? $user->first_name : "-";
    $lname =  isset($user->last_name) ? $user->last_name : "-";
    return  $fname . ' ' . $lname;
}

/// @risk_report.php
function get_user_name($id)
{
    $user = get_user_by('ID', $id);
    $fname =  isset($user->first_name) ? $user->first_name : "-";
    $lname =  isset($user->last_name) ? $user->last_name : "-";
    return  $fname . ' ' . $lname;
}

/// @counsellor_clients_list.php
function count_counsellor_client($counsellor_id)
{
    global $wpdb;

    $counsellor_id = intval($counsellor_id);

    $sql = "SELECT COUNT(user_id) AS total 
    FROM `{$wpdb->prefix}usermeta` 
    WHERE `meta_key`='wpc_cf_counsellor' AND `meta_value`='$counsellor_id' 
    AND `user_id` NOT IN ( SELECT DISTINCT `user_id` FROM {$wpdb->prefix}usermeta WHERE meta_key='archive' AND meta_value='1' )";

    $clients = $wpdb->get_row($sql);
    return $clients->total;
}

/// @client_forms.php
/// @hooks.php
function client_answered_form($client_id, $form_id)
{
    global $wpdb;
    $sql = "SELECT COUNT(id) AS total, id FROM `{$wpdb->prefix}wpc_frmw_answers` 
        WHERE `user_id`='$client_id' AND `form_id`= '$form_id' ";
    $answered = $wpdb->get_row($sql);
    return $answered;
}


/// @counsellor/client_forms.php 
/// @hooks.php
function check_form_assigned($client_id, $form_id)
{
    global $wpdb;
    $sql = "SELECT COUNT(id) AS total FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
        WHERE `object_type`='form' AND `object_id`='$form_id' AND `assign_type` = 'client' AND `assign_id`= '$client_id' ";
    $form = $wpdb->get_row($sql);
    return $form;
}


/// @manager/client_form_answers.php 
function compute_score_core_om($letter)
{
    //$P = array(1, 4, 7, 10, 12, 14, 17, 19, 22, 26, 27, 29);

    $_total = array_sum($letter);
    $_count  = count($letter);


    return array('total' => $_total, 'count' => $_count);
}

/// @donation/donation_list.php 
function array_to_csv_download($fileName, $assocDataArray, $fields, $header)
{
    ob_clean();
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $fileName);
    if (isset($assocDataArray['0'])) {
        $fp = fopen('php://output', 'w');
        fputcsv($fp, $header);
        foreach ($assocDataArray as $values) {
            $csvrow = array();
            foreach ($fields as $field) {
                $csvrow[] = trim(preg_replace('/\s+/', ' ', $values[$field]));
            }

            fputcsv($fp, $csvrow);
        }
        fclose($fp);
    }
    ob_flush();
}

/// templates/manager/counsellor_client_notes.php 
function get_client_note_files($note_id)
{
    global $wpdb;

    $note_id = intval($note_id);

    //  $sql = "SELECT post_id FROM `{$wpdb->prefix}postmeta` WHERE `meta_key`='note_id' AND `meta_value`='$note_id'";

    $sql = "SELECT pm.post_id, p.post_title, pm1.meta_value as file
    FROM `{$wpdb->prefix}postmeta` pm
    LEFT JOIN `{$wpdb->prefix}posts` p ON pm.post_id = p.ID
    LEFT JOIN `{$wpdb->prefix}postmeta` pm1 ON pm.post_id = pm1.post_id AND  pm1.`meta_key`='_wp_attached_file'
    WHERE pm.`meta_key`='note_id' AND pm.`meta_value`='$note_id' AND p.post_type='attachment'";


    return $wpdb->get_results($sql);
}

///hooks.php check_status()
function  check_client_anwered_forms($ID, $forms)
{
    global $wpdb;

    $note_id = intval($ID);

    $where = "'" . implode("', '", $forms) . "'";

    $sql = "SELECT COUNT(id) as total 
    FROM `{$wpdb->prefix}wpc_frmw_answers` 
    WHERE `user_id`='$ID' AND form_id IN ($where)";

    return $wpdb->get_row($sql)->total;
}


///hooks.php access_control()
function check_client_core_om($client_id, $form_id)
{
    global $wpdb;

    $client_id = intval(esc_attr($client_id));
    $form_id = intval(esc_attr($form_id));

    $sql = "SELECT id FROM `wp_wpc_frmw_answers` WHERE `user_id`='$client_id' and `form_id`='$form_id'";

    return isset($wpdb->get_row($sql)->id) ? $wpdb->get_row($sql)->id : "";
}


///hooks.php access_control()
function calculate_core_om($form_id, $answer_id, $client_id)
{

    global $wpdb;

    $form_id = intval(esc_attr($form_id));
    $answer_id = intval(esc_attr($answer_id));
    $client_id = intval(esc_attr($client_id));

    $core_om_answer = array(); //stores the answer for calucalation of core om

    $core_letters = ['F', 'P', 'F', 'W', 'P', 'R', 'F', 'P', 'R', 'F', 'P', 'F', 'P', 'W', 'P', 'R', 'W', 'P', 'F', 'P', 'F', 'R', 'P', 'R', 'F', 'F', 'P', 'P', 'F', 'P', 'W', 'F', 'F', 'R']; //do not alter. this Letters corresponds on core om field.


    $options = array('Not at all', 'Only occasionally', 'Sometimes', 'Often', 'Most or all the time');

    $inverted_options  = array('Most or all the time', 'Often', 'Sometimes', 'Only occasionally', 'Not at all');


    $fields_inverted_values = array(2, 3, 6, 11, 18, 20, 30, 31); //Values of these fields are inverted (4-0)

    $sql = "SELECT a.id, a.user_id, a.form_id, a.user_id, am.field_id, 
    am.answer, ff.label, ff.field_options, ff.deleted, ff.type 
    FROM `{$wpdb->prefix}wpc_frmw_answers` a
    LEFT JOIN `{$wpdb->prefix}wpc_frmw_answer_meta` am ON a.id = am.`answer_id`
    LEFT JOIN `{$wpdb->prefix}wpc_frmw_fields` ff ON am.field_id = ff.`id`
    WHERE a.`form_id`='%d' and a.`id`='%d' and `user_id`='%d'";

    $sql = $wpdb->prepare($sql, $form_id, $answer_id, $client_id);


    $fields = $wpdb->get_results($sql);


    foreach ($fields as  $key => $field) :

        if ($field->label !== "") :
            $answer = generate_answer_html($field->field_options, $field->type, $field->field_id, $answer_id);
            $let = $core_letters[$key];

            $let = $core_letters[$key];

            if ($answer !== 'NO ANSWER') {

                if (in_array($key, $fields_inverted_values))
                    $ans = array_search($answer, $inverted_options, true);
                else
                    $ans = array_search($answer, $options, true);

                $core_om_answer[] = array($let => $ans);
            }


        endif;

    endforeach;


    foreach ($core_om_answer as  $key => $answer) {

        if (isset($answer['F'])) $F[] = $answer['F'];
        if (isset($answer['P'])) $P[] = $answer['P'];
        if (isset($answer['W'])) $W[] = $answer['W'];
        if (isset($answer['R'])) $R[] = $answer['R'];
    }


    $F = compute_score_core_om($F);
    $P = compute_score_core_om($P);
    $W = compute_score_core_om($W);
    $R = compute_score_core_om($R);

    $F_mean = round($F['total'] / $F['count'] * 10, 2);
    $P_mean = round($P['total'] / $P['count'] * 10, 2);
    $W_mean = round($W['total'] / $W['count'] * 10, 2);
    $R_mean = round($R['total'] / $R['count'] * 10, 2);


    $total_items = $W['total'] +  $P['total'] + $F['total'] + $R['total'];
    $total_count = $W['count'] + $P['count'] + $F['count'] + $R['count'];

    $total_minus_R = $W['total'] +  $P['total'] + $F['total'];
    $total_count_minus_r = $W['count'] + $P['count'] + $F['count'];


    $value['clinical_score'] = round($total_items / $total_count * 10, 2);
    $value['clinical_risk_score'] = $R_mean;
    $value['clinical_non_risk_score'] = round($total_minus_R / $total_count_minus_r * 10, 2);
    $value['clinical_well_being_score'] = $W_mean;
    $value['clinical_problem_score '] = $P_mean;
    $value['clinical_function_score '] = $F_mean;

    return $value;
}

function count_dna_total($client_id)
{
    global $wpdb;

    $client_id = intval($client_id);

    $sql = "SELECT SUM(dna) as total FROM `{$wpdb->prefix}wpc_bh_client_notes` WHERE `client_id`='$client_id' ";
    //  SELECT FROM `wp_wpc_bh_client_notes` WHERE client_id='43'

    return $wpdb->get_row($sql)->total;
}


//****Shortcodes */
function breadcrumbs()
{
    ob_start();
    $html = '<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">';

    if (function_exists('bcn_display')) {
        $html .= bcn_display();
    }
    $html .= '</div>';

    $html = ob_get_contents();
    ob_end_clean();

    return  $html;
}
add_shortcode('breadcrumbs', 'breadcrumbs');




function client_profile_title()
{
    ob_start();
    $client = isset($_REQUEST['client']) ? $_REQUEST['client'] : "";
    if ($client == '') {
        echo '<h2>Add new client</h2>';
        echo '<style>#profile .et_pb_tabs_controls li{ display: none !important;} #profile .et_pb_tabs_controls li.et_pb_tab_active{ display: block !important;}</style>'; //for hiding other tabs when adding a client
    } else {
        echo  $html = '<h2>Client: <span style="font-weight: 100;">' . get_user_meta(esc_attr($client), 'first_name', true) . ' ' . get_user_meta($client, 'last_name', true) . '</span></h2>';
    }

    $html = ob_get_contents();
    ob_end_clean();

    return  $html;
}
add_shortcode('client_profile_title', 'client_profile_title');

function counsellor_profile_title()
{
    ob_start();
    $counsellor = isset($_REQUEST['counsellor']) ? $_REQUEST['counsellor'] : "";
    if ($counsellor == '')
        echo '<h2></h2>';
    else
        echo  $html = '<h2>Counsellor: <span style="font-weight: 100;">' . get_user_meta(esc_attr($counsellor), 'first_name', true) . ' ' . get_user_meta($counsellor, 'last_name', true) . '</span></h2>';


    $html = ob_get_contents();
    ob_end_clean();

    return  $html;
}
add_shortcode('counsellor_profile_title', 'counsellor_profile_title');


function current_user_display_name()
{
    ob_start();
    $current_user = wp_get_current_user();
    echo $current_user->display_name;
    $html = ob_get_contents();
    ob_end_clean();

    return  $html;
}

add_shortcode('logged_display_name', 'current_user_display_name');


function wpse12535_redirect_sample()
{

    if (is_page('client')) {
        exit(wp_redirect('/client/my-profile/'));
    }

    if (is_page('counsellor')) {
        exit(wp_redirect('/counsellor/my-profile/'));
    }

    if (is_page('manager')) {
        exit(wp_redirect('/manager/my-profile/'));
    }
}

add_action('template_redirect', 'wpse12535_redirect_sample');

<?php

if (!defined('WPINC')) {
    die;
}


///ajax get_note
function get_note()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "editnote")) {
        wp_send_json_success("Error");
        exit;
    }

    global $wpdb;
    $id = intval($_REQUEST['note']);
    $sql = "SELECT * FROM `{$wpdb->prefix}wpc_bh_client_notes` WHERE id='$id'";
    $res = $wpdb->get_row($sql);
    $note = htmlspecialchars_decode(stripslashes(nl2br($res->note)));
    $res->note = $note;

    $uploads = wp_upload_dir();

    $file_html_image = "";
    $file_html_doc = "";

    $note_files = get_client_note_files($id);

    if (count($note_files) > 0) {
        foreach ($note_files  as $file) {

            if ($_REQUEST['view'] == 'true')
                $remove_file_html = '';
            else
                $remove_file_html = '(<a class="note-remove-file" data-file=' . $file->post_id . ' href="#">remove</a>)';

            $path = $file->file;
            $file_dir = explode("/", $file->file);
            $ext = pathinfo(end($file_dir), PATHINFO_EXTENSION);

            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif') {
                $file_html_image .= '<div class="mr-1 item"><a class="swipebox" rel="swipebox1" href="/wp-content/uploads/' . $file->file . '"><img src="' .  $uploads['baseurl'] . '/' . $file->file   . '" width="75px"></a><br>' . $remove_file_html . '</div>';
                /* } else if ($ext == 'doc' || $ext == 'docx' || $ext == 'docm' || $ext == 'dotm' || $ext == 'dotx') {
                $file_html_doc .= '<li><a target="_blank" href="https://docs.google.com/viewerng/viewer?url=' . home_url() . '/wp-content/uploads/' . $file->file . '&hl=en">' . $file->post_title   . '' . $key . '</a> ' . $remove_file_html . '</li>';
                */
            } else {
                $file_html_doc .= '<li><a target="_blank" href="/wp-content/uploads/' . $file->file . '">' . $file->post_title   . '' . $key . '</a> ' . $remove_file_html . '</li>';
            }
        }

        $file_html = '<div class="mt-2">';
        $file_html .= '<div class="mb-1 d-inline-flex">';
        $file_html .= $file_html_image;
        $file_html .= '</div>';

        $file_html .= '<ul>';
        $file_html .= $file_html_doc;
        $file_html .= '</ul>';

        $file_html .= '</div>';
    } else {
        $file_html = '<div class="mt-2">';
        $file_html .= 'No files attached.';
        $file_html .= '</div>';
    }



    // $res = (array) $res;
    //$res['file'] = $file_html;
    //$res = (object) $res;

    $res->files = $file_html;

    wp_send_json_success($res, JSON_PRETTY_PRINT);
}
add_action('wp_ajax_get_note', 'get_note');


///ajax delete note
function delete_note()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "editnote")) {
        wp_send_json_success("Error");
        exit;
    }

    global $wpdb;
    $id = esc_attr($_REQUEST['note']);


    $sql = $wpdb->prepare("DELETE FROM `{$wpdb->prefix}wpc_bh_client_notes` WHERE id='%d'", $id);

    foreach (get_client_note_files($id) as $file) {
        wp_delete_attachment($file->post_id, true);
    }

    $wpdb->query($sql);
}
add_action('wp_ajax_delete_note', 'delete_note');


//ajax assign form to client
function assign_form()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "assignform")) {
        wp_send_json_success("Error");
        exit;
    }

    global $wpdb;
    $current_user = wp_get_current_user();


    $wpdb->insert("{$wpdb->prefix}wpc_client_objects_assigns", array(
        "object_type" => 'form',
        "object_id" => esc_attr($_REQUEST['form']),
        "assign_type" => 'client',
        "assign_id" => esc_attr($_REQUEST['client']),
    ));

    $client_data = get_userdata($_REQUEST['client']);

    $msg = "
    Hi,<br><br>
    
    There is a form assigned to you. Please check on the dashboard https://admin.healingfortheheart.co.uk.
        <br><br>
    Thank you.
    ";

    h4h_mail($client_data->user_email,   $current_user->user_email, 'New form assigned to you', $msg, 'Notification');
}
add_action('wp_ajax_assign_form', 'assign_form');


//ajax unassign_form form to client
function unassign_form()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "unassignform")) {
        wp_send_json_success("Error1", $_REQUEST['nonce']);
        exit;
    }

    global $wpdb;

    $form = esc_attr($_REQUEST['form']);
    $client = esc_attr($_REQUEST['client']);

    /* $sql = "DELETE FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
    WHERE `object_type`='form' AND `object_id`='$form' 
    AND `assign_type`='client' AND `assign_id`= '$client' ";*/

    $sql = $wpdb->prepare("DELETE FROM `{$wpdb->prefix}wpc_client_objects_assigns` 
     WHERE `object_type`='form' AND `object_id`='%d' 
     AND `assign_type`='client' AND `assign_id`= '%d'", $form, $client);

    $wpdb->query($sql);
}
add_action('wp_ajax_unassign_form', 'unassign_form');



///ajax get_donation
function get_donation()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "editdonation" . $_REQUEST['donation'])) {
        wp_send_json_success("Error");
        exit;
    }

    global $wpdb;
    $id = esc_attr($_REQUEST['donation']);
    $sql = "SELECT * FROM `{$wpdb->prefix}wpc_bh_client_donations` WHERE id='$id'";
    $res = $wpdb->get_row($sql);
    // $res->note = htmlspecialchars_decode(stripslashes($res->note));
    $note = htmlspecialchars_decode(stripslashes(nl2br($res->note)));
    $res->note = $note;

    wp_send_json_success($res);
}
add_action('wp_ajax_get_donation', 'get_donation');



///ajax delete donation
function delete_donation()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "deletedonation" . $_REQUEST['donation'])) {
        wp_send_json_success("Error");
        exit;
    }

    global $wpdb;
    $id = esc_attr($_REQUEST['donation']);


    $sql = $wpdb->prepare("DELETE FROM `{$wpdb->prefix}wpc_bh_client_donations` WHERE id='%d'", $id);

    $wpdb->query($sql);
}
add_action('wp_ajax_delete_donation', 'delete_donation');


///ajax get risk report
function get_risk_report()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "edit_risk_report" . $_REQUEST['risk_report'])) {
        wp_send_json_success("Error");
        exit;
    }

    global $wpdb;
    $id = esc_attr($_REQUEST['risk_report']);

    $sql = "SELECT umeta_id as id, meta_value as risk_report FROM `{$wpdb->prefix}usermeta` WHERE umeta_id='$id' and `meta_key`='wpc_cf_risk_report'";
    $res = $wpdb->get_row($sql);
    $res->risk_report = unserialize($res->risk_report);
    wp_send_json_success($res);
}
add_action('wp_ajax_get_risk_report', 'get_risk_report');


///ajax delete risk report
function delete_risk_report()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "deleterisk_report" . $_REQUEST['risk_report'])) {
        wp_send_json_success("Error");
        exit;
    }

    global $wpdb;
    $id = esc_attr($_REQUEST['risk_report']);


    $sql = $wpdb->prepare("DELETE FROM `{$wpdb->prefix}usermeta` WHERE umeta_id='%d'", $id);

    $wpdb->query($sql);
}
add_action('wp_ajax_delete_risk_report', 'delete_risk_report');



//******AJAX FOR UPLOAD MEDIA****//

add_action('wp_ajax_handle_dropped_media', 'handle_dropped_media');

function handle_dropped_media()
{
    global $wpdb;

    $current_user = wp_get_current_user();
    $ID = $current_user->ID;

    status_header(200);

    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['path'] . DIRECTORY_SEPARATOR;
    $num_files = count($_FILES['file']['tmp_name']);

    $newupload = 0;

    if (!empty($_FILES)) {

        if ($_POST['note'] == '') {

            $wpdb->insert("{$wpdb->prefix}wpc_bh_client_notes", array(
                "client_id" => esc_attr($_POST['client']),
                "by_user_id" => $ID,
                "session_date" => '',
                "note" => '',
                "status" => 'draft',
            ));
            $lastid = $wpdb->insert_id;
        } else {
            $lastid = intval($_POST['note']);
        }

        $files = $_FILES;
        foreach ($files as $file) {
            $newfile = array(
                'name' => $file['name'],
                'type' => $file['type'],
                'tmp_name' => $file['tmp_name'],
                'error' => $file['error'],
                'size' => $file['size']
            );

            $_FILES = array('upload' => $newfile);
            foreach ($_FILES as $file => $array) {
                $newupload = media_handle_upload($file, 0);
                wp_set_object_terms($newupload, array(9), 'media_category'); //9 is the "client notes" media category
                add_post_meta($newupload, 'note_id', $lastid);
            }
        }
    }
    wp_send_json_success(array('media' => $newupload, 'note' => $lastid, 'client' => $_POST['client'], 'noteOld' => $_POST['note']));
    //echo $newupload;
    die();
}

add_action('wp_ajax_deleted_media', 'handle_deleted_media');

function handle_deleted_media()
{

    if (isset($_REQUEST['media_id'])) {
        $post_id = absint($_REQUEST['media_id']);

        $status = wp_delete_attachment($post_id, true);

        if ($status)
            echo json_encode(array('status' => 'OK'));
        else
            echo json_encode(array('status' => 'FAILED'));
    }

    die();
}

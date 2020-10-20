<?php

if (!defined('WPINC')) {
    die;
}

//// POST REQUEST

remove_action('wp_loaded', 'h4h_update_client_profile');
add_action('wp_loaded', 'h4h_posts');
function h4h_posts()
{



    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && isset($_POST['curent_page']) && $_POST['curent_page'] !== null) {

        $curent_page = $_POST['curent_page'];

        $current_user = wp_get_current_user();
        $ID  = $current_user->ID;


        switch ($_POST['action']) {
            case 'update':
                $client_id = intval($_POST['client']);

                $redirect = "&updated=true";

                update_user_meta($client_id, 'first_name', esc_sql($_POST['first_name']));
                update_user_meta($client_id, 'last_name', esc_sql($_POST['last_name']));
                update_user_meta($client_id, '_wpc_mobile_number', esc_sql($_POST['_wpc_mobile_number']));
                update_user_meta($client_id, 'wpc_cf_status', esc_sql($_POST['wpc_cf_status']));
                update_user_meta($client_id, 'wpc_cf_phone_number', esc_sql($_POST['wpc_cf_phone_number']));
                update_user_meta($client_id, 'description', esc_attr($_POST['description']));
                update_user_meta($client_id, 'wpc_cf_first_appointment', esc_sql($_POST['_first_appointment']));

                //update_user_meta($client_id, 'wpc_cf_counsellor', $_POST['wpc_cf_counsellor']);

                update_user_meta($client_id, 'date_of_birth', esc_sql($_POST['date_of_birth']));

                update_user_meta($client_id, 'address_1', esc_sql($_POST['address_1']));
                update_user_meta($client_id, 'address_2', esc_sql($_POST['address_2']));
                update_user_meta($client_id, 'town', esc_sql($_POST['town']));
                update_user_meta($client_id, 'post_code', esc_sql($_POST['post_code']));


                update_user_meta($client_id, 'kin_name', esc_sql($_POST['kin_name']));
                update_user_meta($client_id, 'kin_email', esc_sql($_POST['kin_email']));
                update_user_meta($client_id, 'kin_phone', esc_sql($_POST['kin_phone']));


                update_user_meta($client_id, 'gp_name', esc_sql($_POST['gp_name']));
                update_user_meta($client_id, 'gp_email', esc_sql($_POST['gp_email']));
                update_user_meta($client_id, 'gp_phone', esc_sql($_POST['gp_phone']));


                update_user_meta($client_id, 'gp_surgery_name', esc_sql($_POST['gp_surgery_name']));
                update_user_meta($client_id, 'gp_surgery_address', esc_sql($_POST['gp_surgery_address']));
                update_user_meta($client_id, 'gp_surgery_town', esc_sql($_POST['gp_surgery_town']));
                update_user_meta($client_id, 'gp_surgery_postcode', esc_sql($_POST['gp_surgery_postcode']));


                $client = get_userdata($client_id);
                if (esc_attr($_POST['user_email']) ===  $client->user_email) {
                    $args = array(
                        'ID' => $client_id,
                        'display_name' => esc_sql($_POST['first_name'] . " " . $_POST['last_name'])
                    );
                } else {

                    if (!email_exists($_POST['user_email'])) {
                        $args = array(
                            'ID' => $client_id,
                            'user_email' => esc_sql($_POST['user_email']),
                            'display_name' => esc_sql($_POST['first_name'] . " " . $_POST['last_name'])
                        );
                    } else {
                        $redirect = "&err=2";
                    }
                }

                wp_update_user($args);

                /* $args = array(
                    'ID'         => $client_id,
                    'user_email' => esc_attr($_POST['user_email'])
                );
                wp_update_user($args);*/

                $counsellor = get_user_meta($client_id, 'wpc_cf_counsellor', true);
                if (isset($_POST['wpc_cf_counsellor']) && $counsellor !== $_POST['wpc_cf_counsellor']) {

                    $counsellor = get_userdata(esc_sql($_POST['wpc_cf_counsellor']));

                    update_user_meta($client_id, 'wpc_cf_counsellor', $_POST['wpc_cf_counsellor']);
                    //  update_user_meta($client_id, 'wpc_cf_status', 'In Sessions');

                    if (isset($counsellor->user_email)) {

                        $current_user = wp_get_current_user();
                        $current_email = $current_user->user_email;
                        $msg = "
                        Hi,<br>
                        <br>
                        You have a new client. Please check on the dashboard https://admin.healingfortheheart.co.uk.
                        <br><br>
                        Thank you.
                        ";

                        h4h_mail($counsellor->user_email, $current_email, 'New Client Assignment', $msg, 'NOTIFICATION');
                    }
                }



                wp_redirect($curent_page . $redirect);
                exit();

                break;

            case "add":
                $current_user = wp_get_current_user();
                $email = $current_user->user_email;

                //$headers = array("From: Healing for the Heart <$email>", "Content-Type: text/html; charset=UTF-8");
                // wp_mail('winnard@butteredhost.com', 'Account', 'Test', $headers);
                //  wp_mail('casiplewinnard@gmail.com', 'Account', $msg, $headers);
                if (isset($_POST['user_email']) && $_POST['user_email'] !== '') {

                    if (!username_exists($_POST['user_email']) and  !email_exists($_POST['user_email'])) {
                        $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                        $new_user = array(
                            'user_pass' => $random_password,
                            'user_login' => esc_sql($_POST['user_email']),
                            'user_email' => esc_sql($_POST['user_email']),
                            'display_name' => esc_sql($_POST['first_name'] . " " . $_POST['last_name']),
                            'first_name' => esc_sql($_POST['first_name']),
                            'last_name' => esc_sql($_POST['last_name']),
                            'role' => 'wpc_client',
                        );

                        $new_user_id = wp_insert_user($new_user);

                        update_user_meta($new_user_id, '_wpc_mobile_number', esc_sql($_POST['_wpc_mobile_number']));
                        update_user_meta($new_user_id, 'wpc_cf_phone_number', esc_sql($_POST['wpc_cf_phone_number']));
                        update_user_meta($new_user_id, 'wpc_cf_status', esc_sql($_POST['wpc_cf_status']));
                        update_user_meta($new_user_id, 'wpc_cf_counsellor', esc_sql($_POST['wpc_cf_counsellor']));
                        update_user_meta($new_user_id, 'description', esc_attr($_POST['description']));
                        update_user_meta($new_user_id, 'wpc_cf_first_appointment', esc_sql($_POST['_first_appointment']));

                        add_user_meta($new_user_id, 'date_of_birth', esc_sql($_POST['date_of_birth']));

                        add_user_meta($new_user_id, 'address_1', esc_sql($_POST['address_1']));
                        add_user_meta($new_user_id, 'address_2', esc_sql($_POST['address_2']));
                        add_user_meta($new_user_id, 'town', esc_sql($_POST['town']));
                        add_user_meta($new_user_id, 'post_code', esc_sql($_POST['post_code']));


                        add_user_meta($new_user_id, 'kin_name', esc_sql($_POST['kin_name']));
                        add_user_meta($new_user_id, 'kin_email', esc_sql($_POST['kin_email']));
                        add_user_meta($new_user_id, 'kin_phone', esc_sql($_POST['kin_phone']));


                        add_user_meta($new_user_id, 'gp_name', esc_sql($_POST['gp_name']));
                        add_user_meta($new_user_id, 'gp_email', esc_sql($_POST['gp_email']));
                        add_user_meta($new_user_id, 'gp_phone', esc_sql($_POST['gp_phone']));


                        $msg = "                
                        Hi,<br>
                        <br>
                        Your account has been created. See details below:<br>
                        Username: " . $_POST['user_email'] . "<br>
                        Temporary Password: $random_password<br>
                        First Appoinment: " . $_POST['_first_appointment'] . "<br>
                        Login link: https://admin.healingfortheheart.co.uk/<br>
                        <br>  
                        ";

                        //h4h_mail($_POST['user_email'], $email, 'New Account', $msg, 'WELCOME');
                        //wp_mail($_POST['user_email'], 'info@healingfortheheart.co.uk', 'New Account', $msg);
                        h4h_mail($_POST['user_email'], 'info@healingfortheheart.co.uk', 'New Account', $msg, 'WELCOME');

                        assign_client_to_manager($new_user_id);




                        wp_redirect($curent_page . "$new_user_id&added=true");
                        exit();
                    } else {
                        $fname = $_POST['first_name'];
                        $lname = $_POST['last_name'];
                        $mob = $_POST['_wpc_mobile_number'];
                        $phone = $_POST['wpc_cf_phone_number'];
                        $aboutme = $_POST['description'];
                        $first_appointment = $_POST['_first_appointment'];
                        $addres_1 = $_POST['address_1'];
                        $addres_2 = $_POST['address_2'];
                        $town = $_POST['town'];
                        $post_code = $_POST['post_code'];
                        $date_of_birth = $_POST['date_of_birth'];
                        $kin_name = $_POST['kin_name'];
                        $kin_email = $_POST['kin_email'];
                        $kin_phone = $_POST['kin_phone'];
                        $gp_name = $_POST['gp_name'];
                        $gp_email = $_POST['gp_email'];
                        $gp_phone = $_POST['gp_phone'];




                        $values = "&fname=$fname&lname=$lname&mob=$mob&phone=$phone&about=$aboutme&appointment=$first_appointment&address1=$addres_1&address2=$addres_2&town=$town&post_code=$post_code";
                        $values .= "&date_of_birth=$date_of_birth&kin_name=$kin_name&kin_email=$kin_email&kin_phone=$kin_phone&gp_name=$gp_name&gp_email=$gp_email&gp_phone=$gp_phone";
                        wp_redirect($curent_page . "&err=2" . $values);
                        exit();
                    }
                }

                break;

            case 'update_my_profile':

                //$ID = intval($_POST['my_profile']);
                $current_user = wp_get_current_user();
                $ID  = $current_user->ID;

                $redirect = "?updated=true";

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
                        update_user_meta($ID, 'first_name', esc_sql($_POST['first_name']));
                        update_user_meta($ID, 'last_name', esc_sql($_POST['last_name']));
                        update_user_meta($ID, '_wpc_mobile_number', $_POST['wpc_mobile_number']);
                        update_user_meta($ID, 'description', esc_attr($_POST['description']));

                        if (current_user_can('wpc_client_staff')) : //for counsellor availability and if student or not

                            $availability = array();
                            foreach ($_POST['day'] as $day) {
                                $availability[esc_sql($day)] = esc_sql($_POST[$day]);
                            }

                            $have_availabity = get_user_meta($ID, 'wpc_cf_availability_day', false);

                            if ($have_availabity) {
                                update_user_meta($ID, 'wpc_cf_availability_day', $availability);
                                update_user_meta($ID, 'wpc_cf_student', esc_sql($_POST['student']));
                            } else {
                                add_user_meta($ID, 'wpc_cf_availability_day', $availability);
                                add_user_meta($ID, 'wpc_cf_student', esc_sql($_POST['student']));
                            }



                        endif;

                        update_user_meta($ID, 'address_1', esc_sql($_POST['address_1']));
                        update_user_meta($ID, 'address_2', esc_sql($_POST['address_2']));
                        update_user_meta($ID, 'town', esc_sql($_POST['town']));
                        update_user_meta($ID, 'post_code', esc_sql($_POST['post_code']));


                        update_user_meta($ID, 'kin_name', esc_sql($_POST['kin_name']));
                        update_user_meta($ID, 'kin_email', esc_sql($_POST['kin_email']));
                        update_user_meta($ID, 'kin_phone', esc_sql($_POST['kin_phone']));

                        update_user_meta($ID, 'gp_name', esc_sql($_POST['gp_name']));
                        update_user_meta($ID, 'gp_email', esc_sql($_POST['gp_email']));
                        update_user_meta($ID, 'gp_phone', esc_sql($_POST['gp_phone']));



                        // $my_phone = get_user_meta($ID, '_wpc_phone_number', true);
                        //$my_phone = empty($my_phone) ? 'empty' : $my_phone;

                        //if ($my_phone === 'empty') {
                        delete_user_meta($ID, 'wpc_cf_phone_number');
                        add_user_meta($ID, 'wpc_cf_phone_number', esc_sql($_POST['wpc_phone_number']));
                        //} else {
                        //update_user_meta($ID, '_wpc_phone_number', $_POST['wpc_phone_number']);
                        //}

                        //no email changes


                        if (esc_attr($_POST['user_email']) ===  $current_user->user_email) {

                            $args = array(
                                'ID' => $ID,
                                'display_name' => esc_sql($_POST['first_name'] . " " . $_POST['last_name'])
                            );
                        } else {

                            if (!email_exists($_POST['user_email'])) {
                                $args = array(
                                    'ID' => $ID,
                                    'user_email' => esc_sql($_POST['user_email']),
                                    'display_name' => esc_sql($_POST['first_name'] . " " . $_POST['last_name'])
                                );
                            } else {
                                $redirect = "?err=2";
                            }
                        }

                        wp_update_user($args);


                        wp_redirect($curent_page . $redirect);
                        exit();
                    }
                }

                break;

            case 'add_client_notes':
                global $wpdb;



                $wpdb->insert("{$wpdb->prefix}wpc_bh_client_notes", array(
                    "client_id" => esc_sql($_POST['client']),
                    "by_user_id" => $ID,
                    "session_date" => esc_sql($_POST['session_date']),
                    "dna" => esc_sql($_POST['dna']),
                    "note" => esc_attr($_POST['note']),
                ));

                if ($_POST['dna'] == 1) {
                    update_user_meta(esc_sql($_POST['client']), 'dna_status', "1");
                    update_user_meta(esc_sql($_POST['client']), 'dna_history', "1");

                    $msg =  "                
                    Hi,<br>
                    <br>
                    " . get_counsellor_name($ID) . "'s client did not attend on " . esc_sql($_POST['session_date']) . ".   Please login to review the DNA list
                    <br>  
                    ";


                    h4h_mail('admin@healingfortheheart.co.uk', 'info@healingfortheheart.co.uk', 'DNA(Did Not Attend)', $msg, 'NOTIFICATION');
                } else {
                    update_user_meta(esc_sql($_POST['client']), 'dna_status', "0");
                }



                wp_redirect($curent_page . "&addednote=true");
                exit();
                break;

            case 'update_client_notes':
                global $wpdb;



                $wpdb->update("{$wpdb->prefix}wpc_bh_client_notes", array(
                    "client_id" => esc_sql($_POST['client']),
                    "by_user_id" => $ID,
                    "session_date" => esc_sql($_POST['session_date']),
                    "note" => esc_attr($_POST['note']),
                    "status" => 'published',
                ), array('id' => esc_sql($_POST['thisnote'])));


                wp_redirect($curent_page . "&updatednote=true");
                exit();

                break;

            case 'add_donation':

                if (!wp_verify_nonce($_REQUEST['nonce'], "add_donation" . $_POST['client'])) {
                    wp_redirect($curent_page . "&error=true");
                    exit();
                }
                global $wpdb;

                $wpdb->insert("{$wpdb->prefix}wpc_bh_client_donations", array(
                    "client_id" => esc_sql($_POST['client']),
                    "by_user_id" => $ID,
                    "date" => esc_sql($_POST['donation_date']),
                    "amount" => esc_sql($_POST['donation_amount']),
                    "note" => esc_attr($_POST['note']),
                    "type" => esc_sql($_POST['type']),
                    "gift_aid" => esc_sql($_POST['gift_aid']),
                ));


                wp_redirect($curent_page . "&addednote=true");
                exit();

                break;

            case 'update_donation':

                if (!wp_verify_nonce($_REQUEST['nonce'], "update_donation" . $_POST['client'])) {
                    wp_redirect($curent_page . "&error=true");
                    exit();
                }

                global $wpdb;

                $wpdb->update("{$wpdb->prefix}wpc_bh_client_donations", array(
                    "date" => esc_sql($_POST['donation_date']),
                    "amount" => esc_sql($_POST['donation_amount']),
                    "note" => esc_attr($_POST['note']),
                    "type" => esc_sql($_POST['type']),
                    "gift_aid" => esc_sql($_POST['gift_aid']),
                ), array('id' => esc_sql($_POST['thisdonation'])));


                wp_redirect($curent_page . "&updatednote=true");
                exit();

                break;


            case 'download_donation_csv':

                if (!wp_verify_nonce($_POST['nonce'], "download_donation_csv")) {
                    wp_redirect($curent_page);
                    exit;
                }

                $filename = 'Donations.csv';

                $data = get_donations('ARRAY_A');

                $header = array('Added by', 'Client', 'Date', 'Amount', 'Type', 'Note', 'Gift Aud');
                $fields = array('addedby', 'client', 'date', 'amount', 'type', 'note', 'gift_aid');

                array_to_csv_download($filename, $data, $fields, $header);

                exit;


                break;

            case 'add_counsellor':

                if (!wp_verify_nonce($_POST['nonce'], "add_counsellor")) {
                    wp_redirect($curent_page);
                    exit;
                }

                $email = $current_user->user_email;


                $availability = array();
                foreach ($_POST['day'] as $day) {
                    $availability[esc_sql($day)] = esc_sql($_POST[$day]);
                }
                //  print_r($availability);


                if (!username_exists($_POST['user_email']) and  !email_exists($_POST['user_email'])) {
                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $new_user = array(
                        'user_pass' => $random_password,
                        'user_login' => esc_sql($_POST['user_email']),
                        'user_email' => esc_sql($_POST['user_email']),
                        'display_name' => esc_sql($_POST['first_name']) . " " . esc_sql($_POST['last_name']),
                        'first_name' => esc_sql($_POST['first_name']),
                        'last_name' => esc_sql($_POST['last_name']),
                        'role' => 'wpc_client_staff',
                    );

                    $new_user_id = wp_insert_user($new_user);

                    update_user_meta($new_user_id, '_wpc_mobile_number', esc_sql($_POST['_wpc_mobile_number']));
                    add_user_meta($new_user_id, 'wpc_cf_phone_number', esc_sql($_POST['wpc_cf_phone_number']));
                    //update_user_meta($new_user_id, 'wpc_cf_phone_number', esc_sql($_POST['wpc_phone_number']));
                    update_user_meta($new_user_id, 'wpc_cf_status', esc_sql($_POST['wpc_cf_status']));
                    //  update_user_meta($client_id, 'wpc_cf_counsellor', esc_sql($_POST['wpc_cf_counsellor']));
                    update_user_meta($new_user_id, 'wpc_cf_availability_day', $availability);
                    update_user_meta($new_user_id, 'wpc_cf_student', esc_sql($_POST['student']));


                    add_user_meta($new_user_id, 'address_1', esc_sql($_POST['address_1']));
                    add_user_meta($new_user_id, 'address_2', esc_sql($_POST['address_2']));
                    add_user_meta($new_user_id, 'town', esc_sql($_POST['town']));
                    add_user_meta($new_user_id, 'post_code', esc_sql($_POST['post_code']));


                    add_user_meta($new_user_id, 'kin_name', esc_sql($_POST['kin_name']));
                    add_user_meta($new_user_id, 'kin_email', esc_sql($_POST['kin_email']));
                    add_user_meta($new_user_id, 'kin_phone', esc_sql($_POST['kin_phone']));


                    $msg = "                
                    Hi,<br>
                    <br>
                    Your account has been created. See details below:<br>
                    Username: " . $_POST['user_email'] . "<br>
                    Temporary Password: $random_password<br>
                    Login link: https://admin.healingfortheheart.co.uk/<br>
                    <br>  
                    ";

                    h4h_mail($_POST['user_email'], $email, 'New Account', $msg, 'WELCOME');


                    wp_redirect($curent_page . "?added=true&email=" . esc_sql($_POST['user_email']));
                    exit();
                } else {
                    wp_redirect($curent_page . "?err=2");
                    exit();
                }

                die();
                break;


            case 'update_counsellor':

                if (!wp_verify_nonce($_POST['nonce'], "update_counsellor")) {
                    wp_redirect($curent_page);
                    exit;
                }



                $counsellor_id = esc_sql($_POST['counsellor']);

                $redirect = "&updated=true#profile|1";

                $counsellor = get_userdata($counsellor_id);
                if (esc_attr($_POST['user_email']) ===  $counsellor->user_email) {
                    $args = array(
                        'ID' => $counsellor_id,
                        'display_name' => esc_sql($_POST['first_name'] . " " . $_POST['last_name'])
                    );
                } else {

                    if (!email_exists($_POST['user_email'])) {
                        $args = array(
                            'ID' => $counsellor_id,
                            'user_email' => esc_sql($_POST['user_email']),
                            'display_name' => esc_sql($_POST['first_name'] . " " . $_POST['last_name'])
                        );
                    } else {
                        $redirect = "&err=2#profile|1";
                    }
                }

                wp_update_user($args);


                $availability = array();
                foreach ($_POST['day'] as $day) {
                    $availability[esc_sql($day)] = esc_sql($_POST[$day]);
                }
                //  print_r($availability);

                update_user_meta($counsellor_id, 'first_name', esc_sql($_POST['first_name']));
                update_user_meta($counsellor_id, 'last_name', esc_sql($_POST['last_name']));

                update_user_meta($counsellor_id, '_wpc_mobile_number', esc_sql($_POST['_wpc_mobile_number']));
                update_user_meta($counsellor_id, 'wpc_cf_phone_number', esc_sql($_POST['wpc_phone_number']));
                update_user_meta($counsellor_id, 'wpc_cf_status', esc_sql($_POST['wpc_cf_status']));
                //  update_user_meta($client_id, 'wpc_cf_counsellor', esc_sql($_POST['wpc_cf_counsellor']));
                update_user_meta($counsellor_id, 'wpc_cf_availability_day', $availability);
                update_user_meta($counsellor_id, 'wpc_cf_student', esc_sql($_POST['student']));

                update_user_meta($counsellor_id, 'description', esc_attr($_POST['description']));


                update_user_meta($counsellor_id, 'address_1', esc_sql($_POST['address_1']));
                update_user_meta($counsellor_id, 'address_2', esc_sql($_POST['address_2']));
                update_user_meta($counsellor_id, 'town', esc_sql($_POST['town']));
                update_user_meta($counsellor_id, 'post_code', esc_sql($_POST['post_code']));


                update_user_meta($counsellor_id, 'kin_name', esc_sql($_POST['kin_name']));
                update_user_meta($counsellor_id, 'kin_email', esc_sql($_POST['kin_email']));
                update_user_meta($counsellor_id, 'kin_phone', esc_sql($_POST['kin_phone']));




                wp_redirect($curent_page . $redirect);
                exit();



                break;


            case 'add_referral_assessment':

                if (!wp_verify_nonce($_POST['nonce'], "add_referral_assessment")) {
                    wp_redirect($curent_page . "?nonce=invalid");
                    exit;
                }


                $have_referral_assessment = get_user_meta(esc_sql($_POST['client']), 'wpc_cf_referral_assessment', false);

                if ($have_referral_assessment)
                    update_user_meta(esc_sql($_POST['client']), 'wpc_cf_referral_assessment', $_POST);
                else
                    add_user_meta(esc_sql($_POST['client']), 'wpc_cf_referral_assessment', $_POST);


                wp_redirect($curent_page . "&updated_referral=true");
                exit();

                break;


            case 'add_risk_report':

                global $wpdb;

                if (!wp_verify_nonce($_POST['nonce'], "add_risk_report")) {
                    wp_redirect($curent_page . "?nonce=invalid");
                    exit;
                }

                $email = $current_user->user_email;

                add_user_meta(esc_sql($_POST['client']), 'wpc_cf_risk_report', $_POST);
                update_user_meta(esc_sql($_POST['client']), 'wpc_cf_risk_report_viewed', 0);

                //$have_risk_report = get_user_meta(esc_sql($_POST['client']), 'wpc_cf_risk_report', false);

                /*if ($have_risk_report) {
                    update_user_meta(esc_sql($_POST['client']), 'wpc_cf_risk_report', $_POST);
                    update_user_meta(esc_sql($_POST['client']), 'wpc_cf_risk_report_viewed', 0);
                } else {
                    add_user_meta(esc_sql($_POST['client']), 'wpc_cf_risk_report', $_POST);
                    add_user_meta(esc_sql($_POST['client']), 'wpc_cf_risk_report_viewed', 0);
                }*/

                /*$wpdb->insert("{$wpdb->prefix}wpc_bh_client_risk_reports", array(
                    "client_id" => esc_sql($_POST['client']),
                    "by_user_id" => $ID,
                    "report" => $_POST,

                ));

                print_r($_POST);
                die;*/

                $counsellor_name = get_counsellor_name($ID);

                $msg = "                
                    Hi,<br>
                    <br>
                    There is a risk report submitted for a client of $counsellor_name.<br>
                    Login to : https://admin.healingfortheheart.co.uk/<br>
                    <br>  
                    ";

                h4h_mail(get_option('risk_report_notification_email'), $email, 'Risk Report', $msg, 'NOTIFICATION');


                wp_redirect($curent_page . "&updated_risk=true");
                exit();

                break;


            case 'update_risk_report':

                global $wpdb;

                if (!wp_verify_nonce($_POST['nonce'], "update_risk_report")) {
                    wp_redirect($curent_page . "?nonce=invalid");
                    exit;
                }


                $email = $current_user->user_email;

                $wpdb->update("{$wpdb->prefix}usermeta", array(
                    "meta_value" =>  serialize($_POST),
                ), array('umeta_id' => esc_sql($_POST['mid'])));
                update_user_meta(esc_sql($_POST['client']), 'wpc_cf_risk_report_viewed', 0);


                $counsellor_name = get_counsellor_name($ID);

                $msg = "                
                        Hi,<br>
                        <br>
                        There is an update on the risk report submitted for a client of $counsellor_name.<br>
                        Login to : https://admin.healingfortheheart.co.uk/<br>
                        <br>  
                        ";

                h4h_mail(get_option('risk_report_notification_email'), $email, 'Risk Report', $msg, 'NOTIFICATION');


                wp_redirect($curent_page . "&updated_risk=true");
                exit();

                break;


            case 'download_clients_core_om_difference_csv':

                if (!wp_verify_nonce($_POST['nonce'], "download_clients_core_om_difference_csv")) {
                    wp_redirect($curent_page);
                    exit;
                }

                $filename = 'Clients_Core_OM.csv';

                $data = get_clients_core_om('OBJECT', false);
                print_r($data);

                $header = array('Client Name', 'Counsellor', 'Core OM before Counselling', 'Core OM after Counselling', 'Difference');
                $fields = array('client_name', 'counsellor', 'core_om1', 'core_om2', 'core_om_difference');

                array_to_csv_download($filename, $data, $fields, $header);

                exit;


                break;

            case 'add_clients_bulk':


                global $wpdb;

                $filename = $_FILES["clients"]["tmp_name"];
                $file = fopen($filename, "r");

                while (($getData = fgetcsv($file, 100, ",")) !== FALSE) {
                    print_r($getData);



                    if (!username_exists($getData[2]) and  !email_exists($getData[2])) {
                        $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                        $new_user = array(
                            'user_pass' => $random_password,
                            'user_login' => esc_sql($getData[2]),
                            'user_email' => esc_sql($getData[2]),
                            'display_name' => esc_sql($getData[0] . " " . $getData[1]),
                            'first_name' => esc_sql($getData[0]),
                            'last_name' => esc_sql($getData[1]),
                            'role' => 'wpc_client',
                        );


                        $new_user_id = wp_insert_user($new_user);


                        update_user_meta($new_user_id, 'wpc_cf_status', 'Initiated');


                        $manager_id = 45;

                        $sql = "INSERT INTO `{$wpdb->prefix}wpc_client_objects_assigns`(`object_type`, `object_id`, 
                    `assign_type`, `assign_id`) 
                    VALUES ('manager','$manager_id','client',$new_user_id)";

                        $wpdb->insert("{$wpdb->prefix}wpc_client_objects_assigns", array(
                            "object_type" => 'manager',
                            "object_id" => $manager_id,
                            "assign_type" => 'client',
                            "assign_id" => $new_user_id,
                        ));


                        $msg = "                
                    Hi,<br>
                    <br>
                    Your account has been created. See details below:<br>
                    Username: " . $getData[2] . "<br>
                    Temporary Password: $random_password<br>                   
                    Login link: https://admin.healingfortheheart.co.uk/<br>
                    <br>  
                    ";

                        //h4h_mail($_POST['user_email'], $email, 'New Account', $msg, 'WELCOME');
                        h4h_mail($getData[2], 'info@healingfortheheart.co.uk', 'New Account', $msg, 'WELCOME');
                        //sleep(1);
                    }
                }

                die();

                break;


            default:
        }
    }
}

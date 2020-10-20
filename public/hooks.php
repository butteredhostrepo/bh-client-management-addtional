<?php

if (!defined('WPINC')) {
    die;
}


function h4h_enqueue_styles()
{
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css');
    //wp_enqueue_style('jqueryui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');

    wp_enqueue_style('jqueryui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
}
add_action('wp_enqueue_scripts', 'h4h_enqueue_styles');

function abc_load_my_scripts()
{
    wp_enqueue_script('boot2', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), '', true);
    wp_enqueue_script('boot3', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js', array('jquery'), '', true);
    wp_enqueue_script('boot4', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), '', false);
}

add_action('wp_enqueue_scripts', 'abc_load_my_scripts', 999);



// Block non-administrators from accessing the WordPress back-end
function wpabsolute_block_users_backend()
{
    if (is_admin() && !current_user_can('administrator') && !wp_doing_ajax()) {
        if (current_user_can('wpc_manager')) {
            wp_redirect('/manager');
        } else {
            wp_redirect(home_url());
        }
        exit;
    }
}
add_action('init', 'wpabsolute_block_users_backend');


// remove admin bar
function hide_admin_bar()
{
    if (is_admin() && !current_user_can('administrator')) {
        return false;
    }
}
add_filter('show_admin_bar', 'hide_admin_bar');



///Add logout link on the menu
function wti_loginout_menu_link($items, $args)
{

    //if ($args->theme_location == 'primary') {
    if (is_user_logged_in()) {
        $items .= '<li class="logout"><a href="' . wp_logout_url() . '">' . __("Log Out") . '</a></li>';
    } else {
        $items .= '<li class="right"><a href="' . wp_login_url(get_permalink()) . '">' . __("Log In") . '</a></li>';
    }
    //}
    return $items;
}
add_filter('wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2);


///Logout Redirection
function ps_redirect_after_logout()
{
    wp_redirect(home_url());
    exit();
}
add_action('wp_logout', 'ps_redirect_after_logout');



add_action('wp', 'access_control'); //form access control
function access_control()
{

    if (current_user_can('archived_manager') or current_user_can('archived_counsellor')) {

        wp_logout();
        wp_redirect('?account=archived');
        exit();
    }


    if (!is_admin() && !isset($_POST)) {
        ///ACCESS CONTROL
        global $post;


        $current_user = wp_get_current_user();
        $ID = $current_user->ID;

        //3 is the form id of core om
        $check_core_om1 = check_client_core_om($ID, 3);
        if ($check_core_om1 !== '' && get_user_meta($ID, 'wpc_cf_core_om1', true) == '') {
            $core_om1 = calculate_core_om(3, $check_core_om1, $ID);
            update_user_meta($ID, 'wpc_cf_core_om1', $core_om1['clinical_score']);
            update_user_meta($ID, 'core_om1_form', $check_core_om1);
        }

        //8 is the form id of core om after counselling
        $check_core_om2 = check_client_core_om($ID, 8);
        if ($check_core_om2 !== '' && get_user_meta($ID, 'wpc_cf_core_om2', true) == '') {
            $core_om2 = calculate_core_om(8, $check_core_om2, $ID);
            update_user_meta($ID, 'wpc_cf_core_om2', $core_om2['clinical_score']);
            update_user_meta($ID, 'core_om2_form', $check_core_om2);
        }

        $parents = get_post_ancestors($post->ID);

        if (in_array('520', $parents)) { //////CLient
            if (isset($_GET['form'])) {

                if (client_answered_form($ID, esc_attr($_GET['form']))->total > 0 && is_page('answer-form')) { //////Answer Form page
                    wp_redirect('/client/forms/');
                    exit();
                }

                if (isset($_GET['client']) && esc_attr($_GET['client']) != $ID) {
                    wp_redirect('/client/forms/');
                    exit();
                }
            }
        }
    }
}


///check for client status
add_action('wp', 'check_status');
function check_status()
{
    if (current_user_can('wpc_client')) {
        $current_user = wp_get_current_user();
        $ID = $current_user->ID;

        $current_status = get_user_meta($ID, 'wpc_cf_status', true);

        //check if the current client is already answered the Core-OM(3) and Contract Forms(2)        
        if ($current_status == 'Initiated' && check_client_anwered_forms($ID, array(2, 3)) == 2) {
            update_user_meta($ID, 'wpc_cf_status', 'New Client Forms Completed');
        }
    }
}



function wpse27856_set_content_type()
{
    return "text/html";
}
add_filter('wp_mail_content_type', 'wpse27856_set_content_type');

add_filter('wp_mail_from_name', 'h4h_mail_from_name');
function h4h_mail_from_name($name)
{
    return "Healing for the Heart";
}

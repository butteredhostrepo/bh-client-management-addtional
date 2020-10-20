<?php
if (!defined('WPINC')) {
    die;
}


function risk_report_settings()
{
    add_option('risk_report_notification_email', '');
    register_setting('risk_report_notification_email', 'risk_report_notification_email', 'wpse61431_settings_validate');
}
add_action('admin_init', 'risk_report_settings');

function wpse61431_settings_validate($args)
{
    //$args will contain the values posted in your settings form, you can validate them as no spaces allowed, no special chars allowed or validate emails etc.
    if (!isset($args['risk_report_notification_email']) || !is_email($args['risk_report_notification_email'])) {
        //add a settings error because the email is invalid and make the form field blank, so that the user can enter again
        $args['risk_report_notification_email'] = '';
        add_settings_error('risk_report_notification_email', 'risk_report_notification_email_invalid_email', 'Please enter a valid email!', $type = 'error');
    }

    //make sure you return the args
    return $args;
}

//Display the validation errors and update messages
/*
 * Admin notices
 */
add_action('admin_notices', 'wpse61431_admin_notices');
function wpse61431_admin_notices()
{
    settings_errors();
}



function risk_report_settings_submenu()
{
    add_submenu_page(
        'wpclients',       // parent slug
        'Risk Report',    // page title
        'Risk Report',             // menu title
        'manage_options',           // capability
        'riskreports', // slug
        'risk_report_settings_page', // callback
        5
    );
}

add_action('admin_menu', 'risk_report_settings_submenu', 11);

?>
<?php function risk_report_settings_page()
{
?>
    <div>

        <h2>Risk Report</h2>
        <form method="post" action="options.php">
            <?php settings_fields('risk_report_notification_email');
            ?>
            <h3>Email notification for risk report</h3>
            <p>A notification email will be sent every submission of risk report</p>
            <table>
                <tr valign="top">
                    <th scope="row"><label for="risk_report_notification_email">Email:</label></th>
                    <td><input type="text" id="risk_report_notification_email" name="risk_report_notification_email" value="<?php echo get_option('risk_report_notification_email'); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
} ?>
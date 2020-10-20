<?php
if (!defined('WPINC')) {
    die;
}



foreach ($open_risk_report as $risk) : ?>

    <div class="alert alert-warning " style="font-size: 17px;font-weight: bold;" role="alert">
        Risk report for <?php echo get_client_name($risk->id); ?> from <?php echo get_counsellor_name(get_user_meta($risk->id, 'wpc_cf_counsellor', true)); ?>. <a href="/manager/my-clients/client-profile/?client=<?php echo $risk->id; ?>&view_risk=true#profile|5">Click here</a> to view and close this notification.

    </div>

<?php endforeach;

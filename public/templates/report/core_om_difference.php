<?php
if (!defined('WPINC')) {
    die;
}
?>

<div class="container-fluid">
    <div class=" row  d-flex">
        <div class="col pl-0 justify-content-center align-self-center">
            <span class="align-middle">
                <a href="<?php echo get_permalink(); ?>">All (<?php echo count_client_status('', $manager_id); ?>) </a>
            </span>
            <?php foreach (get_statuses_for_clients() as $status) : ?>
                <?php
                $count = count_client_status($status['value'], $manager_id);
                if ($count > 0) :
                ?>
                    <span class="align-middle">
                        | <a href="?status=<?php echo $status['value']; ?>"><?php echo $status['label']; ?> (<?php echo $count; ?>)</a>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>

    </div>
</div>



<?php if (get_query_var('search')) : ?>
    <div style="padding:10px 0;"> Search results: <?php echo get_query_var('search'); ?></div>
<?php endif; ?>


<table class="table table-hover" style="background-color: #FFF;">
    <thead style="border-bottom: 1px solid #000;">
        <tr>

            <th>Client Name</th>
            <th>Counsellor</th>
            <th>Core OM before counselling</th>
            <th>Core OM after counselling</th>
            <th>Difference</th>

        </tr>
    </thead>
    <tbody>
        <?php if (count($my_clients) > 0) : ?>
            <?php foreach ($my_clients as $client) :
                $client_info = get_userdata($client->ID);

                //$status = get_user_meta($client->ID, 'wpc_cf_status', true);
                //$status = empty($status) ? "-" : $status;
                $core_om1 = floatval(get_user_meta($client->ID, 'wpc_cf_core_om1', true)  !==  null ? get_user_meta($client->ID, 'wpc_cf_core_om1', true) : 0);
                $core_om2 = floatval(get_user_meta($client->ID, 'wpc_cf_core_om2', true)  !==  null ? get_user_meta($client->ID, 'wpc_cf_core_om2', true) : 0);
                $core_diff = $core_om2 - $core_om1;


                if ($core_diff < 0) {
                    $core_diff_html = "<span style='color:red'> $core_diff</span>";
                } else {
                    if ($core_diff == 0)
                        $core_diff_html = "<span  $core_diff</span>";
                    else
                        $core_diff_html = "<span style='color:green'> +$core_diff</span>";
                }
            ?>
                <tr>

                    <td><?php echo get_user_meta($client->ID, 'first_name', true) . ' ' . get_user_meta($client->ID, 'last_name', true); ?></td>

                    <td><?php echo get_counsellor_name(get_user_meta($client->ID, 'wpc_cf_counsellor', true)); ?></td>
                    <td><?php echo $core_om1 == 0 ? 0 : $core_om1 . ' [<a target="_blank" href="/manager/my-clients/client-profile/view-answered-form/?client=' . $client->ID . '&answer=' . get_user_meta($client->ID, 'core_om1_form', true) . '&form=3">view answer</a>]'; ?></td>
                    <td><?php echo $core_om2 == 0 ? 0 : $core_om2 . ' [<a target="_blank" href="/manager/my-clients/client-profile/view-answered-form/?client=' . $client->ID . '&answer=' . get_user_meta($client->ID, 'core_om2_form', true) . '&form=8">view answer</a>]'; ?></td>
                    <td><?php echo $core_diff_html; ?></td>

                </tr> <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="7">No clients found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


<div class="float-left">
    <div class="navigation">
        <div class="float-left previous panel mr-2"><?php previous_posts_link('&laquo; previous', $max_num_pages) ?></div>
        <div class="float-right next panel"><?php next_posts_link('more &raquo;', $max_num_pages) ?></div>
    </div>
</div>

<div class="float-right">
    <form action="" method="post">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('download_clients_core_om_difference_csv'); ?>">
        <input type="hidden" name="action" value="download_clients_core_om_difference_csv">
        <input type="hidden" name="curent_page" value="<?php echo  get_permalink(); ?>">
        <input type="submit" class="btn btn-primary h4h-primary btn-sharp-edge" value="Download as CSV">
    </form>
</div>
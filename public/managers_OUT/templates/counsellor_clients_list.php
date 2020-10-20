<?php
if (!defined('WPINC')) {
    die;
}
?>


<table class="table table-hover" style="background-color: #FFF;">
    <thead style="border-bottom: 1px solid #000;">
        <tr>
            <th>ID</th>
            <th>Client Name</th>
            <th>Email</>
            <th>Date Created</th>
            <th>Counsellor</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($my_clients) > 0) : ?>
            <?php foreach ($my_clients as $client) :
                $client_info = get_userdata($client->ID);

                $status = get_user_meta($client->ID, 'wpc_cf_status', true);
                $status = empty($status) ? "-" : $status;
            ?>
                <tr>
                    <td>#<?php echo $client->ID; ?></td>
                    <td><?php echo get_user_meta($client->ID, 'first_name', true) . ' ' . get_user_meta($client->ID, 'last_name', true); ?></td>
                    <td><?php echo $client_info->user_email; ?></td>
                    <td><?php echo $client_info->user_registered; ?></td>
                    <td><?php echo get_counsellor_name(get_user_meta($client->ID, 'wpc_cf_counsellor', true)); ?></td>
                    <td><?php echo $status; ?></td>
                    <td><a href="/manager/my-clients/client-profile/?client=<?php echo $client->ID; ?>">View </a> </td>
                </tr> <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="7">No clients found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
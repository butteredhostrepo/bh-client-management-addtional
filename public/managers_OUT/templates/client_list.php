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
        <div class="col pr-0">

            <form action="<?php echo get_permalink(); ?>" method="get" class="form-inline float-right">
                <div class="form-group mb-2 mr-2">
                    <label for="inputPassword2" class="sr-only">Password</label>
                    <input type="text" class="form-control" name="search" value="<?php echo get_query_var('search'); ?>" placeholder="Search Clients">
                </div>
                <input type="submit" value="Search" class="btn btn-sharp-edge h4h-primary btn-primary mb-2">
            </form>

            <a href="client-profile/" class="btn btn-sharp-edge h4h-secondary float-right mr-3">Add Client</a>
        </div>
    </div>
</div>



<?php if (get_query_var('search')) : ?>
    <div style="padding:10px 0;"> Search results: <?php echo get_query_var('search'); ?></div>
<?php endif; ?>


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
                    <td><a href=" client-profile/?client=<?php echo $client->ID; ?>">View </a> </td>
                </tr> <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="7">No clients found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
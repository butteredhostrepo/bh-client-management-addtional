<?php
if (!defined('WPINC')) {
    die;
}
?>


<h2>Current DNAs</h2>
<table class="table table-hover" style="background-color: #FFF;">
    <thead style="border-bottom: 1px solid #000;">
        <tr>

            <th>Client Name</th>
            <th>DNA Count</>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php if (count($my_clients) > 0) : ?>
            <?php foreach ($my_clients as $client) :
                //$client_info = get_userdata($client->ID);

                //$status = get_user_meta($client->ID, 'wpc_cf_status', true);
                //$status = empty($status) ? "-" : $status;
            ?>
                <tr>

                    <td><?php echo get_user_meta($client->ID, 'first_name', true) . ' ' . get_user_meta($client->ID, 'last_name', true); ?></td>

                    <td><?php echo count_dna_total($client->ID); ?></td>

                    <td>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Profile" href="/manager/client-profile/?client=<?php echo $client->ID; ?>">
                            <i class="fa fa-address-card-o" style="font-size: 20px;"></i>
                        </a>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Form" href="/manager/client-profile/?client=<?php echo $client->ID; ?>#profile|1">
                            <i class="fa fa-edit" style="font-size: 20px;"></i>
                        </a>



                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Notes" href="/manager/client-profile/?client=<?php echo $client->ID; ?>#profile|2">
                            <i class="fa fa-sticky-note-o" style="font-size: 20px;"></i>
                        </a>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Referral Assessment" href="/manager/client-profile/?client=<?php echo $client->ID; ?>#profile|3">
                            <i class="fa fa-list-alt" style="font-size: 20px;"></i>
                        </a>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Donation" href="/manager/client-profile/?client=<?php echo $client->ID; ?>#profile|4">
                            <i class="fa fa-credit-card" style="font-size: 20px;"></i>
                        </a>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Risk Report" href="/manager/client-profile/?client=<?php echo $client->ID; ?>&view_risk=true#profile|5">
                            <i class="	fa fa-calendar-times-o" style="font-size: 20px;"></i>
                        </a>

                    </td>
                </tr> <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="7">No clients found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>



<h2 style="margin-top: 50px;">All Past DNAs</h2>
<table class="table table-hover" style="background-color: #FFF;">
    <thead style="border-bottom: 1px solid #000;">
        <tr>

            <th>Client Name</th>
            <th>DNA Count</>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php if (count($my_clients_history) > 0) : ?>
            <?php foreach ($my_clients_history as $client) :
                //$client_info = get_userdata($client->ID);

                //$status = get_user_meta($client->ID, 'wpc_cf_status', true);
                //$status = empty($status) ? "-" : $status;
            ?>
                <tr>

                    <td><?php echo get_user_meta($client->ID, 'first_name', true) . ' ' . get_user_meta($client->ID, 'last_name', true); ?></td>

                    <td><?php echo count_dna_total($client->ID); ?></td>

                    <td>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Profile" href="/manager/client-profile/?client=<?php echo $client->ID; ?>">
                            <i class="fa fa-address-card-o" style="font-size: 20px;"></i>
                        </a>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Form" href="/manager/client-profile/?client=<?php echo $client->ID; ?>#profile|1">
                            <i class="fa fa-edit" style="font-size: 20px;"></i>
                        </a>



                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Notes" href="/manager/client-profile/?client=<?php echo $client->ID; ?>#profile|2">
                            <i class="fa fa-sticky-note-o" style="font-size: 20px;"></i>
                        </a>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Referral Assessment" href="/manager/client-profile/?client=<?php echo $client->ID; ?>#profile|3">
                            <i class="fa fa-list-alt" style="font-size: 20px;"></i>
                        </a>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Client Donation" href="/manager/client-profile/?client=<?php echo $client->ID; ?>#profile|4">
                            <i class="fa fa-credit-card" style="font-size: 20px;"></i>
                        </a>

                        <a class="popover-dismiss p-1" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="View Risk Report" href="/manager/client-profile/?client=<?php echo $client->ID; ?>&view_risk=true#profile|5">
                            <i class="	fa fa-calendar-times-o" style="font-size: 20px;"></i>
                        </a>

                    </td>
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
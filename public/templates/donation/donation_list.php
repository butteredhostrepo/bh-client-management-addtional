<?php
if (!defined('WPINC')) {
    die;
}
?>



<!-- VIEW Modal -->
<div class="modal fade" id="view_donation" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>View Donation</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">

                <div class="note-loading">Loading...</div>

                <div class="view-donation-details">

                    <div class="row">

                        <div class="form-group col">
                            <label for="date_donation">Date of Donation:</label>
                            <div id="date_donation"></div>

                        </div>

                        <div class="form-group col">
                            <label for="donation_amount">Donation Amount:</label>
                            <div id="donation_amount"></div>

                        </div>

                    </div>


                    <div class="form-group ">
                        <label for="note">Notes:</label>
                        <div id="donation_note_view"></div>
                    </div>

                    <div class="form-group ">
                        <label for="note">Type:</label>
                        <div id="donation_type"></div>
                    </div>

                    <div class="form-group ">
                        <label for="note">Gift Aid:</label>
                        <div id="gift_aid"></div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Close</button>

            </div>



        </div>
    </div>
</div>

<form action="" method="GET">

    <div class="input-group">

        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Filters: </span>
        </div>

        <select class="custom-select" name="counsellor" id="counsellor">
            <option value="" selected>Filter by Counsellor...</option>
            <?php foreach ($cousellors as $cousellor) : ?>
                <option value="<?php echo $cousellor->ID; ?>" <?php echo  isset($_GET['counsellor']) && $cousellor->ID == $_GET['counsellor'] ? "selected" : ""; ?>>
                    <?php echo $cousellor->display_name; ?>
                </option>
            <?php endforeach; ?>

        </select>

        <select class="custom-select" name="client" id="client">
            <option value="" selected>Filter by Client...</option>
            <?php foreach ($clients as $client) : ?>
                <option value="<?php echo $client->ID; ?>" <?php echo  isset($_GET['client']) && $client->ID == $_GET['client'] ? "selected" : ""; ?>>
                    <?php echo $client->display_name; ?>
                </option>
            <?php endforeach; ?>

        </select>
        <input type="text" autocomplete="off" name="from" class="" value="<?php echo isset($_GET['from']) ? $_GET['from'] : ""; ?>" id="from" placeholder="Filter by Date From">
        <input type="text" autocomplete="off" name="to" class="" value="<?php echo isset($_GET['to']) ? $_GET['to'] : ""; ?>" id="to" placeholder="Filter by  Date To">

        <div class="input-group-append">
            <button class="btn h4h-secondary " type="submit">Filter</button>
            <button class="btn btn-outline-secondary " onclick="window.location.href = '/manager/donations/'" type="button">Reset</button>
        </div>

    </div>

</form>


<div class="mt-2">

    <?php if (count($donations) > 0) : ?>
        <?php

        $date_order = "&orderby=date";
        $date_order .= isset($_GET['order']) && $_GET['order'] == "asc" ? "&order=desc" : "&order=asc";

        $amount_order = "&orderby=amount";
        $amount_order .= isset($_GET['order']) && $_GET['order'] == "asc" ? "&order=desc" : "&order=asc";
        ?>
        <table style="background: #FFF;" class="table-hover">
            <thead style="border-bottom: 1px solid #000;">
                <tr>

                    <th>Added by</th>
                    <th>Client</th>
                    <th><a href="<?php echo $base_link . $date_order; ?>">Date of Donation</a></th>
                    <th><a href="<?php echo $base_link . $amount_order; ?>">Amount</a></th>
                    <th>Type</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($donations) > 0) : ?>

                    <?php foreach ($donations as $donation) :
                    ?>
                        <tr>
                            <td><?php echo $donation->addedby; ?></td>
                            <td><a href="/manager/my-clients/client-profile/?client=<?php echo $donation->client_id; ?>"><?php echo $donation->client; ?></a></td>
                            <td><?php echo $donation->date; ?></td>
                            <td><?php echo number_format($donation->amount, 2, '.', ','); ?></td>
                            <td><?php echo $donation->type; ?></td>
                            <td><?php echo wp_trim_words(stripslashes($donation->note), 100); ?></td>
                            <td>
                                <a href="#" data-toggle="modal" class="btn-update_donation" data-target="#view_donation" data-donation="<?php echo $donation->id; ?>" data-nonce="<?php echo wp_create_nonce("editdonation" . $donation->id); ?>">View</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>

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
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('download_donation_csv'); ?>">
                <input type="hidden" name="action" value="download_donation_csv">
                <input type="hidden" name="curent_page" value="<?php echo  $base_link; ?>">
                <input type="submit" class="btn btn-primary h4h-primary btn-sharp-edge" value="Download as CSV">
            </form>
        </div>

    <?php else : ?>
        <p>No donation found</p>
    <?php endif; ?>


</div>
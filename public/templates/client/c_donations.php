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

                <div class=" view-donation-details">


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

                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Close</button>

            </div>



        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="delete_donation" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Confim Delete Donation</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body view-note-details">
                Are you sure you want to remove this donation?

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sharp-edge  btn-danger delete-donation-confirmed" data-donation="" data-nonce="" data-dismiss="modal">Remove</button>
            </div>
        </div>
    </div>
</div>



<div class="mt-2">

    <?php if (count($donations) > 0) : ?>
        <table class="table-hover">
            <thead style="border-bottom: 1px solid #000;">
                <tr>

                    <th>Added by</th>
                    <th>Date of Donation</th>
                    <th>Amount</th>
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
                            <td><?php echo $donation->date; ?></td>
                            <td><?php echo number_format($donation->amount, 2, '.', ','); ?></td>
                            <td><?php echo wp_trim_words(stripslashes($donation->note), 100); ?></td>
                            <td>
                                <a href="#" data-toggle="modal" class="btn-update_donation" data-target="#view_donation" data-donation="<?php echo $donation->id; ?>" data-nonce="<?php echo wp_create_nonce("editdonation" . $donation->id); ?>">View</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>
        </table>
    <?php else : ?>
        <p>No donation found</p>
    <?php endif; ?>
</div>
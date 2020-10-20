<?php
if (!defined('WPINC')) {
    die;
}
?>

<?php if (isset($_GET['addednote']) && $_GET['addednote'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully Added!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['updatednote']) && $_GET['updatednote'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully Updated!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<div class="container-fluid">
    <div class=" row ">
        <div class="col">
            <h3>Donations</h3>
        </div>
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sharp-edge float-right h4h-secondary" data-toggle="modal" data-target="#add_donation">
                Add Donation
            </button>
        </div>
    </div>

</div>




<!-- Modal -->
<div class="modal fade" id="add_donation" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Add Donation</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="needs-validation" method="post" novalidate>
                <div class="modal-body">

                    <div class="row">

                        <div class="form-group col">
                            <label for="datesession">Date of Donation:</label>
                            <input type="text" name="donation_date" class="form-control datepicker" id="datesession" placeholder="" autocomplete="off" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>

                        <div class="form-group  col">
                            <label for="donation_amount">Donation Amount:</label>
                            <input type="number" min="0" step=".01" oninput="validity.valid||(value='');" name="donation_amount" class="form-control " id="donation_amount" placeholder="" autocomplete="off" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>

                    </div>

                    <div class="form-group ">
                        <label for="note">Note:</label>
                        <textarea name="note" class="form-control" id="note" rows="6"></textarea>
                    </div>

                    <div class="row">
                        <div class="form-group col d-flex flex-wrap">
                            <label for="desc">Type: </label>

                            <div class="form-check ml-3">
                                <input class="form-check-input" type="radio" name="type" id="type_cash" value="cash" checked required>
                                <label class="form-check-label" for="type_cash">
                                    Cash
                                </label>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>

                            <?php if (current_user_can('wpc_manager')) : ?>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="type" id="type_bank" value="bank">
                                    <label class="form-check-label" for="type_bank">
                                        Bank
                                    </label>
                                </div>
                            <?php endif; ?>



                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col d-flex flex-wrap">
                            <label for="gift_aid">Gift Aid: </label>

                            <div class="form-check ml-3">
                                <input class="form-check-input" type="radio" name="gift_aid" id="gift_aid" value="yes" checked required>
                                <label class="form-check-label" for="gift_aid">
                                    Yes
                                </label>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>


                            <div class="form-check ml-3">
                                <input class="form-check-input" type="radio" name="gift_aid" id="gift_aid" value="no">
                                <label class="form-check-label" for="gift_aid">
                                    No
                                </label>
                            </div>




                        </div>
                    </div>



                    <input type="hidden" name="action" value="add_donation">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('add_donation' . $_GET['client']); ?>">
                    <input type="hidden" name="client" value="<?php echo $_GET['client']; ?>">
                    <input type="hidden" name="curent_page" value="<?php echo  get_permalink() . "?client=" . $_GET['client']; ?>">




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_notes" class="btn  btn-sharp-edge h4h-primary btn-primary">Add Donation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="update_donation" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Update Donation</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" class="needs-validation " method="post" novalidate>
                <div class="modal-body">

                    <div class="note-loading">Loading...</div>

                    <div class="donation-update-form">
                        <div class="row">

                            <div class="form-group col">
                                <label for="updatedatesession">Date of Donation:</label>
                                <input type="text" name="donation_date" class="form-control datepicker" id="dateofdonation" placeholder="" autocomplete="off" required>
                            </div>

                            <div class="form-group  col">
                                <label for="donation_amount">Donation Amount:</label>
                                <input type="number" step=".01" name="donation_amount" class="form-control " id="donation_amount" placeholder="" autocomplete="off" required>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label for="note">Note:</label>
                            <textarea name="note" class="form-control" id="note" rows="6"></textarea>
                        </div>

                        <div class="row">
                            <div class="form-group col d-flex flex-wrap">
                                <label for="desc">Type: </label>

                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="type" id="type_cash" value="cash">
                                    <label class="form-check-label" for="type_cash">
                                        Cash
                                    </label>
                                </div>

                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="type" id="type_bank" value="bank">
                                    <label class="form-check-label" for="type_bank">
                                        Bank
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col d-flex flex-wrap">
                                <label for="gift_aid">Gift Aid: </label>

                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="gift_aid" id="gift_yes" value="yes" required>
                                    <label class="form-check-label" for="gift_yes">
                                        Yes
                                    </label>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>


                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="gift_aid" id="gift_no" value="no">
                                    <label class="form-check-label" for="gift_no">
                                        No
                                    </label>
                                </div>

                            </div>
                        </div>



                    </div>

                    <input type="hidden" name="action" value="update_donation">
                    <input type="hidden" name="thisdonation" id="update-donation" value="">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('update_donation' . $_GET['client']); ?>">
                    <input type="hidden" name="client" value="<?php echo $_GET['client']; ?>">
                    <input type="hidden" name="curent_page" value="<?php echo  get_permalink() . "?client=" . $_GET['client']; ?>">




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_notes" class="btn  btn-sharp-edge h4h-primary btn-primary">Update Donation</button>
                </div>
            </form>


        </div>
    </div>
</div>


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

                <div class="modal-body view-donation-details">

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

            <div class="modal-body">



                <div class="modal-body view-note-details">
                    Are you sure you want to remove this donation?

                </div>

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

                                <?php if ($ID == $donation->by_user_id) : ?>
                                    <a href="#" data-toggle="modal" class="btn-update_donation" data-target="#update_donation" data-donation="<?php echo $donation->id; ?>" data-nonce="<?php echo wp_create_nonce("editdonation" . $donation->id); ?>">| Edit</a>
                                    <a href="#" data-toggle="modal" class="btn-delete_donation" data-target="#delete_donation" data-donation="<?php echo $donation->id; ?>" data-nonce="<?php echo wp_create_nonce("deletedonation" . $donation->id); ?>">| Remove</a>
                                <?php endif; ?>
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
<?php
if (!defined('WPINC')) {
    die;
}
?>


<?php if (isset($_GET['added']) && $_GET['added'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully Added!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<?php if (isset($_GET['updated_risk']) && $_GET['updated_risk'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully updated!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>




<div class="container-fluid">
    <div class=" row ">
        <div class="col">
            <h3>Risk Report</h3>
        </div>
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sharp-edge float-right h4h-secondary" data-toggle="modal" data-target="#add_risk_report">
                Add Risk Report
            </button>
        </div>
    </div>

</div>



<!-- Modal -->
<div class="modal fade" id="add_risk_report" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Edit Risk Report</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="needs-validation" method="POST" novalidate>

                    <div class="container-fluid">


                        <div class="row">
                            <div class="form-group">
                                <label for="risk_report_date">Date:</label>
                                <input type="text" name="risk_report_date" class="form-control col-3 datepicker" value="" id="risk_report_date" placeholder="" autocomplete="off" required>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group">
                                <label for="concern">Outline the nature of your concern:</label>
                                <div>
                                    <textarea name="nature_concern" style="width: 100%;" id='concern' class="form-control  mt-2" rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="concern">What did you do?</label>
                                <div>
                                    <textarea name="you_did" style="width: 100%;" id='concern' class="form-control  mt-2" rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="concern">Who did you tell?</label>
                                <div>
                                    <textarea name="told_you" style="width: 100%;" id='concern' class="form-control  mt-2" rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="concern">Action taken:</label>
                                <?php $actions = array('Check in needed', 'Next of kin informed', 'Welfare Check', 'Other'); ?>
                                <div>
                                    <?php
                                    foreach ($actions as $action) :
                                    ?>
                                        <label><input type="checkbox" name="action_taken[]" value="<?php echo $action; ?>"> <?php echo $action; ?></label><br>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="concern">Outcome:</label>
                                <div>
                                    <textarea name="outcome" style="width: 100%;" id='concern' class="form-control  mt-2" rows="6"></textarea>
                                </div>
                            </div>
                        </div>




                        <input type="hidden" name="client" value="<?php echo $client_id; ?>">
                        <input type="hidden" name="added_by" value="<?php echo $ID; ?>">
                        <input type="hidden" name="action" value="add_risk_report">

                        <input type="hidden" name="curent_page" value="<?php echo  $current_url; ?>">

                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("add_risk_report"); ?>">


                        <div class="float-right">

                            <a href="/manager/my-clients/" class="btn btn-sharp-edge  btn-outline-secondary mr-2">Back to Clients</a>

                            <button type="submit" class="btn btn-sharp-edge h4h-primary btn-primary">Submit</button>

                        </div>


                    </div>

                </form>

            </div>

        </div>
    </div>
</div>


<!-- Update Modal -->
<div class="modal fade" id="update_risk_report" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Add Risk Report</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form action="" class="needs-validation risk_report-update-form" method="POST" novalidate>

                    <div class="container-fluid">


                        <div class="row">
                            <div class="form-group">
                                <label for="risk_report_date">Date:</label>
                                <input type="text" name="risk_report_date" class="form-control col-3 datepicker" value="" id="risk_report_date" placeholder="" autocomplete="off" required>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group">
                                <label for="concern">Outline the nature of your concern:</label>
                                <div>
                                    <textarea name="nature_concern" style="width: 100%;" id='nature_concern' class="form-control  mt-2" rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="concern">What did you do?</label>
                                <div>
                                    <textarea name="you_did" style="width: 100%;" id='you_did' class="form-control  mt-2" rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="concern">Who did you tell?</label>
                                <div>
                                    <textarea name="told_you" style="width: 100%;" id='told_you' class="form-control  mt-2" rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="concern">Action taken:</label>
                                <?php $actions = array('Check in needed', 'Next of kin informed', 'Welfare Check', 'Other'); ?>
                                <div>
                                    <?php
                                    foreach ($actions as $action) :
                                    ?>
                                        <label><input type="checkbox" name="action_taken[]" id="<?php echo str_replace(' ', '', $action); ?>" value="<?php echo $action; ?>"> <?php echo $action; ?></label><br>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="concern">Outcome:</label>
                                <div>
                                    <textarea name="outcome" style="width: 100%;" id='outcome' class="form-control  mt-2" rows="6"></textarea>
                                </div>
                            </div>
                        </div>




                        <input type="hidden" name="client" value="<?php echo $client_id; ?>">
                        <input type="hidden" name="added_by" value="<?php echo $ID; ?>">
                        <input type="hidden" name="mid" id="mid" value="">
                        <input type="hidden" name="action" id="action" value="update_risk_report">

                        <input type="hidden" name="curent_page" value="<?php echo  $current_url; ?>">

                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("update_risk_report"); ?>">


                        <div class="float-right">

                            <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-sharp-edge h4h-primary btn-primary">Submit</button>

                        </div>


                    </div>

                </form>

                <div class="note-loading" style='display:none'>Loading</div>

            </div>

        </div>
    </div>
</div>


<!-- View Modal -->
<div class="modal fade" id="view_risk_report" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>View Risk Report</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">


                <div class="container-fluid view-risk_report-details">


                    <div class="row">
                        <div class="form-group">
                            <label for="risk_report_date">Date:</label>
                            <div id="risk_report_date"></div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group">
                            <label for="concern">Outline the nature of your concern:</label>
                            <div>

                                <div id="nature_concern"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="concern">What did you do?</label>
                            <div>

                                <div id="you_did"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="concern">Who did you tell?</label>
                            <div>
                                <div id="told_you"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="concern">Action taken:</label>

                            <div id="action_taken"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="concern">Outcome:</label>
                            <div>
                                <div id="outcome"></div>

                            </div>
                        </div>
                    </div>





                </div>


                <div class="note-loading" style='display:none'>Loading</div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="delete_risk_report" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Confim Delete Risk Report</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">



                <div class="modal-body view-note-details">
                    Are you sure you want to remove this risk report?

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sharp-edge  btn-danger delete-risk_report-confirmed" data-donation="" data-nonce="" data-dismiss="modal">Remove</button>
            </div>
        </div>
    </div>
</div>



<div class="mt-2">

    <?php if (count($risk_reports) > 0) : ?>
        <table class="table-hover">
            <thead style="border-bottom: 1px solid #000;">
                <tr>
                    <th>Added by</th>
                    <th>Report Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($risk_reports) > 0) : ?>

                    <?php foreach ($risk_reports as $risk_report) :
                        $report = unserialize($risk_report->meta_value);
                    ?>
                        <tr>
                            <td><?php echo get_counsellor_name($report['added_by']); ?></td>
                            <td><?php echo $report['risk_report_date']; ?></td>
                            <td>
                                <a href="#" data-toggle="modal" class="btn-update_risk_report" data-target="#view_risk_report" data-risk_report="<?php echo $risk_report->umeta_id; ?>" data-nonce="<?php echo wp_create_nonce("edit_risk_report" . $risk_report->umeta_id); ?>">View</a>

                                <?php if ($ID == $report['added_by']) : ?>
                                    <a href="#" data-toggle="modal" class="btn-update_risk_report" data-target="#update_risk_report" data-risk_report="<?php echo $risk_report->umeta_id; ?>" data-nonce="<?php echo wp_create_nonce("edit_risk_report" . $risk_report->umeta_id); ?>">| Edit</a>
                                    <a href="#" data-toggle="modal" class="btn-delete_risk_report" data-target="#delete_risk_report" data-risk_report="<?php echo $risk_report->umeta_id; ?>" data-nonce="<?php echo wp_create_nonce("deleterisk_report" . $risk_report->umeta_id); ?>">| Remove</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>
        </table>
    <?php else : ?>
        <p>No risk report found</p>
    <?php endif; ?>
</div>
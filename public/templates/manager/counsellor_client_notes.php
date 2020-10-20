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
            <h3>Notes</h3>
        </div>
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sharp-edge float-right h4h-secondary" data-toggle="modal" data-target="#addNotes">
                Add Note
            </button>
        </div>
    </div>

</div>


<style>
    .dropzone {
        border: 2px dashed #bbbbbb;
    }
</style>




<!-- Modal -->
<div class="modal fade" id="addNotes" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Add Notes</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="needs-validation" method="post" novalidate>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="date_session_add">Date of Session:</label>
                        <input type="text" name="session_date" class="form-control col-3 datepicker" id="date_session_add" placeholder="" autocomplete="off" required>
                    </div>

                    <div class="form-group ">
                        <strong>DNA</strong>: No <input type="radio" name="dna" value="0" checked> Yes <input type="radio" name="dna" value="1">
                    </div>


                    <div class="form-group ">
                        <label for="note">Notes:</label>
                        <textarea name="note" class="form-control" id="note" rows="6" required></textarea>
                    </div>

                    <div class="form-group ">
                        <label for="note">File:</label>

                        <div id="media-uploader" class="dropzone"></div>
                        <input type="hidden" name="media-ids" value="">

                        <div class="upload_status"></div>

                    </div>



                    <div class="float-right">
                        <input type="hidden" name="action" id='action' value="add_client_notes">
                        <input type="hidden" name="thisnote" class='update_note'>
                        <input type="hidden" name="client" id="add_note_client" value="<?php echo $_GET['client']; ?>">
                        <input type="hidden" name="curent_page" value="<?php echo  get_permalink() . "?client=" . $_GET['client']; ?>">


                    </div>
                    <div class="clearfix"></div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_notes" class="btn  btn-sharp-edge h4h-primary btn-primary">Add Note</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Modal -->
<div class="modal fade" id="updateNote" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Update Notes</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>



            <form action="" class="needs-validation" method="post" novalidate>
                <div class="modal-body">

                    <div class='form-content-status'>Loading..</div>

                    <div class="note-update-form">

                        <div class="form-group">
                            <label for="date_session_update">Date of Session:</label>
                            <input type="text" name="session_date" class="form-control col-3 datepicker" id="date_session_update" placeholder="" autocomplete="off" required>
                        </div>

                        <div class="form-group ">
                            <strong>DNA</strong>: No <input type="radio" name="dna" id="dna_no" value="0"> Yes <input type="radio" name="dna" id="dna_yes" value="1">
                        </div>


                        <div class="form-group ">
                            <label for="note">Notes:</label>
                            <textarea name="note" class="form-control" id="note" rows="6" required></textarea>
                        </div>

                        <div class="form-group ">
                            <label for="note">Add File:</label>
                            <div id="media-uploader" class="dropzone"></div>
                            <input type="hidden" name="media-ids" value="">
                            <div class="upload_status"></div>


                            <div id="note_files_view"></div>
                        </div>

                        <div class="float-right">
                            <input type="hidden" name="action" value="update_client_notes">
                            <input type="hidden" name="client" value="<?php echo $_GET['client']; ?>">
                            <input type="hidden" name="thisnote" class='update-note' value="">
                            <input type="hidden" name="curent_page" value="<?php echo  get_permalink() . "?client=" . $_GET['client']; ?>">


                        </div>
                        <div class="clearfix"></div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_notes" class="btn  btn-sharp-edge h4h-primary btn-primary">Save Changes</button>
                </div>
            </form>


        </div>
    </div>
</div>

<!-- VIEW Modal -->
<div class="modal fade" id="viewNote" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>View Notes</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>



            <div class="modal-body">

                <div class='form-content-status'>Loading..</div>

                <div class="view-note-details">


                    <div class="form-group">
                        <label for="date_session_update">Date of Session:</label>
                        <div id="date_session_view"></div>

                    </div>

                    <div class="form-group ">
                        <strong>DNA</strong>: <span id="dna"></span>
                    </div>


                    <div class="form-group ">
                        <label for="note">Notes:</label>
                        <div id="note_view"></div>
                    </div>


                    <div class="form-group ">
                        <label for="note">Files:</label>
                        <div id="note_files_view"></div>
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
<div class="modal fade" id="deleteNote" tabindex="1" role="dialog" data-backdrop="true" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><strong>Confim Delete Note</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body view-note-details">
                Are you sure you want to delete this?<br>
                Note: All attached files will be permanently deleted.

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sharp-edge  btn-secondary" data-dismiss="modal">Cancel</button>
                <!--<button type="button" class="btn btn-sharp-edge  btn-danger" data-dismiss="modal">Remove</button>-->
                <button type="button" class="btn btn-sharp-edge  btn-danger delete-note" data-note="" data-nonce="" data-dismiss="modal">Remove</button>
            </div>
        </div>
    </div>
</div>




<div class="mt-2">

    <?php if (count($notes) > 0) : ?>
        <table class="table-hover">
            <thead style="border-bottom: 1px solid #000;">
                <tr>

                    <th>Client Name</th>
                    <th>Added by</th>
                    <th>Date of Session</>
                    <th width="65%">Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($notes) > 0) : ?>

                    <?php foreach ($notes as $note) :
                    ?>
                        <tr>
                            <td><?php echo $note->display_name; ?></td>
                            <td><?php echo $note->counsellor_name; ?></td>
                            <td><?php echo $note->session_date; ?></td>
                            <td><?php echo wp_trim_words(stripslashes($note->note), 100); ?></td>
                            <td>
                                <a href="#" data-toggle="modal" class="btn-updateNote" data-target="#viewNote" data-note="<?php echo $note->id; ?>" data-view='true' data-nonce="<?php echo wp_create_nonce("editnote"); ?>">View</a>

                                <?php if ($ID == $note->by_user_id) : ?>
                                    <a href="#" data-toggle="modal" class="btn-updateNote" data-target="#updateNote" data-note="<?php echo $note->id; ?>" data-nonce="<?php echo wp_create_nonce("editnote"); ?>">| Edit</a>
                                    <a href="#" data-toggle="modal" class="btn-deleteNote" data-target="#deleteNote" data-note="<?php echo $note->id; ?>" data-nonce="<?php echo wp_create_nonce("editnote"); ?>">| Remove</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>
        </table>
    <?php else : ?>
        <p>No notes found</p>
    <?php endif; ?>
</div>
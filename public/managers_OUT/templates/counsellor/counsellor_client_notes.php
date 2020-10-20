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
                        <label for="datesession">Date of Session:</label>
                        <input type="text" name="session_date" class="form-control col-3 datepicker" id="datesession" placeholder="" autocomplete="off" required>
                    </div>


                    <div class="form-group ">
                        <label for="note">Notes:</label>
                        <textarea name="note" class="form-control" id="note" rows="6" required></textarea>
                    </div>
                    <div class="form-group ">
                        <label for="note">File:</label>
                        <div>Soon..</div>
                    </div>

                    <div class="float-right">
                        <input type="hidden" name="action" value="add_client_notes">
                        <input type="hidden" name="client" value="<?php echo $_GET['client']; ?>">
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



<div class="mt-2">

    <?php if (count($notes) > 0) : ?>
        <table>
            <thead style="border-bottom: 1px solid #000;">
                <tr>

                    <th>Client Name</th>
                    <th>Date of Session</>
                    <th width="30%">Note</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($notes) > 0) : ?>

                    <?php foreach ($notes as $note) :
                    ?>
                        <tr>
                            <td>#<?php echo $note->display_name; ?></td>
                            <td><?php echo $note->session_date; ?></td>
                            <td><?php echo stripslashes($note->note); ?></td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>
        </table>
    <?php else : ?>
        <p>No notes found</p>
    <?php endif; ?>
</div>
<?php

if (!defined('WPINC')) {
    die;
}

?>

<?php if (isset($_GET['updated']) && $_GET['updated'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully Updated!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['added']) && $_GET['added'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully Added!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<form action="" class="needs-validation" method="post" novalidate>
    <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo get_user_meta($client_id, 'first_name', true); ?>" required>
        <div class="invalid-feedback">
            Please provide First Name
        </div>
    </div>

    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo get_user_meta($client_id, 'last_name', true); ?>" required>
        <div class="invalid-feedback">
            Please provide Last Name
        </div>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Email" name="user_email" value="<?php echo isset($client->user_email) ? $client->user_email : ""; ?>" required>
        <div class="invalid-feedback">
            Please provide email
        </div>
    </div>

    <div class="form-group">
        <label for="mob_number">Mobile Number:</label>
        <input type="text" class="form-control" id="mob_number" placeholder="Mobile Number" name="_wpc_mobile_number" value="<?php echo get_user_meta($client_id, '_wpc_mobile_number', true); ?>" required>
        <div class="invalid-feedback">
            Please provide mobile number
        </div>
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select name="wpc_cf_status" class="form-control" id="status">
            <option value="">Select</option>
            <?php foreach ($statuses as $status) : ?>
                <option <?php if ($current_status == $status['value']) echo "selected"; ?> value="<?php echo $status['value']; ?>"><?php echo $status['label']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="form-group">
        <label for="assigned_counsellor">Assign Counsellor:</label>
        <select name="wpc_cf_counsellor" class="form-control" id="assigned_counsellor">
            <option value="">Select</option>
            <?php foreach (get_counsellors() as $counsellor) : ?>
                <option value="<?php echo $counsellor->ID; ?>" <?php echo $counsellor->ID == get_user_meta($client_id, 'wpc_cf_counsellor', true) ? "selected" : ""; ?>><?php echo $counsellor->user_nicename; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php if ($client_id) : ?>
        <input type="hidden" name="client" value="<?php echo  $client_id; ?>">
        <input type="hidden" name="action" value="update">
    <?php else : ?>
        <input type="hidden" name="action" value="add">
    <?php endif; ?>

    <input type="hidden" name="curent_page" value="<?php echo  $current_url; ?>">

    <div class="float-right">
        <a href="/my-clients" class="btn btn-sharp-edge  btn-outline-secondary mr-2">Back to Clients</a>

        <?php if ($client_id) : ?>
            <button type="submit" class="btn  btn-sharp-edge h4h-primary btn-primary">Update</button>
        <?php else : ?>
            <button type="submit" class="btn btn-sharp-edge h4h-primary btn-primary">Add</button>
        <?php endif; ?>
    </div>

</form>
<?php
if (!defined('WPINC')) {
    die;
}

?>

<form action="" class="needs-validation" method="post" novalidate>
    <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" readonly class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo get_user_meta($counsellor_id, 'first_name', true); ?>" required>
        <div class="invalid-feedback">
            Please provide First Name
        </div>
    </div>

    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" readonly class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo get_user_meta($counsellor_id, 'last_name', true); ?>" required>
        <div class="invalid-feedback">
            Please provide Last Name
        </div>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" readonly class="form-control" id="email" placeholder="Email" name="user_email" value="<?php echo isset($counsellor->user_email) ? $counsellor->user_email : ""; ?>" required>
        <div class="invalid-feedback">
            Please provide email
        </div>
    </div>

    <div class="form-group">
        <label for="mob_number">Mobile Number:</label>
        <input type="text" readonly class="form-control" id="mob_number" placeholder="Mobile Number" name="_wpc_mobile_number" value="<?php echo get_user_meta($counsellor_id, '_wpc_mobile_number', true); ?>" required>
        <div class="invalid-feedback">
            Please provide mobile number
        </div>
    </div>

    <div class="float-right">
        <a href="/my-counsellors" class="btn btn-sharp-edge  btn-outline-secondary mr-2">Back to Counsellors</a>

    </div>


</form>
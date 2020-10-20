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

<?php if (isset($_GET['err']) && $_GET['err'] === '1') : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Error! Current password did not matched.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<form action="" class="" method="post">
    <div class="container-fluid">

        <h4>Personal</h4>

        <div class="row">
            <div class="form-group col">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo get_user_meta($ID, 'first_name', true); ?>" required>
                <div class="invalid-feedback">
                    Please provide First Name
                </div>
            </div>

            <div class="form-group col">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo get_user_meta($ID, 'last_name', true); ?>" required>
                <div class="invalid-feedback">
                    Please provide Last Name
                </div>
            </div>
        </div>


        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="user_email" value="<?php echo isset($current_user->user_email) ? $current_user->user_email : ""; ?>" required>
            <div class="invalid-feedback">
                Please provide email
            </div>
        </div>


        <div class="row">

            <div class="form-group col">
                <label for="mob_number">Mobile Number:</label>
                <input type="text" class="form-control" id="mob_number" placeholder="Mobile Number" name="wpc_mobile_number" value="<?php echo get_user_meta($ID, '_wpc_mobile_number', true); ?>">
                <div class="invalid-feedback">
                    Please provide mobile number
                </div>
            </div>

            <div class="form-group col">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" placeholder="Phone Number" name="wpc_phone_number" value="<?php echo get_user_meta($ID, '_wpc_phone_number', true); ?>">
                <div class="invalid-feedback">
                    Please provide mobile number
                </div>
            </div>

        </div>

        <div class="row">
            <div class="form-group col">
                <label for="desc">About Me:</label>
                <textarea name="description" class="form-control" id="desc" rows="6"><?php echo get_user_meta($ID, 'description', true) == '' ? "" : get_user_meta($ID, 'description', true);
                                                                                        ?></textarea>
            </div>
        </div>

        <input type="hidden" name="curent_page" value="<?php echo  get_permalink(); ?>">
        <input type="hidden" name="action" value="update_my_profile">


        <div class="float-right">
            <button type="submit" name="update_profile" class="btn  btn-sharp-edge h4h-primary btn-primary">Update Profile</button>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

<form action="" class="" method="post">

    <div class="container-fluid">

        <h4>Account</h4>

        <div class="row">

            <div class="form-group col">
                <label for="pass">Current Password:</label>
                <input type="password" class="form-control" id="pass" placeholder="New Password" name="password" value="">

            </div>

            <div class="form-group col">
                <label for="pass_con">New Password:</label>
                <input type="password" class="form-control" id="pass_con" placeholder="Confirm New Password" name="_password" value="">
                <em>Note: You will be redirected to the login page, please use your updated password.</em>
            </div>

        </div>





        <input type="hidden" name="curent_page" value="<?php echo  get_permalink(); ?>">
        <input type="hidden" name="action" value="update_my_profile">


        <div class="float-right">
            <button type="submit" name="update_pass" class="btn  btn-sharp-edge h4h-secondary">Update Password</button>

        </div>
        <div class="clearfix"></div>
    </div>

</form>
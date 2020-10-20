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

<?php if (isset($_GET['err']) && $_GET['err'] === '2') : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Error: Email already exists!
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

<style>
    select.ui-datepicker-month,
    .ui-datepicker-year {
        min-width: auto;
    }
</style>


<form action="" class="needs-validation" method="post" novalidate>

    <div class="container-fluid">

        <h4>Personal</h4>

        <div class="row">
            <div class="form-group col">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo isset($_GET['fname']) ? $_GET['fname'] : get_user_meta($client_id, 'first_name', true); ?>" required>
                <div class="invalid-feedback">
                    Please provide First Name
                </div>
            </div>

            <div class="form-group  col">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo  isset($_GET['lname']) ? $_GET['lname'] : get_user_meta($client_id, 'last_name', true); ?>" required>
                <div class="invalid-feedback">
                    Please provide Last Name
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="user_email" value="<?php echo isset($client->user_email) ? $client->user_email : ""; ?>" required>
                <div class="invalid-feedback">
                    Please provide email
                </div>
            </div>

            <div class="form-group col">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date_of_birth" autocomplete="off" class="form-control datepicker_birth" id="date_of_birth" placeholder="Date of Birth" name="date_of_birth" value="<?php echo  isset($_GET['date_of_birth']) ? $_GET['date_of_birth'] :  get_user_meta($client_id, 'date_of_birth', true); ?>">
                <div class="invalid-feedback">
                    Please provide date of birth
                </div>
            </div>
        </div>


        <div class="row">

            <div class="form-group col">
                <label for="mob_number">Mobile Number:</label>
                <input type="text" class="form-control" id="mob_number" placeholder="Mobile Number" name="_wpc_mobile_number" value="<?php echo  isset($_GET['mob']) ? $_GET['mob'] :  get_user_meta($client_id, '_wpc_mobile_number', true); ?>">
                <div class="invalid-feedback">
                    Please provide mobile number
                </div>
            </div>

            <div class="form-group col">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" placeholder="Phone Number" name="wpc_cf_phone_number" value="<?php echo  isset($_GET['phone']) ? $_GET['phone'] :  get_user_meta($client_id, 'wpc_cf_phone_number', true); ?>">
                <div class="invalid-feedback">
                    Please provide mobile number
                </div>
            </div>


        </div>


        <div class="row">

            <div class="form-group col">
                <label for="address1">Address 1:</label>
                <input type="text" class="form-control" id="address1" placeholder="Address 1" name="address_1" value="<?php echo  isset($_GET['address1']) ? $_GET['address1'] :  get_user_meta($client_id, 'address_1', true);
                                                                                                                        ?>">

            </div>

            <div class="form-group col">
                <label for="address_2">Address 2:</label>
                <input type="text" class="form-control" id="address_2" placeholder="Address 2" name="address_2" value="<?php echo  isset($_GET['address2']) ? $_GET['address2'] :  get_user_meta($client_id, 'address_2', true);
                                                                                                                        ?>">

            </div>


        </div>

        <div class="row">

            <div class="form-group col">
                <label for="town">Town:</label>
                <input type="text" class="form-control" id="town" placeholder="Town" name="town" value="<?php echo  isset($_GET['town']) ? $_GET['town'] :  get_user_meta($client_id, 'town', true);
                                                                                                        ?>">

            </div>

            <div class="form-group col">
                <label for="post_code">Post Code:</label>
                <input type="text" class="form-control" id="post_code" placeholder="Post Code" name="post_code" value="<?php echo  isset($_GET['post_code']) ? $_GET['post_code'] :  get_user_meta($client_id, 'post_code', true);
                                                                                                                        ?>">

            </div>


        </div>


        <h4>Next of kin </h4>

        <div class="row">

            <div class="form-group col">
                <label for="kin_name">Name:</label>
                <input type="text" class="form-control" id="kin_name" placeholder="Name of kin" name="kin_name" value="<?php echo  isset($_GET['kin_name']) ? $_GET['kin_name'] :  get_user_meta($client_id, 'kin_name', true);
                                                                                                                        ?>">

            </div>

            <div class="form-group col">
                <label for="kin_email">Email:</label>
                <input type="email" class="form-control" id="kin_email" placeholder="Email of kin" name="kin_email" value="<?php echo  isset($_GET['kin_email']) ? $_GET['kin_email'] :  get_user_meta($client_id, 'kin_email', true);
                                                                                                                            ?>">
                <div class="invalid-feedback">
                    Please provide valid email
                </div>

            </div>


        </div>

        <div class="row">

            <div class="form-group col">
                <label for="kin_phone">Phone Number:</label>
                <input type="text" class="form-control" id="kin_phone" placeholder="Phone Number of kin" name="kin_phone" value="<?php echo  isset($_GET['kin_phone']) ? $_GET['kin_phone'] :  get_user_meta($client_id, 'kin_phone', true);
                                                                                                                                    ?>">

            </div>

            <div class="form-group col"></div>


        </div>


        <h4>GP </h4>

        <div class="row">

            <div class="form-group col">
                <label for="gp_name">Name:</label>
                <input type="text" class="form-control" id="gp_name" placeholder="Name of GP" name="gp_name" value="<?php echo  isset($_GET['gp_name']) ? $_GET['gp_name'] :  get_user_meta($client_id, 'gp_name', true);
                                                                                                                    ?>">

            </div>

            <div class="form-group col">
                <label for="gp_email">Email:</label>
                <input type="email" class="form-control" id="gp_email" placeholder="Email of GP" name="gp_email" value="<?php echo  isset($_GET['gp_email']) ? $_GET['gp_email'] :  get_user_meta($client_id, 'gp_email', true);
                                                                                                                        ?>">
                <div class="invalid-feedback">
                    Please provide valid email
                </div>

            </div>


        </div>

        <div class="row">

            <div class="form-group col">
                <label for="gp_phone">Phone Number:</label>
                <input type="text" class="form-control" id="gp_phone" placeholder="Phone Number of GP" name="gp_phone" value="<?php echo  isset($_GET['gp_phone']) ? $_GET['gp_phone'] :  get_user_meta($client_id, 'gp_phone', true);
                                                                                                                                ?>">

            </div>

            <div class="form-group col"></div>


        </div>

        <div class="row">
            <div class="form-group col">
                <label for="gp_surgery_name">Surgery Name:</label>
                <input type="text" class="form-control" id="gp_surgery_name" placeholder="Surgery Name" name="gp_surgery_name" value="<?php echo  isset($_GET['gp_surgery_name']) ? $_GET['gp_surgery_name'] :  get_user_meta($client_id, 'gp_surgery_name', true);
                                                                                                                                        ?>">

            </div>

            <div class="form-group col">
                <label for="gp_surgery_address">Surgery Address:</label>
                <input type="text" class="form-control" id="gp_surgery_address" placeholder="Surgery Address" name="gp_surgery_address" value="<?php echo  isset($_GET['gp_surgery_address']) ? $_GET['gp_surgery_address'] :  get_user_meta($client_id, 'gp_surgery_address', true);
                                                                                                                                                ?>">

            </div>

        </div>

        <div class="row">
            <div class="form-group col">
                <label for="gp_surgery_town">Surgery Town:</label>
                <input type="text" class="form-control" id="gp_surgery_town" placeholder="Town" name="gp_surgery_town" value="<?php echo  isset($_GET['gp_surgery_town']) ? $_GET['gp_surgery_town'] :  get_user_meta($client_id, 'gp_surgery_town', true);
                                                                                                                                ?>">

            </div>

            <div class="form-group col">
                <label for="gp_surgery_postcode">Surgery Post Code:</label>
                <input type="text" class="form-control" id="gp_surgery_postcode" placeholder="Post Code" name="gp_surgery_postcode" value="<?php echo  isset($_GET['gp_surgery_postcode']) ? $_GET['gp_surgery_postcode'] :  get_user_meta($client_id, 'gp_surgery_postcode', true);
                                                                                                                                            ?>">

            </div>

        </div>

        <hr>

        <div class="row">

            <div class="form-group col">
                <label for="first_appointment">First Appointment:</label>
                <input type="text" class="form-control datepicker" id="first_appointment" placeholder="" name="_first_appointment" value="<?php echo $client_id == '' ? date("Y-m-d") : get_user_meta($client_id, 'wpc_cf_first_appointment', true)
                                                                                                                                            ?>">
            </div>

            <div class="form-group col">
                <label for="first_appointment">DNA (Did Not Attend):</label>
                <div>
                    <span><strong>Status: </strong> <?php echo get_user_meta($client_id, 'dna_status', true) == 0 ? "No" : "Yes"; ?></span>
                    <span><strong>Count: </strong> <?php echo count_dna_total($client_id); ?></span>
                </div>

            </div>


        </div>


        <div class="row">

            <div class="form-group col">
                <label for="status">Status: </label>
                <select name="wpc_cf_status" class="form-control" id="status">
                    <option value="">Select</option>
                    <?php foreach ($statuses as $status) : ?>
                        <?php if ($client_id == '' and $current_status == '' and $status['value'] == 'Initiated') : ?>
                            <option selected="selected" value="<?php echo $status['value']; ?>"><?php echo $status['label']; ?></option>
                        <?php else : ?>
                            <option <?php if ($current_status == $status['value']) echo "selected='selected'"; ?> value="<?php echo $status['value']; ?>"><?php echo $status['label']; ?></option>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </select>
            </div>

            <?php if ($client_id != '') : ?>
                <div class="form-group col">
                    <label for="assigned_counsellor">Assign Counsellor:</label>
                    <select name="wpc_cf_counsellor" class="form-control" id="assigned_counsellor">
                        <option value="">Select</option>
                        <?php foreach (get_counsellors() as $counsellor) : ?>
                            <option value="<?php echo $counsellor->ID; ?>" <?php echo $counsellor->ID == get_user_meta($client_id, 'wpc_cf_counsellor', true) ? "selected" : ""; ?>><?php echo $counsellor->first_name . " " . $counsellor->last_name . " (" . $counsellor->user_email . ")"; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php endif; ?>

        </div>

        <?php if ($client_id) : ?>
            <input type="hidden" name="client" value="<?php echo  $client_id; ?>">
            <input type="hidden" name="action" value="update">
        <?php else : ?>
            <input type="hidden" name="action" value="add">
        <?php endif; ?>

        <input type="hidden" name="curent_page" value="<?php echo  $current_url; ?>">

        <div class="float-right">
            <a href="/manager/my-clients/" class="btn btn-sharp-edge  btn-outline-secondary mr-2">Back to Clients</a>

            <?php if ($client_id) : ?>
                <button type="submit" class="btn  btn-sharp-edge h4h-primary btn-primary">Update</button>
            <?php else : ?>
                <button type="submit" class="btn btn-sharp-edge h4h-primary btn-primary">Add</button>
            <?php endif; ?>
        </div>

    </div>

</form>
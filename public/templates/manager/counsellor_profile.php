<?php
if (!defined('WPINC')) {
    die;
}

?>

<?php if (isset($_GET['err']) && $_GET['err'] === '2') : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Error: Email already exists!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>



<?php if (isset($_GET['updated']) && $_GET['updated'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully Updated!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>



<form action="" class="needs-validation" method="post" novalidate>

    <div class="container-fluid">

        <h4>Personal</h4>

        <div class="row">
            <div class="form-group col">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo get_user_meta($counsellor_id, 'first_name', true); ?>" required>
                <div class="invalid-feedback">
                    Please provide First Name
                </div>
            </div>

            <div class="form-group col">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo get_user_meta($counsellor_id, 'last_name', true); ?>" required>
                <div class="invalid-feedback">
                    Please provide Last Name
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="user_email" value="<?php echo isset($counsellor->user_email) ? $counsellor->user_email : ""; ?>" required>
            <div class="invalid-feedback">
                Please provide email
            </div>
        </div>

        <div class="row">

            <div class="form-group col">
                <label for="mob_number">Mobile Number:</label>
                <input type="text" class="form-control" id="mob_number" placeholder="Mobile Number" name="_wpc_mobile_number" value="<?php echo get_user_meta($counsellor_id, '_wpc_mobile_number', true); ?>">
                <div class="invalid-feedback">
                    Please provide mobile number
                </div>
            </div>

            <div class="form-group col">
                <label for="mob_number">Phone Number:</label>
                <input type="text" class="form-control" id="mob_number" placeholder="Mobile Number" name="wpc_phone_number" value="<?php echo get_user_meta($counsellor_id, 'wpc_cf_phone_number', true); ?>">
                <div class="invalid-feedback">
                    Please provide mobile number
                </div>
            </div>

        </div>

        <div class="row">

            <div class="form-group col">
                <label for="address1">Address 1:</label>
                <input type="text" class="form-control" id="address1" placeholder="Address 1" name="address_1" value="<?php echo   get_user_meta($counsellor_id, 'address_1', true);
                                                                                                                        ?>">

            </div>

            <div class="form-group col">
                <label for="address_2">Address 2:</label>
                <input type="text" class="form-control" id="address_2" placeholder="Address 2" name="address_2" value="<?php echo   get_user_meta($counsellor_id, 'address_2', true);
                                                                                                                        ?>">

            </div>


        </div>

        <div class="row">

            <div class="form-group col">
                <label for="town">Town:</label>
                <input type="text" class="form-control" id="town" placeholder="Town" name="town" value="<?php echo  get_user_meta($counsellor_id, 'town', true);
                                                                                                        ?>">

            </div>

            <div class="form-group col">
                <label for="post_code">Post Code:</label>
                <input type="text" class="form-control" id="post_code" placeholder="Post Code" name="post_code" value="<?php echo get_user_meta($counsellor_id, 'post_code', true);
                                                                                                                        ?>">

            </div>


        </div>


        <h4>Next of kin </h4>

        <div class="row">

            <div class="form-group col">
                <label for="kin_name">Name:</label>
                <input type="text" class="form-control" id="kin_name" placeholder="Name of kin" name="kin_name" value="<?php echo  isset($_GET['kin_name']) ? $_GET['kin_name'] :  get_user_meta($counsellor_id, 'kin_name', true);
                                                                                                                        ?>">

            </div>

            <div class="form-group col">
                <label for="kin_email">Email:</label>
                <input type="email" class="form-control" id="kin_email" placeholder="Name of kin" name="kin_email" value="<?php echo  isset($_GET['kin_email']) ? $_GET['kin_email'] :  get_user_meta($counsellor_id, 'kin_email', true);
                                                                                                                            ?>">
                <div class="invalid-feedback">
                    Please provide valid email
                </div>

            </div>


        </div>

        <div class="row">

            <div class="form-group col">
                <label for="kin_phone">Phone Number:</label>
                <input type="text" class="form-control" id="kin_phone" placeholder="Number of kin" name="kin_phone" value="<?php echo  isset($_GET['kin_phone']) ? $_GET['kin_phone'] :  get_user_meta($counsellor_id, 'kin_phone', true);
                                                                                                                            ?>">

            </div>

            <div class="form-group col"></div>


        </div>

        <hr>

        <div class="row">
            <div class="form-group col d-flex flex-wrap">
                <label for="status">Availablity:</label>

                <div class="form-check ml-3 mr-3">
                    <input class="form-check-input day" type="checkbox" value="monday" name="day[]" id="monday" <?php echo !empty($availability['monday']) ? "checked" : "";
                                                                                                                ?>>
                    <label class="form-check-label" for="monday">
                        Monday
                    </label><br />
                    <div class="day-hide" style=" <?php echo !empty($availability['monday']) ? "display:block" : "display:none";
                                                    ?>">
                        <div>
                            <input class="form-check-input " type="checkbox" value="am" name="monday[]" id="monday_am" <?php echo !empty($availability['monday']) && ((isset($availability['monday'][0]) && $availability['monday'][0] == 'am') || (isset($availability['monday'][1]) && $availability['monday'][1]  == 'am')) ? "checked" : "";
                                                                                                                        ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="monday_am">
                                AM
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="pm" name="monday[]" id="monday_pm" <?php echo !empty($availability['monday']) && ((isset($availability['monday'][0]) && $availability['monday'][0] == 'pm') || (isset($availability['monday'][1]) && $availability['monday'][1] == 'pm')) ? "checked" : "";
                                                                                                                        ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="monday_pm">
                                PM
                            </label>

                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="evening" name="monday[]" id="monday_evening" <?php echo !empty($availability['monday']) && ((isset($availability['monday'][0]) && $availability['monday'][0] == 'evening') || (isset($availability['monday'][1]) && $availability['monday'][1] == 'evening') || (isset($availability['monday'][2]) && $availability['monday'][2] == 'evening')) ? "checked" : "";
                                                                                                                                ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="monday_evening">
                                Evening
                            </label>

                        </div>
                    </div>
                </div>


                <div class="form-check mr-3">
                    <input class="form-check-input day" type="checkbox" value="tuesday" name="day[]" id="tuesday" <?php echo !empty($availability['tuesday']) ? "checked" : "";
                                                                                                                    ?>>
                    <label class="form-check-label" for="tuesday">
                        Tuesday
                    </label>
                    <br />
                    <div class="day-hide" style=" <?php echo !empty($availability['tuesday']) ? "display:block" : "display:none";
                                                    ?>">
                        <div>
                            <input class="form-check-input " type="checkbox" value="am" name="tuesday[]" id="tuesday_am" <?php echo !empty($availability['tuesday']) && ((isset($availability['tuesday'][0]) && $availability['tuesday'][0] == 'am') || (isset($availability['tuesday'][1]) && $availability['tuesday'][1]  == 'am')) ? "checked" : "";
                                                                                                                            ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="tuesday_am">
                                AM
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="pm" name="tuesday[]" id="tuesday_pm" <?php echo !empty($availability['tuesday']) && ((isset($availability['tuesday'][0]) && $availability['tuesday'][0] == 'pm') || (isset($availability['tuesday'][1]) && $availability['tuesday'][1]  == 'pm')) ? "checked" : "";
                                                                                                                        ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="tuesday_pm">
                                PM
                            </label>

                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="evening" name="tuesday[]" id="tuesday_evening" <?php echo !empty($availability['tuesday']) && ((isset($availability['tuesday'][0]) && $availability['tuesday'][0] == 'evening') || (isset($availability['tuesday'][1]) && $availability['tuesday'][1] == 'evening') || (isset($availability['tuesday'][2]) && $availability['tuesday'][2] == 'evening')) ? "checked" : "";
                                                                                                                                    ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="tuesday_evening">
                                Evening
                            </label>

                        </div>

                    </div>

                </div>

                <div class="form-check mr-3">
                    <input class="form-check-input day" type="checkbox" value="wednesday" name="day[]" id="wednesday" <?php echo !empty($availability['wednesday']) ? "checked" : "";
                                                                                                                        ?>>
                    <label class="form-check-label" for="wednesday">
                        Wednesday
                    </label>
                    <br />
                    <div class="day-hide" style=" <?php echo !empty($availability['wednesday']) ? "display:block" : "display:none";
                                                    ?>">
                        <div>
                            <input class="form-check-input " type="checkbox" value="am" name="wednesday[]" id="wednesday_am" <?php echo !empty($availability['wednesday']) && ((isset($availability['wednesday'][0]) && $availability['wednesday'][0] == 'am') || (isset($availability['wednesday'][1]) && $availability['wednesday'][1]  == 'am')) ? "checked" : "";
                                                                                                                                ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="wednesday_am">
                                AM
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="pm" name="wednesday[]" id="wednesday_pm" <?php echo !empty($availability['wednesday']) && ((isset($availability['wednesday'][0]) && $availability['wednesday'][0] == 'pm') || (isset($availability['wednesday'][1]) && $availability['wednesday'][1]  == 'pm')) ? "checked" : "";
                                                                                                                            ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="wednesday_pm">
                                PM
                            </label>

                        </div>

                        <div>
                            <input class="form-check-input" type="checkbox" value="evening" name="wednesday[]" id="wednesday_evening" <?php echo !empty($availability['wednesday']) && ((isset($availability['wednesday'][0]) && $availability['wednesday'][0] == 'evening') || (isset($availability['wednesday'][1]) && $availability['wednesday'][1] == 'evening') || (isset($availability['wednesday'][2]) && $availability['wednesday'][2] == 'evening')) ? "checked" : "";
                                                                                                                                        ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="wednesday_evening">
                                Evening
                            </label>

                        </div>

                    </div>
                </div>

                <div class="form-check mr-3">
                    <input class="form-check-input day" type="checkbox" value="thursday" name="day[]" id="thursday" <?php echo !empty($availability['thursday']) ? "checked" : "";
                                                                                                                    ?>>
                    <label class="form-check-label" for="thursday">
                        Thursday
                    </label>
                    <br />
                    <div class="day-hide" style=" <?php echo !empty($availability['thursday']) ? "display:block" : "display:none";
                                                    ?>">
                        <div>
                            <input class="form-check-input " type="checkbox" value="am" name="thursday[]" id="thursday_am" <?php echo !empty($availability['thursday']) && ((isset($availability['thursday'][0]) && $availability['thursday'][0] == 'am') || (isset($availability['thursday'][1]) && $availability['thursday'][1]  == 'am')) ? "checked" : "";
                                                                                                                            ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="thursday_am">
                                AM
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="pm" name="thursday[]" id="thurdays_pm" <?php echo !empty($availability['thursday']) && ((isset($availability['thursday'][0]) && $availability['thursday'][0] == 'pm') || (isset($availability['thursday'][1]) && $availability['thursday'][1]  == 'pm')) ? "checked" : "";
                                                                                                                            ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="thurdays_pm">
                                PM
                            </label>

                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="evening" name="thursday[]" id="thursday_evening" <?php echo !empty($availability['thursday']) && ((isset($availability['thursday'][0]) && $availability['thursday'][0] == 'evening') || (isset($availability['thursday'][1]) && $availability['thursday'][1] == 'evening') || (isset($availability['thursday'][2]) && $availability['thursday'][2] == 'evening')) ? "checked" : "";
                                                                                                                                    ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="thursday_evening">
                                Evening
                            </label>

                        </div>

                    </div>
                </div>

                <div class="form-check mr-3">
                    <input class="form-check-input day" type="checkbox" value="friday" name="day[]" id="friday" <?php echo !empty($availability['friday']) ? "checked" : "";
                                                                                                                ?>>
                    <label class="form-check-label" for="friday">
                        Friday
                    </label>
                    <br />

                    <div class="day-hide" style=" <?php echo !empty($availability['friday']) ? "display:block" : "display:none";
                                                    ?>">
                        <div>
                            <input class="form-check-input " type="checkbox" value="am" name="friday[]" id="friday_am" <?php echo !empty($availability['friday']) && ((isset($availability['friday'][0]) && $availability['friday'][0] == 'am') || (isset($availability['friday'][1]) && $availability['friday'][1]  == 'am')) ? "checked" : "";
                                                                                                                        ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="friday_am">
                                AM
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="pm" name="friday[]" id="friday_pm" <?php echo !empty($availability['friday']) && ((isset($availability['friday'][0]) && $availability['friday'][0] == 'pm') || (isset($availability['friday'][1]) && $availability['friday'][1]  == 'pm')) ? "checked" : "";
                                                                                                                        ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="friday_pm">
                                PM
                            </label>

                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="evening" name="friday[]" id="friday_evening" <?php echo !empty($availability['friday']) && ((isset($availability['friday'][0]) && $availability['friday'][0] == 'evening') || (isset($availability['friday'][1]) && $availability['friday'][1] == 'evening') || (isset($availability['friday'][2]) && $availability['friday'][2] == 'evening')) ? "checked" : "";
                                                                                                                                ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="friday_evening">
                                Evening
                            </label>

                        </div>

                    </div>

                </div>

                <div class="form-check mr-3">
                    <input class="form-check-input day" type="checkbox" value="saturday" name="day[]" id="saturday" <?php echo !empty($availability['saturday']) ? "checked" : "";
                                                                                                                    ?>>
                    <label class="form-check-label" for="saturday">
                        Saturday
                    </label>
                    <br />
                    <div class="day-hide" style=" <?php echo !empty($availability['saturday']) ? "display:block" : "display:none";
                                                    ?>">
                        <div>
                            <input class="form-check-input " type="checkbox" value="am" name="saturday[]" id="saturday_am" <?php echo !empty($availability['saturday']) && ((isset($availability['saturday'][0]) && $availability['saturday'][0] == 'am') || (isset($availability['saturday'][1]) && $availability['saturday'][1]  == 'am')) ? "checked" : "";
                                                                                                                            ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="saturday_am">
                                AM
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="pm" name="saturday[]" id="saturday_pm" <?php echo !empty($availability['saturday']) && ((isset($availability['saturday'][0]) && $availability['saturday'][0] == 'pm') || (isset($availability['saturday'][1]) && $availability['saturday'][1]  == 'pm')) ? "checked" : "";
                                                                                                                            ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="saturday_pm">
                                PM
                            </label>

                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="evening" name="saturday[]" id="saturday_evening" <?php echo !empty($availability['saturday']) && ((isset($availability['saturday'][0]) && $availability['saturday'][0] == 'evening') || (isset($availability['saturday'][1]) && $availability['saturday'][1] == 'evening') || (isset($availability['saturday'][2]) && $availability['saturday'][2] == 'evening')) ? "checked" : "";
                                                                                                                                    ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="saturday_evening">
                                Evening
                            </label>

                        </div>

                    </div>

                </div>


                <div class="form-check mr-3">
                    <input class="form-check-input day" type="checkbox" value="sunday" name="day[]" id="sunday" <?php echo !empty($availability['sunday']) ? "checked" : "";
                                                                                                                ?>>
                    <label class="form-check-label" for="sunday">
                        Sunday
                    </label>
                    <br />

                    <div class="day-hide" style=" <?php echo !empty($availability['sunday']) ? "display:block" : "display:none";
                                                    ?>">
                        <div>
                            <input class="form-check-input " type="checkbox" value="am" name="sunday[]" id="sunday_am" <?php echo !empty($availability['sunday']) && ((isset($availability['sunday'][0]) && $availability['sunday'][0] == 'am') || (isset($availability['sunday'][1]) && $availability['sunday'][1]  == 'am')) ? "checked" : "";
                                                                                                                        ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="sunday_am">
                                AM
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="pm" name="sunday[]" id="sunday_pm" <?php echo !empty($availability['sunday']) && ((isset($availability['sunday'][0]) && $availability['sunday'][0] == 'pm') || (isset($availability['sunday'][1]) && $availability['sunday'][1]  == 'pm')) ? "checked" : "";
                                                                                                                        ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="sunday_pm">
                                PM
                            </label>

                        </div>
                        <div>
                            <input class="form-check-input" type="checkbox" value="evening" name="sunday[]" id="sunday_evening" <?php echo !empty($availability['sunday']) && ((isset($availability['sunday'][0]) && $availability['sunday'][0] == 'evening') || (isset($availability['sunday'][1]) && $availability['sunday'][1] == 'evening') || (isset($availability['sunday'][2]) && $availability['sunday'][2] == 'evening')) ? "checked" : "";
                                                                                                                                ?>>
                            <label class="form-check-label" style="font-size: 12px;" for="sunday_evening">
                                Evening
                            </label>

                        </div>

                    </div>
                </div>


            </div>
        </div>


        <div class="row">
            <div class="form-group col d-flex flex-wrap">
                <label for="desc">Student: </label>

                <div class="form-check ml-3">
                    <input class="form-check-input" type="radio" name="student" id="student_yes" value="yes" <?php echo !empty($student) && $student[0] == 'yes'  ? "checked" : "";
                                                                                                                ?>>
                    <label class="form-check-label" for="student_yes">
                        Yes
                    </label>
                </div>

                <div class="form-check ml-3">
                    <input class="form-check-input" type="radio" name="student" id="student_no" value="no" <?php echo !empty($student) && $student[0] == 'no'  ? "checked" : "";
                                                                                                            ?>>
                    <label class="form-check-label" for="student_no">
                        No
                    </label>
                </div>
            </div>
        </div>

        <input type="hidden" name="action" value="update_counsellor">
        <input type="hidden" name="counsellor" value="<?php echo $counsellor_id; ?>">
        <input type="hidden" name="curent_page" value="<?php echo  get_permalink(); ?>?counsellor=<?php echo $counsellor_id; ?>">

        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("update_counsellor"); ?>">


        <div class="float-right">
            <a href="/my-counsellors" class="btn btn-sharp-edge  btn-outline-secondary mr-2">Back to Counsellors</a>
            <button type="submit" class="btn btn-sharp-edge h4h-primary btn-primary">Update</button>
        </div>

    </div>

</form>
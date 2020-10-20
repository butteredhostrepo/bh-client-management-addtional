<?php
if (!defined('WPINC')) {
    die;
}
?>

<style>
    .form-group {
        width: 100%;
    }

    select {
        min-width: 250px;

    }
</style>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('select').change(function() {
            var thisval = jQuery(this).val();

            if (thisval == 'Other' || thisval == 'Yes') {
                jQuery(this).parent().find('textarea').show();
                jQuery(this).parent().find('.hide').show();
            } else {
                jQuery(this).parent().find('textarea').hide();
                jQuery(this).parent().find('.hide').hide();
            }
        });
    });
</script>



<?php if (isset($_GET['added']) && $_GET['added'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully Added!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>



<?php if (isset($_GET['updated_referral']) && $_GET['updated_referral'] === 'true') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully updated!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<form action="" class="needs-validation" method="POST" novalidate>

    <div class="container-fluid">

        <h3>Referral Assessment</h3>


        <div class="row">
            <div class="form-group">
                <label for="hear_about_us">How did the client hear about us:</label>
                <div class="input-group">
                    <select name="hear_about_us" id="hear_about_us" <?php echo $readOnly; ?>>
                        <option value="">Please choose</option>
                        <option value="Personal recommendation" <?php echo (isset($referral_assessment['hear_about_us']) &&  $referral_assessment['hear_about_us'] == 'Personal recommendation') ? "selected='selected'" : "";  ?>>Personal recommendation</option>
                        <option value="Social media advertising" <?php echo (isset($referral_assessment['hear_about_us']) && $referral_assessment['hear_about_us'] == 'Social media advertising') ? "selected='selected'" : "";  ?>>Social media advertising</option>
                        <option value="Google Ads" <?php echo (isset($referral_assessment['hear_about_us']) && $referral_assessment['hear_about_us'] == 'Google Ads') ? "selected='selected'" : "";  ?>>Google Ads</option>
                        <option value="Partner referral" <?php echo (isset($referral_assessment['hear_about_us']) && $referral_assessment['hear_about_us'] == 'Partner referral') ? "selected='selected'" : "";  ?>>Partner referral</option>
                        <option value="Internal referral" <?php echo (isset($referral_assessment['hear_about_us']) && $referral_assessment['hear_about_us'] == 'Internal referral') ? "selected='selected'" : "";  ?>>Internal referral</option>
                        <option value="Other" <?php echo (isset($referral_assessment['hear_about_us']) && $referral_assessment['hear_about_us'] == 'Other') ? "selected='selected'" : "";  ?>>Other (Please specify)</option>
                    </select>
                    <textarea <?php echo $readOnly; ?> name="hear_about_us_other" style="width: 100%; <?php echo (isset($referral_assessment['hear_about_us']) && $referral_assessment['hear_about_us'] == 'Other') ? "" : "display: none;";  ?>" class="form-control mt-2" id="desc" rows="6"><?php echo isset($referral_assessment['hear_about_us_other']) ? $referral_assessment['hear_about_us_other'] : ''; ?></textarea>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="form-group">
                <label for="health_problems">Has the Client had any emotional or mental health problems?</label>
                <div>


                    <?php $actions = array('No', 'Depression', 'Anxiety', 'PTSD', 'Bi-polar', 'BPD', 'COVID-19', 'Other'); ?>

                    <?php
                    foreach ($actions as $action) :
                    ?>
                        <label><input type="checkbox" name="health_problems[]" <?php echo $readOnly; ?> value="<?php echo $action; ?>" <?php //print_r($referral_assessment);
                                                                                                                                        if (isset($referral_assessment['health_problems']) && !empty($referral_assessment['health_problems'])) {
                                                                                                                                            if (in_array($action, $referral_assessment['health_problems']))
                                                                                                                                                echo 'checked';
                                                                                                                                        }
                                                                                                                                        ?>> <?php echo $action; ?></label><br>
                    <?php
                    endforeach;
                    ?>


                    <textarea <?php echo $readOnly; ?> name="health_problems_other" style="width: 100%; <?php //echo (isset($referral_assessment['health_problems']) && $referral_assessment['health_problems'] == 'Other') ? "" : "display: none;";  
                                                                                                        ?>" class="form-control  mt-2" id="desc" rows="6"><?php echo isset($referral_assessment['health_problems_other']) ? $referral_assessment['health_problems_other'] : ''; ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="aggressive_behaviour" id="aggressive_behaviour">Any recent history of violent or aggressive behaviour?</label>
                <div>
                    <select name="aggressive_behaviour" id="aggressive_behaviour" <?php echo $readOnly; ?>>
                        <option value="">Please choose</option>
                        <option value="No" <?php echo (isset($referral_assessment['aggressive_behaviour']) && $referral_assessment['aggressive_behaviour'] == 'No') ? "selected='selected'" : "";  ?>>No</option>
                        <option value="Yes" <?php echo (isset($referral_assessment['aggressive_behaviour']) && $referral_assessment['aggressive_behaviour'] == 'Yes') ? "selected='selected'" : "";  ?>>Yes (Please specify)</option>
                    </select>
                    <textarea <?php echo $readOnly; ?> name="aggressive_behaviour_other" style="width: 100%; <?php echo (isset($referral_assessment['aggressive_behaviour']) && $referral_assessment['aggressive_behaviour'] == 'Yes') ? "" : "display: none;";  ?>" class="form-control  mt-2" id="desc" rows="6"><?php echo isset($referral_assessment['aggressive_behaviour_other']) ? $referral_assessment['aggressive_behaviour_other'] : ''; ?></textarea>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="self_harming" id="self_harming">Current or historical self harming? </label>
                <div>
                    <select name="self_harming" id="self_harming" <?php echo $readOnly; ?>>
                        <option value="">Please choose</option>
                        <option value="No" <?php echo (isset($referral_assessment['self_harming']) && $referral_assessment['self_harming'] == 'No') ? "selected='selected'" : "";  ?>>No</option>
                        <option value="Yes" <?php echo (isset($referral_assessment['self_harming']) && $referral_assessment['self_harming'] == 'Yes') ? "selected='selected'" : "";  ?>>Yes (Please specify)</option>
                    </select>
                    <div class="hide  mt-2" style=" <?php echo $referral_assessment['self_harming'] == 'Yes' ? "" : "display: none;";  ?>">
                        <label for="historical">If Yes:</label> Current
                        <input type="radio" id="historical" name="historical" value="Current" <?php echo (isset($referral_assessment['historical']) &&  $referral_assessment['historical'] == 'Current') ? "checked='checked'" : "";  ?>>
                        History <input type="radio" id="historical" name="historical" value="History" <?php echo (isset($referral_assessment['historical']) && $referral_assessment['historical'] == 'History') ? "checked='checked'" : "";  ?>>

                        <textarea <?php echo $readOnly; ?> name="self_harming_other" style="width: 100%; <?php echo (isset($referral_assessment['self_harming']) &&  $referral_assessment['self_harming'] == 'Yes') ? "" : "display: none;";  ?>" class="form-control  mt-2" id="desc" rows="6"><?php echo isset($referral_assessment['self_harming_other']) ? $referral_assessment['self_harming_other'] : ''; ?></textarea>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="alcohol_drug_abuse">Current or historical alcohol or drug abuse?</label>
                <div>
                    <select name="alcohol_drug_abuse" id="alcohol_drug_abuse" <?php echo $readOnly; ?>>
                        <option value="">Please choose</option>
                        <option value="Current alcohol" <?php echo (isset($referral_assessment['alcohol_drug_abuse']) && $referral_assessment['alcohol_drug_abuse'] == 'Current alcohol') ? "selected='selected'" : "";  ?>>Current alcohol</option>
                        <option value="Current drugs" <?php echo (isset($referral_assessment['alcohol_drug_abuse']) && $referral_assessment['alcohol_drug_abuse'] == 'Current drugs') ? "selected='selected'" : "";  ?>>Current drugs</option>
                        <option value="Historical alcohol" <?php echo (isset($referral_assessment['alcohol_drug_abuse']) && $referral_assessment['alcohol_drug_abuse'] == 'Historical alcohol') ? "selected='selected'" : "";  ?>>Historical alcohol</option>
                        <option value="Historical drugs" <?php echo (isset($referral_assessment['alcohol_drug_abuse']) && $referral_assessment['alcohol_drug_abuse'] == 'Historical drugs') ? "selected='selected'" : "";  ?>>Historical drugs</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="work_status" id="work_status">Current work status: </label>
                <div>
                    <select name="work_status" <?php echo $readOnly; ?>>
                        <option value="">Please choose</option>
                        <option value="Full time" <?php echo (isset($referral_assessment['work_status']) && $referral_assessment['work_status'] == 'Full time') ? "selected='selected'" : "";  ?>>Full time</option>
                        <option value="Part time" <?php echo (isset($referral_assessment['work_status']) && $referral_assessment['work_status'] == 'Part time') ? "selected='selected'" : "";  ?>>Part time</option>
                        <option value="Unemployed" <?php echo (isset($referral_assessment['work_status']) && $referral_assessment['work_status'] == 'Unemployed') ? "selected='selected'" : "";  ?>>Unemployed</option>
                        <option value="Other" <?php echo (isset($referral_assessment['work_status']) && $referral_assessment['work_status'] == 'Other') ? "selected='selected'" : "";  ?>>Other (specify)</option>
                    </select>
                    <textarea <?php echo $readOnly; ?> name="work_status_other" style="width: 100%; <?php echo (isset($referral_assessment['work_status']) && $referral_assessment['work_status'] == 'Other') ? "" : "display: none;";  ?>" class="form-control  mt-2" id="desc" rows="6"><?php echo isset($referral_assessment['work_status_other']) ? $referral_assessment['work_status_other'] : ''; ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="living_situation" id="living_situation">Current living situation</label>
                <div>
                    <select name="living_situation" <?php echo $readOnly; ?>>
                        <option value="">Please choose</option>
                        <option value="Living alone" <?php echo (isset($referral_assessment['living_situation']) && $referral_assessment['living_situation'] == 'Living alone') ? "selected='selected'" : "";  ?>>Living alone</option>
                        <option value="Living with partner" <?php echo (isset($referral_assessment['living_situation']) && $referral_assessment['living_situation'] == 'Living with partner') ? "selected='selected'" : "";  ?>>Living with partner</option>
                        <option value="Living with family" <?php echo (isset($referral_assessment['living_situation']) && $referral_assessment['living_situation'] == 'Living with family') ? "selected='selected'" : "";  ?>>Living with family</option>
                        <option value="Living with others" <?php echo (isset($referral_assessment['living_situation']) && $referral_assessment['living_situation'] == 'Living with others') ? "selected='selected'" : "";  ?>>Living with others</option>
                        <option value="Other" <?php echo (isset($referral_assessment['living_situation']) &&  $referral_assessment['living_situation'] == 'Other') ? "selected='selected'" : "";  ?>>Other (comment)</option>
                    </select>
                    <textarea <?php echo $readOnly; ?> name="living_situation_other" style="width: 100%; <?php echo $referral_assessment['living_situation'] == 'Other' ? "" : "display: none;";  ?>" class="form-control  mt-2" id="desc" rows="6"><?php echo isset($referral_assessment['living_situation_other']) ? $referral_assessment['living_situation_other'] : ''; ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="ace_score">Ace Score: </label>
                <div>
                    <select name="ace_score" id="ace_score" <?php echo $readOnly; ?>>
                        <option value="">Please choose</option>
                        <option value="0" <?php echo isset($referral_assessment['ace_score']) && $referral_assessment['ace_score'] == '0' ? "selected='selected'" : "";  ?>>0</option>
                        <option value="1" <?php echo isset($referral_assessment['ace_score']) &&  $referral_assessment['ace_score'] == '1' ? "selected='selected'" : "";  ?>>1</option>
                        <option value="2" <?php echo isset($referral_assessment['ace_score']) &&  $referral_assessment['ace_score'] == '2' ? "selected='selected'" : "";  ?>>2</option>
                        <option value="3" <?php echo isset($referral_assessment['ace_score']) &&  $referral_assessment['ace_score'] == '3' ? "selected='selected'" : "";  ?>>3</option>
                        <option value="4" <?php echo isset($referral_assessment['ace_score']) && $referral_assessment['ace_score'] == '4' ? "selected='selected'" : "";  ?>>4</option>
                        <option value="5" <?php echo isset($referral_assessment['ace_score']) && $referral_assessment['ace_score'] == '5' ? "selected='selected'" : "";  ?>>5</option>
                        <option value="6" <?php echo isset($referral_assessment['ace_score']) && $referral_assessment['ace_score'] == '6' ? "selected='selected'" : "";  ?>>6</option>
                        <option value="7" <?php echo isset($referral_assessment['ace_score']) &&  $referral_assessment['ace_score'] == '7' ? "selected='selected'" : "";  ?>>7</option>
                        <option value="8" <?php echo isset($referral_assessment['ace_score']) && $referral_assessment['ace_score'] == '8' ? "selected='selected'" : "";  ?>>8</option>
                        <option value="9" <?php echo isset($referral_assessment['ace_score']) && $referral_assessment['ace_score'] == '9' ? "selected='selected'" : "";  ?>>9</option>
                        <option value="10" <?php echo isset($referral_assessment['ace_score']) && $referral_assessment['ace_score'] == '10' ? "selected='selected'" : "";  ?>>10</option>
                    </select>

                </div>
            </div>
        </div>


        <div class="row">
            <div class="form-group">
                <label for="referral_notes">Notes</label>
                <div>
                    <textarea <?php echo $readOnly; ?> id="referral_notes" name="referral_notes" style="width: 100%; " class="form-control  mt-2" id="desc" rows="6"><?php echo isset($referral_assessment['referral_notes']) ? $referral_assessment['referral_notes'] : ''; ?></textarea>
                </div>
            </div>
        </div>




        <?php if (current_user_can('wpc_manager')) : ?>

            <input type="hidden" name="client" value="<?php echo  $client_id; ?>">
            <input type="hidden" name="action" value="add_referral_assessment">
            <input type="hidden" name="curent_page" value="<?php echo  $current_url; ?>">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("add_referral_assessment"); ?>">


            <div class="float-right">

                <a href="/manager/my-clients/" class="btn btn-sharp-edge  btn-outline-secondary mr-2">Back to Clients</a>

                <button type="submit" class="btn btn-sharp-edge h4h-primary btn-primary">Submit</button>

            </div>

        <?php endif; ?>

    </div>

</form>
<?php

if (!defined('WPINC')) {
    die;
}
?>


<div class="d-flex flex-wrap reports">
    <?php
    foreach ($my_counsellors as $counsellor) :
    ?>
        <button style="min-width: 120px; background: #ce7062; color: #FFF; border: none; font-size:16px;" onclick="window.location.href = '/manager/my-counsellors/counsellor-profile/?counsellor=<?php echo $counsellor->ID; ?>#profile|1'" class="btn btn-outline-secondary btn-sharp-edge  m-1 mb-3 p-4 text-center align-items-center">

            <?php echo $counsellor->display_name; ?>
            (<span style="font-size: 15px; "><?php echo count_counsellor_client($counsellor->ID) ?></span>)

        </button>



    <?php endforeach; ?>

</div>
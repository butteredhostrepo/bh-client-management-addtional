<?php

if (!defined('WPINC')) {
    die;
}
?>


<div class="d-flex flex-wrap">

    <button style="font-size: 16px; min-width: 120px; background: rgb(7, 71, 17); color: #FFF; border: none;" onclick="window.location.href = '/manager/donations/'" class="btn btn-outline-secondary btn-sharp-edge  m-1 mb-3 p-4 text-center align-items-center">

        Total Donations (<span style="font-size: 15px;"><?php echo $all != '' ? $all : '0';; ?></span>)
    </button>

    <button style="font-size: 16px; min-width: 120px; background: rgb(7, 71, 17); color: #FFF; border: none;" onclick="window.location.href = '/manager/donations/'" class="btn btn-outline-secondary btn-sharp-edge  m-1 mb-3 p-4 text-center align-items-center">

        Total Donations for this Month (<span style="font-size: 15px; "><?php echo $monthly != '' ? $monthly : '0';; ?></span>)
    </button>

    <button style="font-size: 16px;  min-width: 120px; background: rgb(7, 71, 17); color: #FFF; border: none;" onclick="window.location.href = '/manager/donations/'" class="btn btn-outline-secondary btn-sharp-edge  m-1 mb-3 p-4 text-center align-items-center">

        Total Donations for this Week (<span style="font-size: 15px; "><?php echo $weekly != '' ? $weekly : '0'; ?></span>)
    </button>

    <?php if ($top_donor_client != '') : ?>
        <button style="min-width: 120px; background: rgb(7, 71, 17); color: #FFF; border: none;" onclick="window.location.href = '/manager/donations/'" class="btn btn-outline-secondary btn-sharp-edge  m-1 mb-3 p-4 text-center align-items-center">
            <span style="font-size: 30px; font-weight:600"><?php echo $top_donor_amount; ?></span>
            <br>
            <span style="font-size: 18px; font-weight:600"><?php echo $top_donor_client; ?></span><br>
            Top Donor
        </button>
    <?php endif; ?>

</div>
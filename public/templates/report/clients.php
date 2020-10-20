<?php

if (!defined('WPINC')) {
    die;
}

?>



<div class="d-flex reports">

    <?php

    $classes_css = array('green', 'blue', 'redpink', 'red', 'darkred', 'darkblue', 'darkpurple', 'darkgreen', 'darkorange', 'darkyellow', 'pink', 'cyan', 'lightgreen');
    $index = 0;

    foreach ($statuses as $status) :
        $count = count_client_status($status['value'], $ID);

        if ($index === count($classes_css)) $index = 0;

        $class_css =   $classes_css[$index];

        $index++;

    ?>
        <a href="/manager/my-clients/?status=<?php echo $status['value']; ?>">

            <div class="status m-1 mb-3 pb-4 pt-4 <?php echo  $class_css; ?>">

                <div class="type"><?php echo $status['value']; ?> (<span class="count"><?php echo $count; ?></span>)</div>

            </div>

        </a>


    <?php endforeach; ?>



</div>

<div class="mb-3">
    <button class="btn btn-sharp-edge h4h-primary btn-primary mb-2" onclick="window.location.href = '/manager/reports/core-om-difference/'">Clients Core OM</button>
</div>
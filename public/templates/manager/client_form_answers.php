<?php
if (!defined('WPINC')) {
    die;
}

$core_om_answer = array(); //stores the answer for calucalation of core om

$core_letters = ['F', 'P', 'F', 'W', 'P', 'R', 'F', 'P', 'R', 'F', 'P', 'F', 'P', 'W', 'P', 'R', 'W', 'P', 'F', 'P', 'F', 'R', 'P', 'R', 'F', 'F', 'P', 'P', 'F', 'P', 'W', 'F', 'F', 'R']; //do not alter. this Letters corresponds on core om field.

//$F = array(0, 2, 6, 9, 11, 18, 20, 24, 25, 28, 31, 32);
//$P = array(1, 4, 7, 10, 12, 14, 17, 19, 22, 26, 27, 29);
//$W = array(3, 13, 16, 30);
//$R = array(5, 8, 15, 21, 23, 33);

$options = array('Not at all', 'Only occasionally', 'Sometimes', 'Often', 'Most or all the time');

$inverted_options  = array('Most or all the time', 'Often', 'Sometimes', 'Only occasionally', 'Not at all');


$fields_inverted_values = array(2, 3, 6, 11, 18, 20, 30, 31); //Values of these fields are inverted (4-0)


$answer_html = "";
?>
<h2 style="text-align: center; font-size: 35px; padding-bottom: 35px;"><?php echo get_form_title($form_id); ?></h2>

<?php foreach ($fields as  $key => $field) : ?>
    <?php if ($field->label !== "") :

        $answer = generate_answer_html($field->field_options, $field->type, $field->field_id, $answer_id);


        //core-om and core-om after counselling
        if ($form_id == 3 || $form_id == 8) {

            $let = $core_letters[$key];

            if ($answer !== 'NO ANSWER') {

                if (in_array($key, $fields_inverted_values))
                    $ans = array_search($answer, $inverted_options, true);
                else
                    $ans = array_search($answer, $options, true);

                $core_om_answer[] = array($let => $ans);
            } else {
                $ans = " ";
                $answer = "<span style='color:red'>NO ANSWER</span>";
            }

            if (current_user_can('wpc_manager') || current_user_can('wpc_client_staff'))
                $html = "<span class='mr-1'> <span style='font-size: 16px;  color:#670001;'>$let</span> - <span class='p-1 border border-dark' style=' min-width:15px; color:#FFA691;'>$ans</span> </span>";
        }

        $answer_html .= "<p>";

        $answer_html .= '<label style="font-weight: 700;">';
        $answer_html .= isset($html) ? $html : "";
        $answer_html .= $field->label;
        $answer_html .= "</label><br>";

        if (isset($html)) :
            $answer_html .= '<span class="ml-5">- <em>' . $answer . '</em></span>';
        else :
            $answer_html .= ' - <em>' . $answer . '</em>';
        endif;



        $answer_html .= "</p>";
    ?>
        <!-- <p>
            <label style="font-weight: 700;">
                <?php echo isset($html) ? $html : ""; ?>
                <?php echo $field->label ?>
            </label><br>

            <?php if (isset($html)) : ?>
                <span class="ml-5">- <em><?php echo  $answer; ?></em></span>
            <?php else : ?>
                - <em><?php echo  $answer; ?></em>
            <?php endif; ?>

        </p>-->
    <?php endif; ?>
<?php endforeach; ?>



<?php
/**For Core OM and Core OM after counselling only */
if (isset($_GET['form']) && ($_GET['form'] == 3 || $_GET['form'] == 8)) :



    foreach ($core_om_answer as  $key => $answer) {

        if (isset($answer['F'])) $F[] = $answer['F'];
        if (isset($answer['P'])) $P[] = $answer['P'];
        if (isset($answer['W'])) $W[] = $answer['W'];
        if (isset($answer['R'])) $R[] = $answer['R'];
    }

    //print_r($core_letters);
    //$test = array_search('F', $core_letters, true);

    $F = compute_score_core_om($F);
    $P = compute_score_core_om($P);
    $W = compute_score_core_om($W);
    $R = compute_score_core_om($R);

    /*$F_mean = round($F['total'] / $F['count'] * 10, 2);
    $P_mean = round($P['total'] / $P['count'] * 10, 2);
    $W_mean = round($W['total'] / $W['count'] * 10, 2);
    $R_mean = round($R['total'] / $R['count'] * 10, 2);*/

    $F_mean = round($F['total'] / $F['count'], 2);
    $P_mean = round($P['total'] / $P['count'], 2);
    $W_mean = round($W['total'] / $W['count'], 2);
    $R_mean = round($R['total'] / $R['count'], 2);


    $total_items = $W['total'] +  $P['total'] + $F['total'] + $R['total'];
    $total_count = $W['count'] + $P['count'] + $F['count'] + $R['count'];

    $total_minus_R = $W['total'] +  $P['total'] + $F['total'];
    $total_count_minus_r = $W['count'] + $P['count'] + $F['count'];

?>


    <?php if (current_user_can('wpc_manager') || current_user_can('wpc_client_staff')) : ?>

        <div class="d-flex flex-row justify-content-center align-items-center mt-3 mb-5">

            <div style="min-width: 80px; background: #980104; border-color: #6b0305 important; color: #FFF;" class="border border-dark text-center p-2 m-2">
                Clinical Score<br>
                <strong><?php echo round($total_items / $total_count, 2); ?></strong>

            </div>

            <div style="min-width: 80px;background: #ab3c43; border-color: #861b1f !important;
    color: #FFF;" class="border border-dark text-center p-2 m-2">
                Clinical Risk Score<br>
                <strong><?php echo $R_mean ?></strong>
            </div>

            <div style="min-width: 80px; background: #ffa691; border-color: #d47b66 !important; color: #FFF;" class="border border-dark text-center p-2 m-2">
                Clinical Non-Risk Score<br>
                <strong><?php echo round($total_minus_R / $total_count_minus_r, 2); ?></strong>

            </div>


            <div style="min-width: 80px; background: #ffa691; border-color: #d47b66 !important; color: #FFF;" class="border border-dark text-center p-2 m-2">
                Clinical Well-Being Score<br>
                <strong><?php echo $W_mean ?></strong>

            </div>

            <div style="min-width: 80px; background: #ffa691; border-color: #d47b66 !important; color: #FFF;" class="border border-dark text-center p-2 m-2">
                Clinical Problem Score <br>
                <strong><?php echo $P_mean ?></strong>

            </div>

            <div style="min-width: 80px; background: #ffa691; border-color: #d47b66 !important; color: #FFF;" class="border border-dark text-center p-2 m-2">
                Clinical Function Score <br>
                <strong><?php echo $F_mean ?></strong>

            </div>


        </div>


    <?php endif; ?>

    <?php echo $answer_html; ?>

    <?php if (current_user_can('wpc_manager') || current_user_can('wpc_client_staff')) : ?>

        <div class="d-flex flex-row justify-content-center align-items-center mt-5">

            <div style="min-width: 160px;">
                <strong>Total Scores</strong>
            </div>

            <div style="min-width: 80px;" class="border border-success text-center p-2 m-2">
                <?php echo $W['total']; ?>
            </div>

            <div style="min-width: 80px;" class="border border-success text-center p-2 m-2">
                <?php echo $P['total']; ?>
            </div>

            <div style="min-width: 80px;" class="border border-success text-center p-2 m-2">
                <?php echo $F['total']; ?>
            </div>

            <div style="min-width: 80px;" class="border border-success text-center p-2 m-2">
                <?php echo $R['total']; ?>
            </div>

            <div style="min-width: 80px;" class="border border-success text-center p-2 m-2">
                <?php echo  round($total_items, 2); ?>
            </div>

            <div style="min-width: 80px;" class="border border-success text-center p-2 m-2">
                <?php //echo round($total_count, 2); 
                ?>
                <?php echo round($total_items - $R['total'], 2); ?>
            </div>
        </div>

        <div class="d-flex flex-row justify-content-center align-items-top">

            <div style="min-width: 160px;" class="pt-2">
                <strong>Mean Scores</strong>
            </div>

            <div style="min-width: 80px;" class=" m-2">
                <div class="border border-success text-center p-2"><?php echo $W_mean ?></div>
                <div class=" text-center ">(W)</div>
            </div>

            <div style="min-width: 80px;" class="m-2">
                <div class="border border-success text-center p-2"><?php echo $P_mean ?></div>
                <div class=" text-center ">(P)</div>
            </div>

            <div style="min-width: 80px;" class="m-2">
                <div class="border border-success text-center p-2"><?php echo $F_mean ?></div>
                <div class=" text-center ">(F)</div>
            </div>

            <div style="min-width: 80px;" class="m-2">
                <div class="border border-success text-center p-2"><?php echo $R_mean ?></div>
                <div class=" text-center ">(R)</div>
            </div>

            <div style="min-width: 80px;" class="m-2">

                <div class="border border-success text-center p-2"><?php echo round($total_items / $total_count, 2); ?></div>
                <div class=" text-center ">All Items</div>
            </div>

            <div style="min-width: 80px;" class="m-2">

                <div class="border border-success text-center p-2"><?php echo round($total_minus_R  / $total_count_minus_r, 2); ?></div>
                <div class=" text-center ">All Minus R</div>

            </div>
        </div>

    <?php endif; ?>



<?php else : ?>

    <?php echo $answer_html; ?>


<?php endif; ?>

<div class="float-right">
    <a href="<?php echo $back_link; ?>" class="btn btn-sharp-edge   h4h-secondary mr-2">Back to Client Forms</a>
</div>
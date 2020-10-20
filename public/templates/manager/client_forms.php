<?php

if (!defined('WPINC')) {
    die;
}

?>

<table class="table table-hover">
    <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php if (count($client_forms) > 0) : ?>
        <?php foreach ($client_forms as $form) :
            $answered = client_answered_form($client_id, $form->id);

            $answered_total = $answered->total;
            $answered_id = $answered->id;

            $assigned_form = check_form_assigned($client_id, $form->id);
        ?>
            <tr>
                <td><?php echo $form->title; ?></td>
                <td>
                    <?php
                    $setting = json_decode($form->settings);
                    if ($setting->permission == 'logged-in') {
                        // echo "Required ";
                    } else {

                        if ($assigned_form->total != 0)
                            echo "Assigned ";
                        else
                            echo "Not Assigned";
                    }



                    ?>

                    <?php if ($answered_total > 0) : ?>
                        - Completed
                    <?php else : ?>
                        - Not Completed
                    <?php endif; ?>

                </td>
                <td>
                    <?php if ($answered_total > 0) : ?>
                        <a href="view-answered-form/?client=<?php echo $client_id; ?>&answer=<?php echo $answered_id; ?>&form=<?php echo $form->id; ?>">View Answer</a>
                    <?php endif; ?>

                    <?php
                    if ($setting->permission == 'selected' && $answered_total == 0 && $assigned_form->total == 0) : ?>
                        <a style="cursor: pointer" class="assign_form_client" data-client="<?php echo $client_id; ?>" data-form="<?php echo $form->id; ?>" data-nonce="<?php echo wp_create_nonce("assignform"); ?>">Assign to client</a>
                    <?php endif; ?>

                    <?php if ($setting->permission == 'selected' && $answered_total == 0 && $assigned_form->total == 1) :  ?>
                        <a style="cursor: pointer" class="unassign_form_client" data-client="<?php echo $client_id; ?>" data-form="<?php echo $form->id; ?>" data-nonce="<?php echo wp_create_nonce("unassignform"); ?>">Unassign to client</a>
                    <?php endif; ?>
                </td>
            </tr>

        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="2">No answered forms yet.</td>
        </tr>
    <?php endif; ?>

</table>
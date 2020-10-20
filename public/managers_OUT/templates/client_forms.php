<?php

if (!defined('WPINC')) {
    die;
}

?>

<table>
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
        ?>
            <tr>
                <td><?php echo $form->title; ?></td>
                <td>
                    <?php if ($answered_total > 0) : ?>
                        Completed
                    <?php else : ?>
                        Assigned
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($answered_total > 0) : ?>
                        <a href="view-answered-form/?client=<?php echo $client_id; ?>&answer=<?php echo $answered_id; ?>&form=<?php echo $form->id; ?>">View Answer</a>
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
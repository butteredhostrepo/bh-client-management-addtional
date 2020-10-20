<?php
if (!defined('WPINC')) {
    die;
}
?>
<h3>Form: <?php echo get_form_title($form_id); ?></h3>
<?php foreach ($fields as $field) : ?>
    <?php if ($field->label !== "") : ?>
        <p><?php echo $field->label ?><br>
            -<em><strong><?php generate_answer_html($field->field_options, $field->type, $field->id, $answer_id); ?></strong></em>
        </p>
    <?php endif; ?>
<?php endforeach; ?>
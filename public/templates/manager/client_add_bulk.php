<?php

if (!defined('WPINC')) {
    die;
}

?>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="clients">


    <input type="hidden" name="action" value="add_clients_bulk">
    <input type="hidden" name="curent_page" value="/manager/add-clients/">


    <input type="submit">
</form>
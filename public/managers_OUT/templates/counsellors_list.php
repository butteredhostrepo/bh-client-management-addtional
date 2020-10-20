<?php
if (!defined('WPINC')) {
    die;
}
?>

<div class="container-fluid">
    <div class=" row  d-flex">
        <div class="col pl-0 justify-content-center align-self-center">
        </div>
        <div class="col pr-0">

            <form action="<?php echo get_permalink(); ?>" method="get" class="form-inline float-right">
                <div class="form-group mb-2 mr-2">
                    <label for="inputPassword2" class="sr-only">Password</label>
                    <input type="text" class="form-control" name="search" value="<?php echo get_query_var('search'); ?>" placeholder="Search Counsellor">
                </div>
                <input type="submit" value="Search" class="btn btn-sharp-edge h4h-primary btn-primary mb-2">
            </form>


        </div>
    </div>
</div>

<?php if (get_query_var('search')) : ?>
    <div style="padding:10px 0;"> Search results: <?php echo get_query_var('search'); ?></div>
<?php endif; ?>


<table class="table table-hover" style="background-color: #FFF;">
    <thead style="border-bottom: 1px solid #000;">
        <tr>
            <th>ID</th>
            <th>Counsellor Name</th>
            <th>Email</th>
            <th>Date Created</th>
            <th>Assigned Clients</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($my_counsellors) > 0) : ?>
            <?php foreach ($my_counsellors as $counsellor) :
                $counsellor_info = get_userdata($counsellor->ID);

            ?>
                <tr>
                    <td>#<?php echo $counsellor->ID; ?></td>
                    <td><?php echo get_user_meta($counsellor->ID, 'first_name', true) . ' ' . get_user_meta($counsellor->ID, 'last_name', true); ?></td>
                    <td><?php echo $counsellor_info->user_email; ?></td>
                    <td><?php echo $counsellor_info->user_registered; ?></td>
                    <td><?php echo count_counsellor_client($counsellor->ID); ?></td>
                    <td><a href="counsellor-profile/?counsellor=<?php echo $counsellor->ID; ?>">View</a></td>

                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="7">No counsellors found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
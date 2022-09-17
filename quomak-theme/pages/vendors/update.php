<?php

    use App\Models\Vendor;

    $uuid = !empty($_GET['uuid'])?$_GET['uuid']:NULL;

    $vendor = new Vendor();

    $row = $vendor->where("uuid = '$uuid'")->first();

?>


<?php if(empty($row)){ ?>
    <div class="container-fluid">
    <div class="row">
        <div class="col-12  col-md-6 offset-md-3">
    <div class="alert alert-warning">
        <div class="strong">No matching vendor found</div>
    </div>
    </div>
    </div>
</div>
<?php return; } ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-12  col-md-6 offset-md-3">
            <h4>Update Vendor</h4>
            <?php get_template_part('pages/vendors/form', NULL, $row); ?>
        </div>
    </div>
</div>
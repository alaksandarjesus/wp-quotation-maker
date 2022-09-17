<?php

    use App\Models\Quotation;

    $uuid = !empty($_GET['uuid'])?$_GET['uuid']:NULL;

    $quotation = new Quotation();

    $row = $quotation->where("uuid = '$uuid'")->first();

?>


<?php if(empty($row)){ ?>
    <div class="container-fluid">
    <div class="row">
        <div class="col-12  col-md-6 offset-md-3">
    <div class="alert alert-warning">
        <div class="strong">No matching quotation found</div>
    </div>
    </div>
    </div>
</div>
<?php return; } ?>



<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
            <h4>Update Quotation</h4>
            <div>
                <button class="btn btn-primary btn-download-as-csv table quotation">Download as CSV</button>

                </div>

            </div>
            
        </div>
    </div>
</div>
<?php get_template_part('pages/quotations/form/index', NULL, array()); ?>

<?php

    use App\Models\Product;

    $uuid = !empty($_GET['uuid'])?$_GET['uuid']:NULL;

    $product = new Product();

    $row = $product->where("uuid = '$uuid'")->first();

?>


<?php if(empty($row)){ ?>
    <div class="container-fluid">
    <div class="row">
        <div class="col-12  col-md-6 offset-md-3">
    <div class="alert alert-warning">
        <div class="strong">No matching product found</div>
    </div>
    </div>
    </div>
</div>
<?php return; } ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-12  col-md-6 offset-md-3">
            <h4>Update Product</h4>
            <?php get_template_part('pages/products/form', NULL, $row); ?>
        </div>
    </div>
</div>
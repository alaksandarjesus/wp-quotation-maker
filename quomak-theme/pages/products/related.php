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
        <div class="col-12">
        <h4>Related Products</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h6><?php echo $row->code; ?> / <?php echo $row->name; ?></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-8">
            <table class="table table-bordered product-related">
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th></th>
                </tr>
            </table>
        </div>
        <div class="col-12 col-md-4">
            <form class="product-related">
                <input type="hidden" name="product_uuid" value="<?php echo $uuid; ?>">
                <input type="hidden" name="related_product_uuid" value="<?php echo $uuid; ?>">
                <div class="form-group mb-2">
                    <label for="" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control">
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <button class="btn btn-primary btn-submit" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
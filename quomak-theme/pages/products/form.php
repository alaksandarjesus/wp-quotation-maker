<?php

use App\Models\ProductCategory;
use App\Models\ProductUnit;

$categories = new ProductCategory;
$units = new ProductUnit;

$product_categories = $categories->reset()->where('id > 0')->orderBy('name', 'ASC')->get();
$product_units = $units->reset()->where('id > 0')->orderBy('name', 'ASC')->get();

foreach ($product_categories as $category) {
    $category->selected = false;
    if (!empty($args->category_id) && $category->id == $args->category_id) {
        $category->selected = true;
    }
}

foreach ($product_units as $unit) {
    $unit->selected = false;
    if (!empty($args->unit_id) && $unit->id == $args->unit_id) {
        $unit->selected = true;
    }
}

?>

<form action="" class="product">
    <input type="hidden" name="uuid" value="<?php echo !empty($args->uuid) ? $args->uuid : null; ?>">


    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Product Category</label>
                <select name="product_category_uuid" class="form-select" autofocus>
                    <option value="">Select Category</option>
                    <?php foreach ($product_categories as $category) {?>
                        <option value="<?php echo $category->uuid; ?>"
                        <?php echo $category->selected?'selected':""; ?>
                        ><?php echo $category->name; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Product Unit</label>
                <select name="product_unit_uuid" class="form-select" autofocus>
                    <option value="">Select Unit</option>
                    <?php foreach ($product_units as $unit) {?>
                        <option value="<?php echo $unit->uuid; ?>"
                        <?php echo $unit->selected?'selected':""; ?>
                        ><?php echo $unit->name; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        

    </div>
    <div class="row">
    <div class="col-12 col-md-4">
            <div class="form-group mb-3">
                <label for="" class="form-label">Product Code</label>
                <input type="text" class="form-control" name="code" placeholder="Product code" value="<?php echo !empty($args->code) ? $args->code : null; ?>">
            </div>
        </div>
        <div class="col-8">
            <div class="form-group mb-2">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" placeholder="Product Name" value="<?php echo !empty($args->name) ? $args->name : null; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-2">
                <label for="" class="form-label">Notes</label>
                <textarea class="form-control notes" name="notes" ><?php echo !empty($args->notes) ? $args->notes : null; ?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end align-items-center">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </div>
</form>
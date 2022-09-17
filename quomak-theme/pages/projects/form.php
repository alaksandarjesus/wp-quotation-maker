<?php

use App\Models\ProjectCategory;
use App\Models\Customer;

$categories = new ProjectCategory;
$customer = new Customer;

$project_categories = $categories->reset()->where('id > 0')->orderBy('name', 'ASC')->get();
$customers = $customer->reset()->where('id > 0')->orderBy('business_name', 'ASC')->get();

foreach ($project_categories as $category) {
    $category->selected = false;
    if (!empty($args->category_id) && $category->id == $args->category_id) {
        $category->selected = true;
    }
}

foreach ($customers as $customer) {
    $customer->selected = false;
    if (!empty($args->customer_id) && $customer->id == $args->customer_id) {
        $customer->selected = true;
    }
}

?>

<form action="" class="project">
    <input type="hidden" name="uuid" value="<?php echo !empty($args->uuid) ? $args->uuid : null; ?>">


    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Project Category</label>
                <select name="project_category_uuid" class="form-select" autofocus>
                    <option value="">Select Category</option>
                    <?php foreach ($project_categories as $category) {?>
                    <option value="<?php echo $category->uuid; ?>" <?php echo $category->selected?'selected':""; ?>>
                        <?php echo $category->name; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Project Customer</label>
                <select name="project_customer_uuid" class="form-select" autofocus>
                    <option value="">Select Customer</option>
                    <?php foreach ($customers as $customer) {?>
                    <option value="<?php echo $customer->uuid; ?>" <?php echo $customer->selected?'selected':""; ?>>
                        <?php echo $customer->business_name; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-2">
                <label class="form-label">Project Name</label>
                <input type="text" class="form-control" name="name" placeholder="Project Name"
                    value="<?php echo !empty($args->name) ? $args->name : null; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-2">
                <label for="" class="form-label">Notes</label>
                <textarea class="form-control notes"
                    name="notes"><?php echo !empty($args->notes) ? $args->notes : null; ?></textarea>
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
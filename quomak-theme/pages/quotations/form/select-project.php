<?php

use App\Models\Project;

$project = new Project;

$projects = $project->reset()->orderBy('name', 'ASC')->get();

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="form-group mb-3">
                <label for="" class="form-label">Quotation Number</label>
                <input type="text" class="form-control quotation-number">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mb-3">
                <label for="" class="form-label">Quotation Date</label>
                <input type="text" class="form-control quotation-date">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group mb-3">
                <label for="" class="form-label">Project Name</label>
            <select name="" class="form-select select-project">
                <option value="">Select Project</option>
                <?php foreach($projects as $project){ ?>
                <option value="<?php echo $project->uuid; ?>"><?php echo $project->name; ?></option>
                <?php } ?>
            </select>
            </div>
           
        </div>
    </div>
</div>
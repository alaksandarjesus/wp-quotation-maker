<?php

    use App\Models\Project;

    $uuid = !empty($_GET['uuid'])?$_GET['uuid']:NULL;

    $project = new Project();

    $row = $project->where("uuid = '$uuid'")->first();

?>


<?php if(empty($row)){ ?>
    <div class="container-fluid">
    <div class="row">
        <div class="col-12  col-md-6 offset-md-3">
    <div class="alert alert-warning">
        <div class="strong">No matching project found</div>
    </div>
    </div>
    </div>
</div>
<?php return; } ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-12  col-md-6 offset-md-3">
            <h4>Update Project</h4>
            <?php get_template_part('pages/projects/form', NULL, $row); ?>
        </div>
    </div>
</div>
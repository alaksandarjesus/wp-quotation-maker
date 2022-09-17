<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Products</h4>
                <div>

                <a class="btn btn-primary" href="<?php echo site_url().'/products?view=categories'; ?>">Categories</a>
                    
                <a class="btn btn-primary" href="<?php echo site_url().'/products?view=units'; ?>">Units</a>
                    
                <a class="btn btn-primary" href="<?php echo site_url().'/products?view=create'; ?>">Create</a>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered products">
                
            </table>
        </div>
    </div>
</div>
<form action="" class="vendor">
    <input type="hidden" name="uuid" value="<?php echo !empty($args->uuid)?$args->uuid:NULL; ?>">
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-2">
                <label class="form-label">Business Name</label>
                <input type="text" class="form-control" name="business_name" placeholder="Business Name" autofocus value="<?php echo !empty($args->business_name)?$args->business_name:NULL; ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" placeholder="Firstname" value="<?php echo !empty($args->first_name)?$args->first_name:NULL; ?>">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" placeholder="Lastname" value="<?php echo !empty($args->last_name)?$args->last_name:NULL; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo !empty($args->email)?$args->email:NULL; ?>">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Mobile</label>
                <input type="text" class="form-control" name="mobile" placeholder="Mobile" value="<?php echo !empty($args->mobile)?$args->mobile:NULL; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Address Line 1</label>
                <input type="text" class="form-control" name="address_line_1" placeholder="Address line 1"  value="<?php echo !empty($args->address_line_1)?$args->address_line_1:NULL; ?>">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Address Line 2</label>
                <input type="text" class="form-control" name="address_line_2" placeholder="Address line 2"  value="<?php echo !empty($args->address_line_2)?$args->address_line_2:NULL; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">City</label>
                <input type="text" class="form-control" name="city" placeholder="City"  value="<?php echo !empty($args->city)?$args->city:NULL; ?>">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">State</label>
                <input type="text" class="form-control" name="state" placeholder="State"  value="<?php echo !empty($args->state)?$args->state:NULL; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Country</label>
                <input type="text" class="form-control" name="country" placeholder="Country"  value="<?php echo !empty($args->country)?$args->country:NULL; ?>">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-3">
                <label for="" class="form-label">Pincode</label>
                <input type="text" class="form-control" name="pincode" placeholder="Pincode"  value="<?php echo !empty($args->pincode)?$args->pincode:NULL; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-2">
                <label class="form-label">Tax Info</label>
                <input type="text" class="form-control" name="gstin" placeholder="GSTIN"  value="<?php echo !empty($args->gstin)?$args->gstin:NULL; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-2">
                <label for="" class="form-label">Notes</label>
                <textarea class="form-control notes" name="notes" ><?php echo !empty($args->notes)?$args->notes:NULL; ?></textarea>
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
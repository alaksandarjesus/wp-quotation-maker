<form class="set-password" style="display:none">
    <h3 class="modal-title">Set Password</h3>
    <div class="modal-body">
        <input type="hidden" class="key">
        <input type="hidden" class="username">
        <div class="form-group mb-3">
            <label for="" class="form-label">One Time Password</label>
            <input type="text" class="form-control otp" name="otp">
        </div>
        <div class="form-group mb-3">
            <label for="" class="form-label">Password</label>
            <input type="password" class="form-control password" id="password" name="password">
        </div>
        <div class="form-group mb-3">
            <label for="" class="form-label">Confirm Password</label>
            <input type="password" class="form-control cpassword" name="cpassword">
        </div>
    </div>
    <div class="d-flex justify-content-end align-items-center">
        <button class="btn btn-primary btn-submit" type="submit">Set Password</button>
    </div>
</form>
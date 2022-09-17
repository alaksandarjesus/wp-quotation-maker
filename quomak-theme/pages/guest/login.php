<form class="login">
    <h3>Login</h3>
    <div class="form-group mb-3">
        <label for="" class="form-label">Username/Email</label>
        <input type="text" class="form-control username" name="username" value="">
    </div>
    <div class="form-group mb-3">
        <label for="" class="form-label">Password</label>
        <div class="input-group">
        <input type="password" class="form-control password" name="password" value="">
        <button class="btn btn-secondary-outline d-flex justify-content-center align-items-center password-toggle" type="button">
            <span class="material-icons-outlined">visibility</span>
        </button>
        </div>
    </div>
    <div>
        <button class="btn btn-link ps-0 open-form" data-form="register" type="button">Don't have an account?
            Register</button>
    </div>

    <div>
        <button class="btn btn-link ps-0 open-form" data-form="forgot-password" type="button">Forgot Password?</button>
    </div>
    <div class="d-flex justify-content-end align-items-center">
        <button class="btn btn-primary btn-submit" type="submit">Login</button>
    </div>
</form>
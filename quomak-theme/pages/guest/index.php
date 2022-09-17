<?php
    if(is_user_logged_in()){

        do_action('redirect_to_dashboard');

        return;
        
    }

?>


<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="d-flex justify-content-center align-items-center vh-100">
                <div class="card w-100">
                    <div class="card-body guest-forms">
                        <?php
                get_template_part('pages/guest/login');
                get_template_part('pages/guest/register');
                get_template_part('pages/guest/forgot-password');
                get_template_part('pages/guest/set-password');
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


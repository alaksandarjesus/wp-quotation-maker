<?php
    if(!is_user_logged_in()){

        do_action('redirect_to_home');

        return;
        
    }

    get_template_part('template-parts/components/navbar/primary')

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4>Dashboard</h4>
        </div>
    </div>
</div>
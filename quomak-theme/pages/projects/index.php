<?php
    if(!is_user_logged_in()){

        do_action('redirect_to_home');

        return;
        
    }

    get_template_part('template-parts/components/navbar/primary');

    $view = (!empty($_GET['view']) && in_array($_GET['view'], ['create', 'update',  'categories']))?$_GET['view']: 'list';

    get_template_part('pages/projects/'.$view);

?>


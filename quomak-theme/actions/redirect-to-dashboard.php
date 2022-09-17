<?php

if(!function_exists('redirect_to_dashboard')){

    function redirect_to_dashboard($args = array()){

        $script = '<script>window.location.href = "%1$s"</script>';

        echo sprintf($script, site_url().'/dashboard');
    }
}


add_action('redirect_to_dashboard', 'redirect_to_dashboard', 10, 2);
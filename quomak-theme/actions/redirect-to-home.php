<?php

if(!function_exists('redirect_to_home')){

    function redirect_to_home($args = array()){

        $script = '<script>window.location.href = "%1$s"</script>';

        echo sprintf($script, site_url());
    }
}


add_action('redirect_to_home', 'redirect_to_home', 10, 2);
<?php

if(!function_exists('redirect_to_404')){

    function redirect_to_404($args = array()){

        $script = '<script>window.location.href = "%1$s"</script>';

        echo sprintf($script, site_url().'/404?'.build_query($args));
    }
}


add_action('redirect_to_404', 'redirect_to_404', 10, 2);
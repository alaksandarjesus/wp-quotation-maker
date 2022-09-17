<?php

if(!function_exists('wp_602085_quomak_logout')){

    function wp_602085_quomak_logout(){

        wp_logout();

        wp_send_json_success(['redirect' =>site_url()]);


    }
}

add_action('wp_ajax_logout', 'wp_602085_quomak_logout');

<?php

function wp_861301_quomak_scripts()
{
    $version = '1.0.1';
    wp_enqueue_style('libs', TEMPLATE_DIR_URI . '/public/styles/libs.css', array(), $version);
    wp_enqueue_style('app', TEMPLATE_DIR_URI . '/public/styles/app.css', array('libs'), $version);
    wp_enqueue_script('libs', TEMPLATE_DIR_URI . '/public/scripts/libs.js', array(), $version, true);
    wp_enqueue_script('app', TEMPLATE_DIR_URI . '/public/scripts/app.js', array('libs'), $version, true);

    if(!is_user_logged_in()){
   
        wp_enqueue_script('guest', TEMPLATE_DIR_URI . '/public/scripts/guest.js', array('app'), $version, true);

    }else{

        wp_enqueue_script('user', TEMPLATE_DIR_URI . '/public/scripts/user.js', array('app'), $version, true);

        if(current_user_can('administrator')){

            wp_enqueue_script('administrator', TEMPLATE_DIR_URI . '/public/scripts/administrator.js', array('user'), $version, true);

        }

        if(current_user_can('subscriber')){

            wp_enqueue_script('subscriber', TEMPLATE_DIR_URI . '/public/scripts/subscriber.js', array('user'), $version, true);

        }
    }


    wp_localize_script('app', 'quomak_ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'base_url' => site_url(),
            'user_logged_in' => json_encode(is_user_logged_in()),
            'ajax_nonce' => wp_create_nonce( $_ENV['NONCE_SECRET']),
        )
    );
}
add_action('wp_enqueue_scripts', 'wp_861301_quomak_scripts');

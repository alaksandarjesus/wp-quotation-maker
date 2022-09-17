<?php

use Plugin\Validator\Validate;


if(!function_exists('wp_274519_quomak_forgot_password')){

    function wp_274519_quomak_forgot_password(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
        ];

        $errors = $validator->validate($_GET, $rules);

        if(!empty($errors)){

            wp_send_json_error(['errors' => $errors]);
        }

        $rules =  [
            'username' => 'required|blacklisted',
        ];

        $messages = [
        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }
  
        $username = isset($_POST['username'])?trim($_POST['username']):NULL;

        $user = get_user_by('login', $username);

        if(empty($user)){

            $user = get_user_by('email', $username);

            if(empty($user)){

                wp_send_json_error(['errors' => ['Username doesnot match with our records']]);

                return;
            }

        }

        $code = rand(100000, 999999);

        $prefix = str_upper(str_random(2)).'-';

        update_user_meta($user->ID, 'one_time_password', $prefix.$code);

        do_action('send_user_confirmation_code', $user);

        $key = get_password_reset_key($user);

        if (wp_get_environment_type() !== 'production') {

            wp_send_json_success(['otp' => $prefix.$code, 'key' => $key, 'username' => $user->user_login]);
            
            return;
        }

        wp_send_json_success(['otp' => $prefix, 'key' => $key, 'username' => $user->user_login]);
       
        return;
    }
}







add_action('wp_ajax_nopriv_forgot-password', 'wp_274519_quomak_forgot_password');

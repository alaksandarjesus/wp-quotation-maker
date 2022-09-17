<?php

use Plugin\Validator\Validate;


if (!function_exists('wp_748478_quomak_register')) {

    function wp_748478_quomak_register()
    {

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
            'firstname' => 'required|min:3|max:30|regex:/^[a-zA-Z\\s]*$/',
            'lastname' => 'required|min:3|max:30|regex:/^[a-zA-Z\\s]*$/',
            'username' => 'required|unique:users,user_login|regex:/^[a-z0-9]*$/|blacklisted',
            'email' => 'required|email|unique:users,user_email',
        ];

        $messages = [
            'username:unique' => "Username is taken",
            'email:unique' => "Email is taken",
        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $username = !empty($_POST['username'])?trim($_POST['username']):NULL;

        $email = !empty($_POST['email'])?trim($_POST['email']):NULL;

        $user_id = wp_create_user($username, wp_generate_password(), $email);

        $code = rand(100000, 999999);

        $prefix = str_upper(str_random(2)).'-';

        update_user_meta($user_id, 'one_time_password', $prefix.$code);

        $user = get_user_by('ID',$user_id);

        wp_update_user([
            'ID' => $user->ID, // this is the ID of the user you want to update.
            'first_name' => !empty($_POST['firstname'])?trim($_POST['firstname']):'',
            'last_name' => !empty($_POST['lastname'])?trim($_POST['lastname']):'',
        ]);

        $key = get_password_reset_key($user);

        do_action('send_user_confirmation_code', $user);

        if (wp_get_environment_type() !== 'production') {

            wp_send_json_success(['otp' => $prefix.$code, 'key' => $key, 'username' => $user->user_login]);
            
            return;
        }

        wp_send_json_success(['otp'=>$prefix,'key' => $key, 'login' => $user->user_login]);

        return;

    }
}

add_action('wp_ajax_nopriv_register', 'wp_748478_quomak_register');

<?php

use Plugin\Validator\Validate;

if(!function_exists('wp_173865_quomak_login')){

    function wp_173865_quomak_login(){

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
            'username' => 'required|min:3|max:20',
            'password' => 'required|min:8|max:20'
        ];

        $messages = [

            'password:min' => "Password should be minimum 8 characters",
            'password:max' => "Password cannot exceed 20 characters"
        ];

        $errors = $validator->validate($_POST, $rules,$messages);
       

        if(!empty($errors)){

            wp_send_json_error(['errors' => $errors]);
        }

        $username = !empty($_POST['username'])?trim($_POST['username']):NULL;

        $password = !empty($_POST['password'])?trim($_POST['password']):NULL;
        
        $user = get_user_by('login', $username);

        if(empty($user)){

            $user = get_user_by('email', $username);

            if(empty($user)){

                wp_send_json_error(['errors' => ['Username doesnot match with our records'], 'post' => $_POST]);

                return;
            }

        }

        
        $authenticate = wp_authenticate((string) $user->user_login, (string) $password);

        if(empty($authenticate->ID)){

            wp_send_json_error(['errors' => ['Username & Password does not match with our records']]);

            return;

        }

        
        $creds = array(

            'user_login' => $user->user_login,

            'user_password' => $password,

            'remember' => true,

        );



        $attempt = wp_signon($creds, false);



        if (is_wp_error($attempt)) {

            wp_send_json_error(['errors' => $attempt->get_error_message()]);

            die();

        }

        wp_clear_auth_cookie();

        wp_set_current_user($user->ID);

        wp_set_auth_cookie($user->ID);

        wp_send_json_success(['message' => 'Login Successful']);
    }
}







add_action('wp_ajax_nopriv_login', 'wp_173865_quomak_login');

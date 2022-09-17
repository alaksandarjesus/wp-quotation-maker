<?php
use Plugin\Validator\Validate;

if (!function_exists('wp_696053_quomak_set_password')) {

    function wp_696053_quomak_set_password()
    {

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $rules = [
            'username' => 'required|exists:users,user_login',
            'key' => 'required',
            'otp' => 'required',
            'password' => 'required|min:8|max:20',
            'cpassword' => 'required|same:password',
        ];

        $messages = [
            "otp.required" => "One Time Password is required",
            'password:min' => "Password should be minimum 8 characters",
            'password:max' => "Password cannot exceed 20 characters",
            'cpassword:same' => "Password does not match with Confirm password",
        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $username = !empty($_POST['username'])?trim($_POST['username']):NULL;

        $key = !empty($_POST['key'])?trim($_POST['key']):NULL;

        $verify = check_password_reset_key($key, $username);

        if (is_wp_error($verify)) {

            wp_send_json_error(['errors' => ['Confirmation key does not match']]);
        }

        $user = get_user_by('login', $username);

        $otp = !empty($_POST['otp'])?(string)trim($_POST['otp']):NULL;

        $one_time_password = get_user_meta($user->ID, 'one_time_password', true);

        if ($one_time_password !== $otp) {

            wp_send_json_error(['errors' => ['One Time Password does not match'], 'post' => [$otp, $one_time_password]]);

        }

        $password = $_POST['password'];

        wp_set_password($password, $user->ID);

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

        wp_send_json_success(['message' => 'Password set successfully.']);
    }
}

add_action('wp_ajax_nopriv_set-password', 'wp_696053_quomak_set_password');

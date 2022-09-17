<?php

use Plugin\Validator\Validate;
use App\Models\Customer;


if (!function_exists('wp_097615_quomak_customers_customer')) {

    function wp_097615_quomak_customers_customer()
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
            'uuid' => 'nullable|exists:quomak_customers,uuid'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $customer = new Customer;

        $uuid = !empty($_POST['uuid'])?$_POST['uuid']:NULL;

        if(empty($uuid)){

            $customer->create($_POST);

        }else{

            if(!$customer->can_update("uuid = '$uuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }

             $customer->update($_POST, ['uuid' => $uuid]);
        }


    
        wp_send_json_success(['redirect' => site_url() . '/customers']);

    }

}

add_action('wp_ajax_customers/customer', 'wp_097615_quomak_customers_customer');

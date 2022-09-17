<?php

use Plugin\Validator\Validate;
use App\Models\Customer;


if(!function_exists('wp_605613_quomak_customers_delete')){

    function wp_605613_quomak_customers_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_customers,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $customer = new Customer;

        $uuid = $_GET['uuid'];

        if(!$customer->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $customer->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_customers/delete', 'wp_605613_quomak_customers_delete');
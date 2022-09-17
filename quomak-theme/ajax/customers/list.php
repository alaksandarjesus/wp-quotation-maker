<?php

use Plugin\Validator\Validate;
use App\Models\Customer;


if (!function_exists('wp_786617_quomak_customers_list')) {

    function wp_786617_quomak_customers_list()
    {

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors, $_GET]);
        }

        $rules = [

        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $customer = new Customer;

        $result = $customer->datatable_paginate($_POST);

        wp_send_json_success($result);

    }

}

add_action('wp_ajax_customers/list', 'wp_786617_quomak_customers_list');

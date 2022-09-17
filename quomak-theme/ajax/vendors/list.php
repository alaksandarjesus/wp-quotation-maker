<?php

use Plugin\Validator\Validate;
use App\Models\Vendor;


if (!function_exists('wp_631879_quomak_vendors_list')) {

    function wp_631879_quomak_vendors_list()
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

        $vendor = new Vendor;

        $result = $vendor->datatable_paginate($_POST);

        wp_send_json_success($result);

    }

}

add_action('wp_ajax_vendors/list', 'wp_631879_quomak_vendors_list');

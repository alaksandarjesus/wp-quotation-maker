<?php

use Plugin\Validator\Validate;
use App\Models\ProductUnit;


if (!function_exists('wp_223004_quomak_products_units_list')) {

    function wp_223004_quomak_products_units_list()
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

        $unit = new ProductUnit;

        $result = $unit->datatable_paginate($_POST);

        wp_send_json_success($result);

    }

}

add_action('wp_ajax_products/units/list', 'wp_223004_quomak_products_units_list');

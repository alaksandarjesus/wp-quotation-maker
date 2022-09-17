<?php

use Plugin\Validator\Validate;
use App\Models\ProductCategory;


if (!function_exists('wp_830312_quomak_products_categories_list')) {

    function wp_830312_quomak_products_categories_list()
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

        $category = new ProductCategory;

        $result = $category->datatable_paginate($_POST);

        wp_send_json_success($result);

    }

}

add_action('wp_ajax_products/categories/list', 'wp_830312_quomak_products_categories_list');

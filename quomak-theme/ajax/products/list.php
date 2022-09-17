<?php

use Plugin\Validator\Validate;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductUnit;


if (!function_exists('wp_879135_quomak_products_list')) {

    function wp_879135_quomak_products_list()
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

        $product = new Product;

        $paginated = $product->datatable_paginate($_POST);

        $paginated['results'] = array_map(function($item){
            $product_category = new ProductCategory;
            $product_unit = new ProductUnit;
            $item->category = $product_category->reset()->where("id = $item->category_id")->first();
            $item->unit = $product_unit->reset()->where("id = $item->unit_id")->first();
            return $item;
        }, $paginated['results']);


        wp_send_json_success($paginated);

    }

}

add_action('wp_ajax_products/list', 'wp_879135_quomak_products_list');

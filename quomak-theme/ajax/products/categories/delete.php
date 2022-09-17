<?php

use Plugin\Validator\Validate;
use App\Models\ProductCategory;


if(!function_exists('wp_687194_quomak_products_categories_delete')){

    function wp_687194_quomak_products_categories_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_product_categories,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $category = new ProductCategory;

        $uuid = $_GET['uuid'];

        if(!$category->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $category->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_products/categories/delete', 'wp_687194_quomak_products_categories_delete');
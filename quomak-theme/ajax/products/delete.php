<?php

use Plugin\Validator\Validate;
use App\Models\Product;


if(!function_exists('wp_396141_quomak_products_delete')){

    function wp_396141_quomak_products_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_products,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $product = new Product;

        $uuid = $_GET['uuid'];

        if(!$product->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $product->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_products/delete', 'wp_396141_quomak_products_delete');
<?php

use Plugin\Validator\Validate;
use App\Models\Product;
use App\Models\ProductRelated;


if(!function_exists('wp_776877_quomak_products__product_related_delete')){

    function wp_776877_quomak_products__product_related_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'rpuuid' => 'required|exists:quomak_product_related,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $product_related = new ProductRelated;

        $uuid = $_GET['rpuuid'];

        if(!$product_related->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $product_related->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_products/product/related/delete', 'wp_776877_quomak_products__product_related_delete');
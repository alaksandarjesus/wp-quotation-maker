<?php

use Plugin\Validator\Validate;
use App\Models\Product;
use App\Models\ProductVendor;


if(!function_exists('wp_999543_quomak_products_product_vendors_delete')){

    function wp_999543_quomak_products_product_vendors_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'pvuuid' => 'required|exists:quomak_product_vendors,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $product_vendor = new ProductVendor;

        $uuid = $_GET['pvuuid'];

        if(!$product_vendor->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $product_vendor->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_products/product/vendors/delete', 'wp_999543_quomak_products_product_vendors_delete');
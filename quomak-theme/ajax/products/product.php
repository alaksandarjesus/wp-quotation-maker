<?php

use Plugin\Validator\Validate;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductUnit;


if (!function_exists('wp_100144_quomak_products_product')) {

    function wp_100144_quomak_products_product()
    {
        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $rules = [
            'product_category_uuid' => 'required|exists:quomak_product_categories,uuid',
            'product_unit_uuid' => 'required|exists:quomak_product_units,uuid',
            'uuid' => 'nullable|exists:quomak_products,uuid', 
            'name' => 'required|min:3|max:200',
            'code' => 'required|min:3|max:10',
            'notes' => 'nullable|max:200'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $product_category = new ProductCategory;
        $product_category_uuid = $_POST['product_category_uuid'];
        $product_category_row = $product_category->reset()->where("uuid = '$product_category_uuid'")->first();
        $_POST['category_id'] = $product_category_row->id;

        $product_unit = new ProductUnit;
        $product_unit_uuid = $_POST['product_unit_uuid'];
        $product_unit_row = $product_unit->reset()->where("uuid = '$product_unit_uuid'")->first();
        $_POST['unit_id'] = $product_unit_row->id;


        $product = new Product;

        $uuid = !empty($_POST['uuid'])?$_POST['uuid']:NULL;

        if(empty($uuid)){

            $product->create($_POST);

        }else{

            if(!$product->can_update("uuid = '$uuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }

             $product->update($_POST, ['uuid' => $uuid]);
        }


    
        wp_send_json_success(['redirect' => site_url() . '/products']);

    }

}

add_action('wp_ajax_products/product', 'wp_100144_quomak_products_product');

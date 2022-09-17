<?php

use Plugin\Validator\Validate;
use App\Models\ProductCategory;


if (!function_exists('wp_763786_quomak_products_categories_category')) {

    function wp_763786_quomak_products_categories_category()
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
            'uuid' => 'nullable|exists:quomak_product_categories,uuid'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $category = new ProductCategory;

        $uuid = !empty($_POST['uuid'])?$_POST['uuid']:NULL;

        if(empty($uuid)){

            $category->create($_POST);

        }else{

            if(!$category->can_update("uuid = '$uuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }

             $category->update($_POST, ['uuid' => $uuid]);
        }


    
        wp_send_json_success(['reload' => true]);

    }

}

add_action('wp_ajax_products/categories/category', 'wp_763786_quomak_products_categories_category');

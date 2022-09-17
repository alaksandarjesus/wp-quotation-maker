<?php

use Plugin\Validator\Validate;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\ProductVendor;



if (!function_exists('wp_785325_quomak_products__product_vendors')) {

    function wp_785325_quomak_products__product_vendors()
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
            "uuid" => "nullable|exists:quomak_product_vendors,uuid",
            "product_uuid" => "required|exists:quomak_products,uuid",
            "vendor_uuid" => "required|exists:quomak_vendors,uuid",
            "price" => "required|numeric"
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $product = new Product();

        $puuid = $_POST['product_uuid'];

        $prow = $product->reset()->where("uuid = '$puuid'")->first();

        
        if(empty($prow)){

            wp_send_json_error(['errors' => "Product cannot be empty"]);

        }

        $vendor = new Vendor();

        $vuuid = $_POST['vendor_uuid'];

        $vrow = $vendor->reset()->where("uuid = '$vuuid'")->first();

        if(empty($vrow)){

            wp_send_json_error(['errors' => "Vendor cannot be empty"]);

        }

        $args = [
            'product_id' => $prow->id,
            'vendor_id' => $vrow->id,
            'price' => !empty($_POST['price'])?$_POST['price']:0
        ];



        $uuid = !empty($_POST['uuid'])?$_POST['uuid']:NULL;

        $productVendor = new ProductVendor;


        if(empty($uuid)){

            $product_vendor_row = $productVendor->reset()->where("product_id = $prow->id AND vendor_id = $vrow->id")->first();

            if(!empty($product_vendor_row)){

                wp_send_json_error(['errors' => ['Product to vendor is mapped already']]);
                                
            }

            $productVendor->create($args);

        }else{

            if(!$product->can_update("uuid = '$puuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }
           
            $productVendor->update($args, ['uuid' => $uuid]);
        }


        wp_send_json_success(['reload' => true]);

    }

}

add_action('wp_ajax_products/product/vendors', 'wp_785325_quomak_products__product_vendors');

<?php

use Plugin\Validator\Validate;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\ProductVendor;



if (!function_exists('wp_791920_quomak_products__product_vendors_list')) {

    function wp_791920_quomak_products__product_vendors_list()
    {

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_products,uuid'
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

        $uuid = $_GET['uuid'];

        $prow = $product->reset()->where("uuid = '$uuid'")->first();

        if(empty($prow)){

            wp_send_json_error(['errors' => ['Unable to find product rows']]);

        }

        $product_vendor = new ProductVendor();

        $product_vendor_rows = $product_vendor->reset()->where("product_id = $prow->id")->get();

        if(empty($product_vendor_rows)){

            return wp_send_json_success(array(
                "total" => 0,
                "filtered" => 0,
                "results" => []
            ));
        }

     
        $results = array_map(function($row){
            $vendor = new Vendor;
            $vrow = $vendor->reset()->where("id = $row->vendor_id")->first();
            $row->vendor = !empty($vrow)?$vrow:['name' => 'Unknown'];
            return $row;
        },  $product_vendor_rows);

        $response = [
            "total" => count($results),
            "filtered" => count($results),
            "results" => $results
        ];

        wp_send_json_success($response);

    }

}

add_action('wp_ajax_products/product/vendors/list', 'wp_791920_quomak_products__product_vendors_list');

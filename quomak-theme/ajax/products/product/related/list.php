<?php

use Plugin\Validator\Validate;
use App\Models\Product;
use App\Models\ProductRelated;



if (!function_exists('wp_906152_quomak_products__product_related_list')) {

    function wp_906152_quomak_products__product_related_list()
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

        $product_related = new ProductRelated();

        $product_related_rows = $product_related->reset()->where("product_id = $prow->id")->get();

        if(empty($product_related_rows)){

            return wp_send_json_success(array(
                "total" => 0,
                "filtered" => 0,
                "results" => []
            ));
        }


        $results = array_map(function($row){
            $product = new Product;
            $prow = $product->reset()->where("id = $row->related_product_id")->first();
            $row->product = !empty($prow)?$prow:['code'=>'Unknown','name' => 'Unknown'];
            return $row;
        },  $product_related_rows);

        $response = [
            "total" => count($results),
            "filtered" => count($results),
            "results" => $results
        ];

        wp_send_json_success($response);

    }

}

add_action('wp_ajax_products/product/related/list', 'wp_906152_quomak_products__product_related_list');

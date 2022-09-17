<?php

use App\Models\Product;
use App\Models\ProductRelated;
use Plugin\Validator\Validate;

if (!function_exists('wp_458283_quomak_products__product_related')) {

    function wp_458283_quomak_products__product_related()
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
            "uuid" => "nullable|exists:quomak_product_related,uuid",
            "product_uuid" => "required|exists:quomak_products,uuid",
            "related_product_uuid" => "required|exists:quomak_products,uuid",
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

        if (empty($prow)) {

            wp_send_json_error(['errors' => "Product cannot be empty"]);

        }

        $product = new Product();

        $rpuuid = $_POST['related_product_uuid'];

        $rprow = $product->reset()->where("uuid = '$rpuuid'")->first();

        if (empty($rprow)) {

            wp_send_json_error(['errors' => ["Product cannot be empty"]]);

        }

        if ($rprow->id == $prow->id) {

            wp_send_json_error(['errors' => ["Product and Related product cannot be the same"]]);

        }

        $args = [
            'product_id' => $prow->id,
            'related_product_id' => $rprow->id,
        ];

        $productRelated = new ProductRelated;

        $product_related_row = $productRelated->reset()->where("product_id = $prow->id AND related_product_id = $rprow->id")->first();

        if (!empty($product_related_row)) {

            wp_send_json_error(['errors' => ['Product to Related Product is mapped already']]);

        }

        $productRelated->create($args);

        wp_send_json_success(['reload' => true]);

    }

}

add_action('wp_ajax_products/product/related', 'wp_458283_quomak_products__product_related');

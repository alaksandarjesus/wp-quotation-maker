<?php

use Plugin\Validator\Validate;
use App\Models\Product;


if (!function_exists('wp_276026_quomak_products_search')) {

    function wp_276026_quomak_products_search()
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
            'query' => 'required|alpha_num'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $product = new Product;

        $query = $_POST['query'];

        $result = $product->reset()->where("name LIKE '%$query%'")->get();

        wp_send_json_success(['result' => $result]);

    }

}

add_action('wp_ajax_products/search', 'wp_276026_quomak_products_search');

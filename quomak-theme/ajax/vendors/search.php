<?php

use Plugin\Validator\Validate;
use App\Models\Vendor;


if (!function_exists('wp_788513_quomak_vendors_search')) {

    function wp_788513_quomak_vendors_search()
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

        $vendor = new Vendor;

        $query = $_POST['query'];

        $result = $vendor->reset()->where("business_name LIKE '%$query%'")->get();

        wp_send_json_success(['result' => $result]);

    }

}

add_action('wp_ajax_vendors/search', 'wp_788513_quomak_vendors_search');

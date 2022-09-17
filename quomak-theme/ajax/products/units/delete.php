<?php

use Plugin\Validator\Validate;
use App\Models\ProductUnit;


if(!function_exists('wp_739082_quomak_products_units_delete')){

    function wp_739082_quomak_products_units_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_product_units,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $unit = new ProductUnit;

        $uuid = $_GET['uuid'];

        if(!$unit->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $unit->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_products/units/delete', 'wp_739082_quomak_products_units_delete');
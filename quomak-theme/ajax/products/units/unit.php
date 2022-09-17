<?php

use Plugin\Validator\Validate;
use App\Models\ProductUnit;


if (!function_exists('wp_966587_quomak_products_units_unit')) {

    function wp_966587_quomak_products_units_unit()
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
            'uuid' => 'nullable|exists:quomak_product_units,uuid'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $unit = new ProductUnit;

        $uuid = !empty($_POST['uuid'])?$_POST['uuid']:NULL;

        if(empty($uuid)){

            $unit->create($_POST);

        }else{

            if(!$unit->can_update("uuid = '$uuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }

             $unit->update($_POST, ['uuid' => $uuid]);
        }


    
        wp_send_json_success(['reload'=> true]);

    }

}

add_action('wp_ajax_products/units/unit', 'wp_966587_quomak_products_units_unit');

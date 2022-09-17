<?php

use Plugin\Validator\Validate;
use App\Models\Vendor;


if(!function_exists('wp_348484_quomak_vendors_delete')){

    function wp_348484_quomak_vendors_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_vendors,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $vendor = new Vendor;

        $uuid = $_GET['uuid'];

        if(!$vendor->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $vendor->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_vendors/delete', 'wp_348484_quomak_vendors_delete');
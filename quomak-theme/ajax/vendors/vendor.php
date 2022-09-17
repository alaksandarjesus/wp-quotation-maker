<?php

use Plugin\Validator\Validate;
use App\Models\Vendor;


if (!function_exists('wp_569647_quomak_vendors_vendor')) {

    function wp_569647_quomak_vendors_vendor()
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
            'uuid' => 'nullable|exists:quomak_vendors,uuid'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $vendor = new Vendor;

        $uuid = !empty($_POST['uuid'])?$_POST['uuid']:NULL;

        if(empty($uuid)){

            $vendor->create($_POST);

        }else{

            if(!$vendor->can_update("uuid = '$uuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }

             $vendor->update($_POST, ['uuid' => $uuid]);
        }


    
        wp_send_json_success(['redirect' => site_url() . '/vendors']);

    }

}

add_action('wp_ajax_vendors/vendor', 'wp_569647_quomak_vendors_vendor');

<?php

use Plugin\Validator\Validate;
use App\Models\Quotation;
use App\Models\QuotationItem;


if(!function_exists('wp_804642_quomak_quotations_delete')){

    function wp_804642_quomak_quotations_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_quotations,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $quotation = new Quotation;

        $uuid = $_GET['uuid'];

        if(!$quotation->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $quotation_row = $quotation->reset()->where("uuid = '$uuid'")->first();

        $quotation->delete(['uuid' => $uuid]);

        $quotation_item = new QuotationItem;

        $quotation_item->reset()->delete(['quotation_id' => $quotation_row->id]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_quotations/delete', 'wp_804642_quomak_quotations_delete');
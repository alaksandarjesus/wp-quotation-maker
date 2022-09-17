<?php

use Plugin\Validator\Validate;
use App\Models\Project;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;


if (!function_exists('wp_831511_quomak_quotations__quotation_get')) {

    function wp_831511_quomak_quotations__quotation_get()
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
            'uuid' => 'required|exists:quomak_quotations,uuid'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $quotation = new Quotation;

       $uuid  = trim($_POST['uuid']);

       $result = $quotation->reset()->where("uuid = '$uuid'")->first();

       $project = new Project;

       $result->project = $project->reset()->where("id = $result->project_id")->first();

       $quotationItem = new QuotationItem;

       $result->items = $quotationItem->reset()->where("quotation_id = $result->id")->get();

       foreach($result->items as $item){

        $product = new Product;

        $item->product = $product->reset()->where("id = $item->product_id")->first();

       }


        wp_send_json_success($result);

    }

}

add_action('wp_ajax_quotations/quotation/get', 'wp_831511_quomak_quotations__quotation_get');

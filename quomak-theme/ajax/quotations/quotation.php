<?php

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Project;
use App\Models\Product;
use Plugin\Validator\Validate;

if (!function_exists('wp_990180_quomak_quotations_quotation')) {

    function wp_990180_quomak_quotations_quotation()
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
            'uuid' => 'nullable|exists:quomak_quotations,uuid',
            'project' => 'required|exists:quomak_projects,uuid',
            'quotation_number' => 'required',
            'quotation_date' => 'nullable|date:Y-m-d',
            'subtotal' => 'nullable|numeric',
            'taxtotal' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'notes' => 'nullable|max:200',
            'items' => 'required|array',
            'items.*.product' => 'required|exists:quomak_products,uuid',
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $uuid = !empty($_POST['uuid']) ? trim($_POST['uuid']) : null;

        $quotation_number = !empty($_POST['quotation_number']) ? trim($_POST['quotation_number']) : null;

      
            $quotation = new Quotation;

            $conflict_quotation_number = $quotation->reset()->where("quotation_number = '$quotation_number' AND uuid <> '$uuid'")->first();

            if (!empty($conflict_quotation_number)) {

               wp_send_json_error(['errors' => ['Quotation number is already assigned. Please select another one.']]);

            }

        $project_uuid = !empty($_POST['project']) ? trim($_POST['project']) : null;

        $project = new Project;

        $project_row =  $project->reset()->where("uuid = '$project_uuid'")->first();

        $_POST['project_id'] = $project_row->id;

        $quotation = new Quotation;

        if(empty($uuid)){

           $insert_id =  $quotation->create($_POST);

           $quotation_row = $quotation->reset()->where("id = '$insert_id'")->first();

        }else{

            if(!$quotation->can_update("uuid = '$uuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }

             $quotation->update($_POST, ['uuid' => $uuid]);

            $quotation_row = $quotation->reset()->where("uuid = '$uuid'")->first();

        }

        $quotation_item = new QuotationItem;

        $reset=$quotation_item->reset()->delete(["quotation_id" => $quotation_row->id]);

        foreach($_POST['items'] as $item){

            $product = new Product;

            $item_product_uuid = $item['product'];

            $product_row = $product->reset()->where("uuid = '$item_product_uuid'")->first();

            $item['product_id'] = $product_row->id;

            $item['quotation_id'] = $quotation_row->id;

            $quotationItem = new QuotationItem;

            $quotationItem->create($item);


        }



        wp_send_json_success(['redirect' => site_url('quotations')]);

    }

}

add_action('wp_ajax_quotations/quotation', 'wp_990180_quomak_quotations_quotation');

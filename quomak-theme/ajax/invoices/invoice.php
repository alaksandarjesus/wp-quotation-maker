<?php

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use App\Models\Product;
use Plugin\Validator\Validate;

if (!function_exists('wp_148375_quomak_invoices_invoice')) {

    function wp_148375_quomak_invoices_invoice()
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

            $conflict_quotation_number_in_quotation = $quotation->reset()->where("quotation_number = '$quotation_number' AND uuid <> '$uuid'")->first();

            if (!empty($conflict_quotation_number)) {

               wp_send_json_error(['errors' => ['Quotation number is already assigned in quotations. Please select another one.']]);

            }

            $invoice = new Invoice;

            $conflict_quotation_number_in_invoice = $invoice->reset()->where("quotation_number = '$quotation_number'")->first();

            if (!empty($conflict_quotation_number)) {

               wp_send_json_error(['errors' => ['Quotation number is already assigned in invoices. Please select another one.']]);

            }

        $project_uuid = !empty($_POST['project']) ? trim($_POST['project']) : null;

        $project = new Project;

        $project_row =  $project->reset()->where("uuid = '$project_uuid'")->first();

        $_POST['project_id'] = $project_row->id;

        $invoice = new Invoice;


           $insert_id =  $invoice->create($_POST);

           $invoice_row = $invoice->reset()->where("id = '$insert_id'")->first();

        
        foreach($_POST['items'] as $item){

            $product = new Product;

            $item_product_uuid = $item['product'];

            $product_row = $product->reset()->where("uuid = '$item_product_uuid'")->first();

            $item['product_id'] = $product_row->id;

            $item['invoice_id'] = $invoice_row->id;

            $invoice_item = new InvoiceItem;

            $invoice_item->create($item);


        }

        if(!$uuid){

            $quotation = new Quotation;

            $quotation_row = $quotation->reset()->where("uuid = '$uuid'")->first();

            if(!empty($quotation_row)){

                $quotation_item = new QuotationItem;

                $quotation_item->reset()->delete(['quotation_id' => $quotation_row->id]);

                $quotation->reset()->delete(['id' => $quotation_row->id]);

            }
        }



        wp_send_json_success(['redirect' => site_url('invoices')]);

    }

}

add_action('wp_ajax_invoices/invoice', 'wp_148375_quomak_invoices_invoice');

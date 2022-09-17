<?php

use Plugin\Validator\Validate;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;

if(!function_exists('wp_019907_quomak_transactions_transaction')){

    function wp_019907_quomak_transactions_transaction(){

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
            'invoiceUuid' => 'required|exists:quomak_invoices,uuid',
            'itemUuid' => 'required|exists:quomak_invoice_items,uuid',
            'factor' => 'required|numeric',
            'amount' => 'required|numeric',
            'notes' => 'required|max:250',
        ];

        $messages = [
            "invoiceUuid.exists" => "Invoice does not exists",
            "itemUuid.exists" => "Invoice Item does not exists",
        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $factor = trim($_POST['factor']);

        if(($factor != 1) && ($factor != -1)){
            wp_send_json_error(['errors' => ['factor should be either 1 or -1']]);
        }

       
        $invoice = new Invoice;

        $invoice_item = new InvoiceItem;

        $invoiceUuid = trim($_POST['invoiceUuid']);

        $itemUuid = trim($_POST['itemUuid']);

        $invoice_row = $invoice->reset()->where("uuid  = '$invoiceUuid'")->first();

        if(empty($invoice_row)){

            wp_send_json_error(['errors' => ['Invoice row is not identified']]);

        }

        $invoice_item_row = $invoice_item->reset()->where("uuid = '$itemUuid' AND invoice_id = $invoice_row->id")->first();

        if(empty($invoice_item_row)){

            wp_send_json_error(['errors' => ['Invoice item row is not identified']]);

        }


        $_POST['amount'] = $_POST['amount'] * $factor;

        $transaction = new Transaction;

        $_POST['invoice_item_id'] = $invoice_item_row->id;

        $transaction->create($_POST);
       
        return wp_send_json_success();

    }
}

add_action('wp_ajax_transactions/transaction', 'wp_019907_quomak_transactions_transaction');
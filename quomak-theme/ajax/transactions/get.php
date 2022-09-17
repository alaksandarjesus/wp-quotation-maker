<?php

use Plugin\Validator\Validate;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;

if(!function_exists('wp_404303_quomak_transactions_get')){

    function wp_404303_quomak_transactions_get(){

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
        ];

        $messages = [
            "invoiceUuid.exists" => "Invoice does not exists",
            "itemUuid.exists" => "Invoice Item does not exists",
        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
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

        $transaction = new Transaction;

        $received = $transaction->reset()->where("invoice_item_id = $invoice_item_row->id AND amount > 0")->sum('amount');
        $expense = $transaction->reset()->where("invoice_item_id = $invoice_item_row->id AND amount < 0")->sum('amount');

        $result = [
            'received' => $received,
            'expense' => $expense,
            'profit' => $received + $expense
        ];

       
        return wp_send_json_success($result);

    }
}

add_action('wp_ajax_transactions/get', 'wp_404303_quomak_transactions_get');
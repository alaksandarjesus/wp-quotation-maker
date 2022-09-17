<?php

use Plugin\Validator\Validate;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;

if(!function_exists('wp_848021_quomak_transactions_invoice')){

    function wp_848021_quomak_transactions_invoice(){

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
        ];

        $messages = [
            "invoiceUuid.exists" => "Invoice does not exists",
        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }
       
        $invoice = new Invoice;

        $invoice_item = new InvoiceItem;

        $invoiceUuid = trim($_POST['invoiceUuid']);

        $invoice_row = $invoice->reset()->where("uuid  = '$invoiceUuid'")->first();

        if(empty($invoice_row)){

            wp_send_json_error(['errors' => ['Invoice row is not identified']]);

        }

        $invoice_item_rows = $invoice_item->reset()->where("invoice_id =  $invoice_row->id")->get();

        if(empty($invoice_item_rows)){

            wp_send_json_error(['errors' => ['Invoice item row is not identified']]);

        }

        $invoice_item_row_ids = array_map(function($item){
            return $item->id;
        }, $invoice_item_rows);

        $received = 0;
        $expense = 0;

        foreach($invoice_item_row_ids as $id){
            $transaction = new Transaction;

            $received += $transaction->reset()->where("invoice_item_id = $id AND amount > 0")->sum('amount');
            $expense += $transaction->reset()->where("invoice_item_id = $id AND amount < 0")->sum('amount');
    
        }

       
        $result = [
            'received' => $received,
            'expense' => $expense,
            'profit' => $received + $expense
        ];

       
        return wp_send_json_success($result);

    }
}

add_action('wp_ajax_transactions/invoice', 'wp_848021_quomak_transactions_invoice');
<?php

use Plugin\Validator\Validate;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Project;

if(!function_exists('wp_546995_quomak_transactions_csv')){

    function wp_546995_quomak_transactions_csv(){

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

        

        $received = 0;

        $expense = 0;



        $transaction_rows = array_map(function($item){
            $transaction = new Transaction;
            return $transaction->reset()->where("invoice_item_id = $item->id")->get();
        }, $invoice_item_rows);
        
        $transaction_rows_flattened = [];

        foreach($transaction_rows as $rows){
            foreach($rows as &$row){
                $invoice_item = new InvoiceItem;
                $invoice_item_row = $invoice_item->reset()->where("id = $row->invoice_item_id")->first();
                $row->product_name = '';
                $row->product_code = '';
                if(!empty($invoice_item_row)){
                    $product = new Product;
                    $product_row = $product->reset()->where("id = $invoice_item_row->product_id")->first();
                    if(!empty($product_row)){
                        $row->product_name = $product_row->name;
                        $row->product_code = $product_row->code;
                    }
                }
                $transaction_rows_flattened[] = [
                    'amount' => $row->amount,
                    'created_at' => $row->created_at,
                    'created_at_timestamp' => strtotime($row->created_at),
                    'product_name' => $row->product_name,
                    'product_code' => $row->product_code,
                    'notes' => $row->notes,
                ];
            }
        }



        $project = new Project;
        $project_row = $project->reset()->where("id = $invoice_row->project_id")->first();



       
        return wp_send_json_success(['transactions' => $transaction_rows_flattened, 'invoice'=>$invoice_row, 'project' => $project_row]);

    }
}

add_action('wp_ajax_transactions/csv', 'wp_546995_quomak_transactions_csv');
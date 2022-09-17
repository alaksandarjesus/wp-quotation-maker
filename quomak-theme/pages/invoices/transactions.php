<?php

use App\Models\Invoice;

$uuid = !empty($_GET['uuid'])?$_GET['uuid']:NULL;

$invoice = new Invoice;

$invoice_row = $invoice->reset()->where("uuid = '$uuid'")->first();

if(empty($invoice_row)){ ?> 
<div class="container-fluid">
    <div class="row">
        <div class="col-12  col-md-6 offset-md-3">
    <div class="alert alert-warning">
        <div class="strong">No matching invoice found</div>
    </div>
    </div>
    </div>
</div>

<?php return; } ?>

<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Invoice Transactions</h4>
                <div>
                    <button class="btn btn-primary btn-download-as-csv table transactions" data-invoice-uuid="<?php echo $uuid; ?>">Download as CSV</button>
                </div>
            </div>
        </div>
    </div>
</div>



<?php get_template_part('pages/invoices/transactions-table'); ?>
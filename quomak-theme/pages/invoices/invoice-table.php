<?php

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Project;
use App\Models\Customer;

$uuid = !empty($_GET['uuid'])?$_GET['uuid']:NULL;

$invoice = new Invoice;

$invoice_row = $invoice->reset()->where("uuid = '$uuid'")->first();

$project = new Project;
$project_row = $project->reset()->where("id = $invoice_row->project_id")->first();
$invoice_row->project = $project_row;
if(!empty($project_row)){
    $customer = new Customer;
    $invoice_row->customer = $customer->reset()->where("id = $project_row->customer_id")->first();
}
$invoiceItem = new InvoiceItem;

$invoice_row->items = $invoiceItem->reset()->where("invoice_id = $invoice_row->id")->get();

foreach($invoice_row->items as $item){
    $product = new Product;
    $product_row = $product->reset()->where("id = $item->product_id")->first();
    if(!empty($product_row)){
        $product_unit = new ProductUnit;
        $product_unit_row = $product_unit->where("id = $product_row->unit_id")->first();
        if(!empty($product_unit_row)){
            $product_row->unit = $product_unit_row;
        }
        $item->product = $product_row;
    }

}


?>


<div class="container-fluid my-3 print">
    <div class="row">
        <div class="col-3">
            <div class="fw-500">Quotation Number</div>
            <div class="quotation-number"><?php echo $invoice_row->quotation_number; ?></div>
        </div>
        <div class="col-3">
            <div class="fw-500">Quotation Date</div>
            <div><?php echo $invoice_row->quotation_date; ?></div>
        </div>
        <div class="col-3">
            <div class="fw-500">Project</div>
            <div class="project"><?php echo !empty($invoice_row->project)?$invoice_row->project->name:NULL; ?></div>
        </div>
        <div class="col-3">
            <div class="fw-500">Customer</div>
            <div><?php echo !empty($invoice_row->customer)?$invoice_row->customer->business_name:NULL; ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered invoice">
                <thead>
                    <tr>
                        <th style="width:80px">SNO</th>
                        <th>Product</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoice_row->items as $index => $item){ ?> 
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td>
                                    <div class="product-name">
                                        <?php echo !empty($item->product)?$item->product->name:NULL;?>
                                    </div>
                                    <div class="product-code">
                                        <?php echo !empty($item->product)?$item->product->code:NULL;?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="product-unit">
                                        <?php echo !empty($item->product) && !empty($item->product->unit)?$item->product->unit->name:NULL;?>
                                    </div>
                                </td>
                                <td class="text-center qty">
                                    <?php echo $item->qty; ?>
                                </td>
                                <td class="text-end price">
                                    <?php echo $item->price; ?>
                                </td>
                                <td class="text-end tax">
                                    <?php echo $item->tax; ?>
                                </td>
                                <td class="text-end total">
                                    <?php echo $item->total; ?>
                                </td>
                            </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" class="text-end">Sub Total</th>
                        <td  class="text-end"><?php echo $invoice_row->subtotal; ?></td>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Tax Total</th>
                        <td  class="text-end"><?php echo $invoice_row->taxtotal; ?></td>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Discount</th>
                        <td  class="text-end"><?php echo $invoice_row->discount; ?></td>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Total</th>
                        <td  class="text-end"><?php echo $invoice_row->total; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
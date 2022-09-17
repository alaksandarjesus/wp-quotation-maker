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
            <table class="table table-bordered invoice-transactions"
                data-invoice-uuid="<?php echo $invoice_row->uuid; ?>">
                <thead>
                    <tr>
                        <th style="width:80px">SNO</th>
                        <th>Product</th>
                        <th style="width:100px">Unit</th>
                        <th style="width:100px">Qty</th>
                        <th style="width:100px">Price</th>
                        <th style="width:100px">Tax</th>
                        <th style="width:100px">Total</th>
                        <th style="width:100px">Received</th>
                        <th style="width:100px">Expenses</th>
                        <th style="width:100px">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoice_row->items as $index => $item){ ?>
                    <tr data-item-uuid="<?php echo $item->uuid; ?>">
                        <td><?php echo $index + 1; ?></td>
                        <td>
                            <div class="product-name">
                                <?php echo !empty($item->product)?$item->product->name:NULL;?>
                            </div>
                            <div class="product-code">
                                <?php echo !empty($item->product)?$item->product->code:NULL;?>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <button class="btn btn-link text-success btn-funds" data-factor="1">Add Funds</button>
                                <button class="btn btn-link text-danger  btn-funds" data-factor="-1">Release
                                    Funds</button>
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
                        <td class="received"></td>
                        <td class="expense"></td>
                        <td class="profit"></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" class="text-end">Sub Total</th>
                        <td class="text-end"><?php echo $invoice_row->subtotal; ?></td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Tax Total</th>
                        <td class="text-end"><?php echo $invoice_row->taxtotal; ?></td>
                        <td colspan="3"></td>


                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Discount</th>
                        <td class="text-end"><?php echo $invoice_row->discount; ?></td>
                        <td colspan="3"></td>


                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Total</th>
                        <td class="text-end"><?php echo $invoice_row->total; ?></td>
                        <td class="received"></td>
                        <td class="expense"></td>
                        <td class="profit"></td>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>



<div class="modal modal-invoice-transaction fade" tabindex="-1" aria-labelledby="modalInvoiceTransactionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInvoiceTransactionLabel">Transaction Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="factor" class="factor">
                <input type="hidden" name="invoiceUuid" class="invoice-uuid">
                <input type="hidden" name="itemUuid" class="item-uuid">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Amount</label>
                    <input type="text" name="amount" class="form-control amount">
                </div>

                <div class="form-group mb-3">
                    <label for="" class="form-label">Notes</label>
                    <textarea class="notes form-control" name="notes"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button class="btn btn-primary" type="submit" aria-label="Close">Submit</button>
            </div>
        </form>
    </div>
</div>
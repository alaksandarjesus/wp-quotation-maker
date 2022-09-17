<?php

use App\Models\Product;
use App\Models\ProductUnit;

$product = new Product;

$products = $product->reset()->orderBy('name', 'ASC')->get();

foreach($products as &$product){
    $product_unit = new ProductUnit;
    $product->unit = $product_unit->reset()->where("id = $product->unit_id")->first();
}


?>

<div class="container-fluid my-3">
    <div class="col-12">
        <table class="table table-bordered quotation-form">
            <thead>
                <tr>
                    <th style="width:80px">S.NO</th>
                    <th>Code</th>
                    <th>Item</th>
                    <th>Unit</th>
                    <th style="width:150px">Qty</th>
                    <th style="width:150px">Price</th>
                    <th style="width:150px">Tax</th>
                    <th style="width:150px">Total</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="text-end">Subtotal</th>
                    <td>
                        <input type="text" class="form-control subtotal text-end" readonly value="0.00">
                    </td>
                </tr>
                <tr>
                    <th colspan="7" class="text-end">Tax</th>
                    <td>
                        <input type="text" class="form-control taxtotal text-end" readonly value="0.00">
                    </td>
                </tr>
                <tr>
                    <th colspan="7" class="text-end">Discount</th>
                    <td>
                        <input type="text" class="form-control discount text-end number-formatted on-change-calculate-total" value="0.00">
                    </td>
                </tr>
                <tr>
                    <th colspan="7" class="text-end">Total</th>
                    <td>
                        <input type="text" class="form-control total text-end" readonly value="0.00">
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        <textarea class="notes form-control" placeholder="Quotation Notes"></textarea>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-primary btn-save me-2">Save</button>
                <button type="button" class="btn btn-danger btn-submit">Submit</button>
            </div>
        </div>
    </div>
</div>

<script id="table-quotation-form-row" type="text/html">
    <tr>
        <td class="sno"></td>
        <td class="code">

        </td>
        <td class="">
            <select class="form-select product">
                <option value="">Select Product</option>
                <?php foreach($products as $item){ ?> 
                    <option value="<?php echo $item->uuid; ?>" data-code="<?php echo $item->code; ?>" data-unit="<?php echo !empty($item->unit)?$item->unit->name:''; ?>"><?php echo $item->name; ?></option>    
                <?php } ?>
            </select>
        </td>
        <td class="unit">
            
        </td>
        <td>
            <input type="text" class="form-control text-end qty number-formatted on-change-calculate-total" value="0.00">
        </td>
        <td>
            <input type="text" class="form-control text-end price number-formatted on-change-calculate-total" value="0.00">
        </td>
        <td>
            <input type="text" class="form-control text-end tax number-formatted on-change-calculate-total" value="0.00">
        </td>
        <td>
            <input type="text" class="form-control text-end total on-blur-new-row  number-formatted" value="0.00" readonly>
        </td>
    </tr>
</script>


import { get } from "lodash";
import * as numeral from 'numeral';

export const InvoiceItemTransactionDetail = ()=>{
    const loadingIcon = `<div class="d-flex justify-content-center align-items-center">
    <span class="material-icons-outlined rotate">
    autorenew
    </span>
    </div>`
    jQuery("table.invoice-transactions tbody tr").each(function(){
        const tr$ = jQuery(this);
        tr$.find('.received').html(loadingIcon);
        tr$.find('.expense').html(loadingIcon);
        tr$.find('.profit').html(loadingIcon);
        const data = {
            invoiceUuid:tr$.closest('table').attr('data-invoice-uuid'),
            itemUuid:tr$.attr('data-item-uuid'),
        }
        jQuery.ajax({
            action:'transactions/get',
            method: 'POST',
            data:data,
            success: function(res){
                tr$.find('.received').html(setTransactionValue(res,'received'));
                tr$.find('.expense').html(setTransactionValue(res,'expense'));
                tr$.find('.profit').html(setTransactionValue(res,'profit'));
            }
        })
        getInvoiceTransaction();
    });

    function getInvoiceTransaction(){
        const table$ = jQuery("table.invoice-transactions");
        const invoiceUuid = table$.attr('data-invoice-uuid');
        table$.find('tfoot').find('.received').html(loadingIcon);
                table$.find('tfoot').find('.expense').html(loadingIcon);
                table$.find('tfoot').find('.profit').html(loadingIcon);
        const data = {
            invoiceUuid:invoiceUuid,
        }
        jQuery.ajax({
            action:'transactions/invoice',
            method: 'POST',
            data:data,
            success: function(res){
                table$.find('tfoot').find('.received').html(setTransactionValue(res,'received'));
                table$.find('tfoot').find('.expense').html(setTransactionValue(res,'expense'));
                table$.find('tfoot').find('.profit').html(setTransactionValue(res,'profit'));
            }
        })

    }

    function setTransactionValue(res, prop){
        return `<div class="d-flex justify-content-end align-items-center">
        ${numeral(get(res, 'data.'+prop, 0)).format('0.00')}
        </div>`
    }


}
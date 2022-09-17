import { Rules } from './validation';
import { trim } from 'lodash';
import { InvoiceItemTransactionDetail } from './invoice-item-transaction-detail';

jQuery(function(){
    const transactionsTable = jQuery("table.invoice-transactions");
    if(!transactionsTable.length){
        return;
    }
    const modalTransactionEle = jQuery(".modal.modal-invoice-transaction");
    const config = {backdrop:'static', keyboard:false};
    const modalTransactionInstance = new bootstrap.Modal(modalTransactionEle[0], config);


    transactionsTable.on('click', '.btn-funds', function(){
        const invoiceUuid = jQuery(this).closest('table').attr('data-invoice-uuid');
        const itemUuid = jQuery(this).closest('tr').attr('data-item-uuid');
        const factor = jQuery(this).attr('data-factor');
        modalTransactionEle.find('.invoice-uuid').val(trim(invoiceUuid));
        modalTransactionEle.find('.item-uuid').val(trim(itemUuid));
        modalTransactionEle.find('.factor').val(trim(factor));
        modalTransactionEle.find('.amount').val('');
        modalTransactionEle.find('.notes').val('');
        modalTransactionInstance.show();

        modalTransactionEle.find('form').validate({
            rules:Rules,
            submitHandler: function(form, event){
                modalTransactionInstance.hide();
               
                onTransactionSubmit(form, event);
            }
        })
    })

    function onTransactionSubmit(form, event){
        event.preventDefault();
        event.stopPropagation();

        const form$ = jQuery(form);
        const data = {
            invoiceUuid: trim(form$.find('.invoice-uuid').val()),
            itemUuid: trim(form$.find('.item-uuid').val()),
            factor: trim(form$.find('.factor').val()),
            amount: trim(form$.find('.amount').val()),
            notes: trim(form$.find('.notes').val()),
        }
        
        jQuery.ajax({
            action: 'transactions/transaction',
            method: 'POST',
            data:data,
            success:function(res){
                InvoiceItemTransactionDetail();
            }
        })

    }
 
   

    



});
import { isEmpty } from 'lodash';
import { InvoiceItemTransactionDetail } from './invoice-item-transaction-detail';

jQuery(function(){

    const invoiceTransactionsTable = jQuery(".table.invoice-transactions");
    if(isEmpty(invoiceTransactionsTable)){
        return;
    }

    InvoiceItemTransactionDetail()

});
import { cloneDeep, trim} from 'lodash';
import { ExportAsCsv } from '../shared/export-as-csv';

jQuery(function(){

    const downloadAsCSV = jQuery(".btn-download-as-csv.table.invoice");

    if(!downloadAsCSV.length){
        return;
    }

    downloadAsCSV.on('click', function(){
       const quotationNumber = trim(jQuery(".quotation-number").text());
       const project = trim(jQuery(".project").text());
        const data = [];
       jQuery("table.invoice tbody tr").each(function(){
        const temp ={
            code: trim(jQuery(this).find('.product-code').text()),
            product: trim(jQuery(this).find('.product-name').text()),
            unit: trim(jQuery(this).find('.product-unit').text()),
            qty: trim(jQuery(this).find('.qty').text()),
            price: trim(jQuery(this).find('.price').text()),
            tax: trim(jQuery(this).find('.tax').text()),
            total: trim(jQuery(this).find('.total').text()),
        }
        data.push(cloneDeep(temp));
       })
       const filename = project+'-'+quotationNumber;
       ExportAsCsv({filename:filename, data:data});
    });




});
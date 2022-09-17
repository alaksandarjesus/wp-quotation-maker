import { cloneDeep, trim} from 'lodash';
import { ExportAsCsv } from '../shared/export-as-csv';

jQuery(function(){
    const downloadAsCSV = jQuery(".btn-download-as-csv.table.quotation");

    if(!downloadAsCSV.length){
        return;
    }
    downloadAsCSV.on('click', function(){
       const quotationNumber = trim(jQuery(".quotation-number").val());
       const project = trim(jQuery(".select-project option:selected").text());
        const data = [];
       jQuery("table.quotation-form tbody tr").each(function(){
        const temp ={
            code: trim(jQuery(this).find('.code').text()),
            product: trim(jQuery(this).find('.product option:selected').text()),
            unit: trim(jQuery(this).find('.unit').text()),
            qty: trim(jQuery(this).find('.qty').val()),
            price: trim(jQuery(this).find('.price').val()),
            tax: trim(jQuery(this).find('.tax').val()),
            total: trim(jQuery(this).find('.total').val()),
        }
        data.push(cloneDeep(temp));
       })
       const filename = project+'-'+quotationNumber;
       ExportAsCsv({filename:filename, data:data});
    });




});
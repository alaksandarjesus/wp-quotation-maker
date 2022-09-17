import { get } from "lodash";
import { ExportAsCsv } from '../../shared/export-as-csv';

jQuery(function(){

    const downloadAsCsvBtn = jQuery(".btn-download-as-csv.table.transactions");

    if(!downloadAsCsvBtn?.length){
        return;
    }

    downloadAsCsvBtn.on('click', function(){

        const data = {
            invoiceUuid: downloadAsCsvBtn.attr('data-invoice-uuid')
        }
    
        jQuery.ajax({
            action: 'transactions/csv',
            method:"POST",
            data:data,
            success: function(res){
                const success = get(res, 'success', false);
                if(!success){
                    return;
                }

                const projectName = get(res,'data.project.name', 'unknown-project');
                const quotationNumber = get(res,'data.invoice.quotation_number', 'unknown-project');
                const filename = projectName+'-'+quotationNumber;
                ExportAsCsv({filename:filename, data:get(res, 'data.transactions', [])});
            }
        })
    
    })

   

})
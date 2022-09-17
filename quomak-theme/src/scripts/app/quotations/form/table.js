import { isEmpty } from 'lodash';
import * as numeral from 'numeral';

jQuery(function(){
    const quotationForm = jQuery("form.quotation");

    if(!quotationForm.length){
        return;
    }

    const quotationFormTable = jQuery("table.quotation-form");
    if(!quotationFormTable.length){
        return;
    }

    const quotationUuid = quotationForm.attr('data-quotation-uuid');

    if(isEmpty(quotationUuid)){
        createNewRow();
    }

    quotationFormTable.on('blur', '.on-blur-new-row', function(){
        const rowIndex = jQuery(this).closest("tr").index();
        const rowsLength = quotationFormTable.find('tbody tr').length;
        if(rowIndex !== rowsLength-1){
            return;
        }
        createNewRow();

    });

    quotationFormTable.on('blur', '.on-change-calculate-total', function(){
        setTimeout(()=>{
            calculateTotals();
        })
        
    })

    quotationFormTable.on('change', '.product', function(){
        const unit = jQuery(this).find('option:selected').attr('data-unit');
        jQuery(this).closest('tr').find('.unit').text(unit);
        const code = jQuery(this).find('option:selected').attr('data-code');
        jQuery(this).closest('tr').find('.code').text(code);
    });

    quotationFormTable.on('blur', '.number-formatted', function(){
        let val = jQuery(this).val();
        if(!val || isNaN(val)){
            val = 0;
        }

        jQuery(this).val(numeral(val).format('0.00'));
    });

    function calculateTotals(){
        let subtotal = 0;
        let taxtotal = 0;
        let overalltotal = 0;
        quotationFormTable.find('tbody tr').each(function(){
            const price = jQuery(this).find('.price').val();
            const qty = jQuery(this).find('.qty').val();
            const tax = jQuery(this).find('.tax').val();
            const total = (parseFloat(price) * parseFloat(qty))+(parseFloat(tax));
            subtotal += (parseFloat(price) * parseFloat(qty));
            taxtotal += (parseFloat(tax));
            overalltotal += total;
            jQuery(this).find('.total').val(numeral(total).format('0.00'))
        });

        quotationFormTable.find('.subtotal').val(numeral(subtotal).format('0.00'));
        quotationFormTable.find('.taxtotal').val(numeral(taxtotal).format('0.00'));
        const discount = quotationFormTable.find('tfoot .discount').val();
        overalltotal = parseFloat(overalltotal)  - parseFloat(discount);
        quotationFormTable.find('tfoot .total').val(numeral(overalltotal).format('0.00'));

    }

    function createNewRow(){
        const template = jQuery("#table-quotation-form-row").html();
        const compiled = _.template(template)({});
        quotationFormTable.find('tbody').append(compiled);
        indexRows();
    }

    function indexRows(){
        let start = 1;
        quotationFormTable.find('tbody tr').each(function(){
            jQuery(this).find('.sno').text(start);
            start++;
        })
    }


});
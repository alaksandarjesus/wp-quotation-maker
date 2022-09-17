import { cloneDeep, isEmpty } from 'lodash';
import { ModalConfirm } from '../../shared/modal-confirm';
import { ModalAlert } from '../../shared/modal-alert';


jQuery(function(){
    const quotationForm = jQuery("form.quotation");

    if(!quotationForm.length){
        return;
    }

    const quotationFormTable = jQuery("table.quotation-form");
    if(!quotationFormTable.length){
        return;
    }

    quotationForm.on('click', '.btn-save', function(){
        collectFormData(false);
    });
    quotationForm.on('click', '.btn-submit', function(){
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "By clicking on submit you wont be able to edit this quotation and will be moved to invoices",
            btnYes: {
                text: "Yes",
                click: ()=>{
                    collectFormData(true);
                }
            },
            btnNo: {
                text: "No",
            }
        }
        const config = {backdrop:'static', keyboard:false};
        modalConfirm.show(args,  config);

    });

    function collectFormData(isSubmitted){
        const data = {
            uuid: quotationForm.attr('data-quotation-uuid'),
            quotation_number: quotationForm.find('.quotation-number').val(),
            quotation_date: quotationForm.find('.quotation-date').val(),
            project: quotationForm.find('.select-project').val(),
            items:[],
            subtotal:quotationFormTable.find('tfoot .subtotal').val(),
            taxtotal:quotationFormTable.find('tfoot .taxtotal').val(),
            discount:quotationFormTable.find('tfoot .discount').val(),
            total:quotationFormTable.find('tfoot .total').val(),
            notes:quotationFormTable.find('tfoot .notes').val(),
        }
        quotationFormTable.find('tbody tr').each(function(){
            const temp = 
                {
                    product: jQuery(this).find('.product').val(),
                    qty: jQuery(this).find('.qty').val(),
                    price: jQuery(this).find('.price').val(),
                    tax: jQuery(this).find('.tax').val(),
                    total: jQuery(this).find('.total').val(),
                }
                if(temp.product){
                    data.items.push(cloneDeep(temp));
                }
        })

        if(!quotationFormValid(data)){
            return;
        }
        data.quotation_date = moment(data.quotation_date, 'DD-MM-YYYY').format('YYYY-MM-DD');
        const action = isSubmitted?'invoices/invoice':'quotations/quotation';
        jQuery.ajax({
            action: action,
            method: 'POST',
            data:data,
            success: function(res){
                
            }
        })
    }

    function quotationFormValid(data){
        
        if(isEmpty(data.items)){
            const modalAlert = new ModalAlert();
            const args = {
                title: "Empty Items",
                text: "There are no items in the quotation to be filled",
                
            }
            const config = {backdrop:'static', keyboard:false};
            modalAlert.show(args,  config);
            return false;
        }
        if(!data.quotation_number){
            const modalAlert = new ModalAlert();
            const args = {
                title: "Quotation Number is required",
                text: "Quotation Number is required",
                
            }
            const config = {backdrop:'static', keyboard:false};
            modalAlert.show(args,  config);
            return false;
        }
        if(data.quotation_date && !moment(data.quotation_date, 'DD-MM-YYYY').isValid()){
            const modalAlert = new ModalAlert();
            const args = {
                title: "Invalid Quotation Date Format",
                text: "Quotation Date Format should be dd-mm-yyyy",
                
            }
            const config = {backdrop:'static', keyboard:false};
            modalAlert.show(args,  config);
            return false;
        }



        return true;
       
    }
})
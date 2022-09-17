import { ColumnDefns } from './column-defns';
import { Datatable } from '../shared/datatable';
import { ModalConfirm } from '../shared/modal-confirm';
import { get } from 'lodash';
jQuery(function () {
    const invoicesTable = jQuery('table.invoices');
    if (!invoicesTable.length) {
        return;
    }

    const datatable = new Datatable();
    datatable.action = 'invoices/list';
    invoicesTable.DataTable(datatable.config(ColumnDefns));
 

    invoicesTable.on('click', '.btn-edit', function(event){
       const uuid = jQuery(this).closest('tr').attr('data-uuid');
       const url = window.location.href.split('?');
        window.location = url[0]+'?view=view&uuid='+uuid;
    });
    invoicesTable.on('click', '.btn-transactions', function(event){
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const url = window.location.href.split('?');
         window.location = url[0]+'?view=transactions&uuid='+uuid;
     });
    invoicesTable.on('click', '.btn-delete', function(event){
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const quotationNumber = jQuery(this).closest('tr').find('.quotation_number').text();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this invoice <strong>"+quotationNumber+"</strong>",
            btnYes: {
                text: "Yes",
                click: ()=>{
                    onDeleteConfirm(uuid)
                }
            },
            btnNo: {
                text: "No",
            }
        }
        const config = {backdrop:'static', keyboard:false};
        modalConfirm.show(args,  config);
    })

    function onDeleteConfirm(uuid){
        jQuery.ajax({
            action: 'invoices/delete',
            method: 'GET',
            data: {uuid: uuid},
            success:function(res){
                const success = get(res, 'success', false);
                if(!success){
                    return;
                }
                invoicesTable.DataTable().ajax.reload()
            }
        })
    }
})
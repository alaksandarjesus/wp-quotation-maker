import { ColumnDefns } from './column-defns';
import { Datatable } from '../shared/datatable';
import { ModalConfirm } from '../shared/modal-confirm';
import { get } from 'lodash';
jQuery(function () {
    const quotationsTable = jQuery('table.quotations');
    if (!quotationsTable.length) {
        return;
    }

    const datatable = new Datatable();
    datatable.action = 'quotations/list';
    quotationsTable.DataTable(datatable.config(ColumnDefns));
 

    quotationsTable.on('click', '.btn-edit', function(event){
       const uuid = jQuery(this).closest('tr').attr('data-uuid');
       const url = window.location.href.split('?');
        window.location = url[0]+'?view=update&uuid='+uuid;
    });
    
    quotationsTable.on('click', '.btn-delete', function(event){
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const quotationNumber = jQuery(this).closest('tr').find('.quotation_number').text();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this quotation <strong>"+quotationNumber+"</strong>",
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
            action: 'quotations/delete',
            method: 'GET',
            data: {uuid: uuid},
            success:function(res){
                const success = get(res, 'success', false);
                if(!success){
                    return;
                }
                quotationsTable.DataTable().ajax.reload()
            }
        })
    }
})
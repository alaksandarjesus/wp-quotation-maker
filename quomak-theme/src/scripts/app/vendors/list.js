import { ColumnDefns } from './column-defns';
import { Datatable } from '../shared/datatable';
import { ModalConfirm } from '../shared/modal-confirm';
import { get } from 'lodash';

jQuery(function () {
    const vendorsTable = jQuery('table.vendors');
    if (!vendorsTable.length) {
        return;
    }

    const datatable = new Datatable();
    datatable.action = 'vendors/list';
    vendorsTable.DataTable(datatable.config(ColumnDefns));
 

    vendorsTable.on('click', '.btn-edit', function(event){
       const uuid = jQuery(this).closest('tr').attr('data-uuid');
       const url = window.location.href.split('?');
        window.location = url[0]+'?view=update&uuid='+uuid;
    })
    vendorsTable.on('click', '.btn-delete', function(event){
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const businessName = jQuery(this).closest('tr').find('.business-name').text();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this business <strong>"+businessName+"</strong>",
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
            action: 'vendors/delete',
            method: 'GET',
            data: {uuid: uuid},
            success:function(res){
                const success = get(res, 'success', false);
                if(!success){
                    return;
                }
                vendorsTable.DataTable().ajax.reload()
            }
        })
    }
})
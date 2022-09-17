import { ColumnDefns } from './column-defns';
import { Datatable } from '../shared/datatable';
import { ModalConfirm } from '../shared/modal-confirm';
import { get } from 'lodash';

jQuery(function () {
    const productsTable = jQuery('table.products');
    if (!productsTable.length) {
        return;
    }

    const datatable = new Datatable();
    datatable.action = 'products/list';
    productsTable.DataTable(datatable.config(ColumnDefns));
 

    productsTable.on('click', '.btn-edit', function(event){
       const uuid = jQuery(this).closest('tr').attr('data-uuid');
       const url = window.location.href.split('?');
        window.location = url[0]+'?view=update&uuid='+uuid;
    });
    productsTable.on('click', '.btn-vendors', function(event){
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const url = window.location.href.split('?');
         window.location = url[0]+'?view=vendors&uuid='+uuid;
     });
     productsTable.on('click', '.btn-related', function(event){
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const url = window.location.href.split('?');
         window.location = url[0]+'?view=related&uuid='+uuid;
     });
    productsTable.on('click', '.btn-delete', function(event){
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const productName = jQuery(this).closest('tr').find('.name').text();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this product <strong>"+productName+"</strong>",
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
            action: 'products/delete',
            method: 'GET',
            data: {uuid: uuid},
            success:function(res){
                const success = get(res, 'success', false);
                if(!success){
                    return;
                }
                productsTable.DataTable().ajax.reload()
            }
        })
    }
})
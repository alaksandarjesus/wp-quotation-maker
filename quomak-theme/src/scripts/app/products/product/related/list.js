import { ColumnDefns } from './column-defns';
import { Datatable } from '../../../shared/datatable';
import { ModalConfirm } from '../../../shared/modal-confirm';
import { get } from 'lodash';

jQuery(function () {
    const relatedProductsTable = jQuery('table.product-related');
    if (!relatedProductsTable.length) {
        return;
    }

    const datatable = new Datatable();
    datatable.action = 'products/product/related/list';
    const tableInstance = relatedProductsTable.DataTable(datatable.config(ColumnDefns));

    relatedProductsTable.on('click', '.btn-delete', function(event){
        const rowData = tableInstance.row(jQuery(this).closest('tr')).data();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this related product <strong>"+get(rowData, 'product.name')+"</strong>",
            btnYes: {
                text: "Yes",
                click: ()=>{
                    onDeleteConfirm(get(rowData, 'uuid'))
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
            action: 'products/product/related/delete',
            method: 'GET',
            data: {rpuuid: uuid},
            success:function(res){
                const success = get(res, 'success', false);
                if(!success){
                    return;
                }
                relatedProductsTable.DataTable().ajax.reload()
            }
        })
    }

});
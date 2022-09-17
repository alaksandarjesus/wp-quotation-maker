import { get } from 'lodash';
import { Datatable } from '../../../shared/datatable';
import {  ColumnDefns } from './column-defns';
import { ModalConfirm } from '../../../shared/modal-confirm';


jQuery(function(){
    const productVendorsTable = jQuery("table.product-vendors");

    if (!productVendorsTable.length) {
        return;
    }

    const datatable = new Datatable();
    datatable.action = 'products/product/vendors/list';
    const tableInstance = productVendorsTable.DataTable(datatable.config(ColumnDefns));

    productVendorsTable.on('click', '.btn-edit', function(){
        const data = tableInstance.row(jQuery(this).closest('tr')).data();
        const productVendorsForm = jQuery("form.product-vendor");
        productVendorsForm.find("[name=vendor_uuid]").val(get(data, 'vendor.uuid', ''));
        productVendorsForm.find("[name=uuid]").val(get(data, 'uuid'));
        productVendorsForm.find("[name=vendor_name]").val(get(data, 'vendor.business_name'));
        productVendorsForm.find("[name=price]").val(get(data, 'price'));
    });

    productVendorsTable.on('click', '.btn-delete', function(event){
        const rowData = tableInstance.row(jQuery(this).closest('tr')).data();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this vendor <strong>"+get(rowData, 'vendor.business_name')+"</strong>",
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
            action: 'products/product/vendors/delete',
            method: 'GET',
            data: {pvuuid: uuid},
            success:function(res){
                const success = get(res, 'success', false);
                if(!success){
                    return;
                }
                productVendorsTable.DataTable().ajax.reload()
            }
        })
    }
})
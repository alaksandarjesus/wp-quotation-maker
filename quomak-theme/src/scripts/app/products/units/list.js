import { ColumnDefns } from './column-defns';
import { Datatable } from '../../shared/datatable';
import { ModalConfirm } from '../../shared/modal-confirm';
import { get } from 'lodash';

jQuery(function () {
    const productUnitsListTable = jQuery("table.product-units");
    if (!productUnitsListTable.length) {
        return;
    }
    const datatable = new Datatable();
    datatable.action = 'products/units/list';
    productUnitsListTable.DataTable(datatable.config(ColumnDefns));


    productUnitsListTable.on('click', '.btn-edit', function (event) {
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const name = jQuery(this).closest('tr').find('.name').text();
        const notes = jQuery(this).closest('tr').find('.notes').text();
        const productUnitForm = jQuery("form.product-unit");
        if (!productUnitForm.length) {
            console.error("undefined product unit form");
            return;
        }

        productUnitForm.find("[name=uuid]").val(uuid);
        productUnitForm.find("[name=name]").val(name);
        productUnitForm.find("[name=notes]").val(notes);
        console.log(productUnitForm[0])

    })
    productUnitsListTable.on('click', '.btn-delete', function (event) {
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const name = jQuery(this).closest('tr').find('.name').text();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this product unit <strong>" + name + "</strong>",
            btnYes: {
                text: "Yes",
                click: () => {
                    onDeleteConfirm(uuid)
                }
            },
            btnNo: {
                text: "No",
            }
        }
        const config = { backdrop: 'static', keyboard: false };
        modalConfirm.show(args, config);
    })

    function onDeleteConfirm(uuid) {
        jQuery.ajax({
            action: 'products/units/delete',
            method: 'GET',
            data: { uuid: uuid },
            success: function (res) {
                const success = get(res, 'success', false);
                if (!success) {
                    return;
                }
                productUnitsListTable.DataTable().ajax.reload()
            }
        })
    }

})
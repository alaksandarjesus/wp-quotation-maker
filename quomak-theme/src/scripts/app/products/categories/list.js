import { ColumnDefns } from './column-defns';
import { Datatable } from '../../shared/datatable';
import { ModalConfirm } from '../../shared/modal-confirm';
import { get } from 'lodash';

jQuery(function () {
    const productCategoriesListTable = jQuery("table.product-categories");
    if (!productCategoriesListTable.length) {
        return;
    }
    const datatable = new Datatable();
    datatable.action = 'products/categories/list';
    productCategoriesListTable.DataTable(datatable.config(ColumnDefns));


    productCategoriesListTable.on('click', '.btn-edit', function (event) {
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const name = jQuery(this).closest('tr').find('.name').text();
        const notes = jQuery(this).closest('tr').find('.notes').text();
        const productCategoryForm = jQuery("form.product-category");
        if (!productCategoryForm.length) {
            console.error("undefined product category form");
            return;
        }

        productCategoryForm.find("[name=uuid]").val(uuid);
        productCategoryForm.find("[name=name]").val(name);
        productCategoryForm.find("[name=notes]").val(notes);

    })
    productCategoriesListTable.on('click', '.btn-delete', function (event) {
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const name = jQuery(this).closest('tr').find('.name').text();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this product category <strong>" + name + "</strong>",
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
            action: 'products/categories/delete',
            method: 'GET',
            data: { uuid: uuid },
            success: function (res) {
                const success = get(res, 'success', false);
                if (!success) {
                    return;
                }
                productCategoriesListTable.DataTable().ajax.reload()
            }
        })
    }

})
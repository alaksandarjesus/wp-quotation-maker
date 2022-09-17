import { ColumnDefns } from './column-defns';
import { Datatable } from '../../shared/datatable';
import { ModalConfirm } from '../../shared/modal-confirm';
import { get } from 'lodash';

jQuery(function () {
    const projectCategoriesListTable = jQuery("table.project-categories");
    if (!projectCategoriesListTable.length) {
        return;
    }
    const datatable = new Datatable();
    datatable.action = 'projects/categories/list';
    projectCategoriesListTable.DataTable(datatable.config(ColumnDefns));


    projectCategoriesListTable.on('click', '.btn-edit', function (event) {
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const name = jQuery(this).closest('tr').find('.name').text();
        const notes = jQuery(this).closest('tr').find('.notes').text();
        const projectCategoryForm = jQuery("form.project-category");
        if (!projectCategoryForm.length) {
            console.error("undefined product category form");
            return;
        }

        projectCategoryForm.find("[name=uuid]").val(uuid);
        projectCategoryForm.find("[name=name]").val(name);
        projectCategoryForm.find("[name=notes]").val(notes);

    })
    projectCategoriesListTable.on('click', '.btn-delete', function (event) {
        const uuid = jQuery(this).closest('tr').attr('data-uuid');
        const name = jQuery(this).closest('tr').find('.name').text();
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to delete this project category <strong>" + name + "</strong>",
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
            action: 'projects/categories/delete',
            method: 'GET',
            data: { uuid: uuid },
            success: function (res) {
                const success = get(res, 'success', false);
                if (!success) {
                    return;
                }
                projectCategoriesListTable.DataTable().ajax.reload()
            }
        })
    }

})
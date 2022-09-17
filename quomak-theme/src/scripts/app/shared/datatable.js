import { get } from 'lodash';

export const DeleteBtn = `
<div class="d-flex justify-content-center align-items-center">
        <button class="btn btn-sm btn-icon btn-danger btn-delete">
            <span class="material-icons-outlined text-white">delete</span>
        </button>
        </div>
`


export const EditBtn = `
<div class="d-flex justify-content-center align-items-center">
<button class="btn btn-sm btn-icon btn-warning me-2 btn-edit">
            <span class="material-icons-outlined text-white">edit</span>
        </button>
        </div>
`

export const  EditDeleteBtn = `
<div class="d-flex justify-content-center align-items-center">
<button class="btn btn-sm btn-icon btn-warning me-2 btn-edit">
            <span class="material-icons-outlined text-white">edit</span>
        </button>
        <button class="btn btn-sm btn-icon btn-danger btn-delete">
            <span class="material-icons-outlined text-white">delete</span>
        </button>
        </div>
`

export class Datatable {

    pageLength = 5;

    lengthMenu = [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]];

    action = '';

    getRows = (dataTablesParameters, callback)=>{
        jQuery.ajax({
            action: this.action,
            method: 'POST',
            data: dataTablesParameters,
            success: function (res) {
                const success = get(res, 'success', false);
                if (!success) {
                    callback({
                        recordsTotal: 0, // the response should have the total records value
                        recordsFiltered: 0,
                        data: [],
                    })
                    return;
                }
                callback({
                    recordsTotal: get(res, 'data.total', 0),
                    recordsFiltered: get(res, 'data.filtered', 0),
                    data: get(res, 'data.results', []),
                });

            }
        })
    }

    config = (columnDefns)=>{
        const config = {
            createdRow: function(row, data, dataIndex){
               jQuery(row).attr('data-uuid', get(data, 'uuid'));
            },
            columns: columnDefns,
            processing: true,
            serverSide: true,
            ajax: this.getRows,
            order: [],
            pageLength: this.pageLength,
            lengthMenu: this.lengthMenu,
        }
        return config;
    }
}
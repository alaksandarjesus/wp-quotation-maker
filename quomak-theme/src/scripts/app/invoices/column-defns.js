import { EditDeleteBtn } from '../shared/datatable';
let transactionsBtn = `<div class="d-flex justify-content-center align-items-center">`;
transactionsBtn += `<button class="btn btn-icon btn-sm btn-success btn-transactions">`;
transactionsBtn += `<span class="material-icons-outlined text-white">payments</span>`;
transactionsBtn += `</button></div>`;

export const ColumnDefns = [
    {
        title: 'Project',
        data: 'project.name',
        className: 'code'
    },
    {
        title: 'Customer',
        data: 'customer.business_name',
        className: 'code'
    },
    {
        title: 'Quotation Number',
        data: 'quotation_number',
        className: 'quotation_number'
    },
    {
        title: 'Quotation Total',
        data: 'total',
        className: 'quotation_total'
    },
    {
        title: '',
        width: '100px',
        orderable: false,
        render: function (cellValue, cellType, row) {
            return  transactionsBtn
        }
    },
    {
        title: '',
        width: '100px',
        orderable: false,
        render: function (cellValue, cellType, row) {
            return  EditDeleteBtn
        }
    }
]
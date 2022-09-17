import { EditDeleteBtn } from '../shared/datatable';
const mapVendorBtn = '<button class="btn btn-sm btn-icon btn-primary btn-vendors"><span class="material-icons-outlined">person</span></button>';
const mapProductBtn = '<button class="btn btn-sm btn-icon btn-info btn-related ms-2"><span class="text-white material-icons-outlined">article</span></button>';
export const ColumnDefns = [
    {
        title: 'Code',
        data: 'code',
        className: 'code'
    },
    {
        title: 'Name',
        data: 'name',
        className: 'name'
    },
    {
        title: 'Category',
        data: 'category.name',
        className: 'category'
    },
    {
        title: 'Unit',
        data: 'unit.name',
        className: 'unit'
    },
    {
        title: '',
        width: '100px',
        orderable: false,
        render: function (cellValue, cellType, row) {
            return  `<div class="d-flex justify-content-center align-items-center">${mapVendorBtn+mapProductBtn}</div>`
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
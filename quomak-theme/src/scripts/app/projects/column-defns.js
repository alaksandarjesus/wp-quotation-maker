import { EditDeleteBtn } from '../shared/datatable';

export const ColumnDefns = [
    {
        title: 'Category',
        data: 'category.name',
        className: 'code'
    },
    {
        title: 'Customer',
        data: 'customer.business_name',
        className: 'code'
    },
    {
        title: 'Name',
        data: 'name',
        className: 'name'
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
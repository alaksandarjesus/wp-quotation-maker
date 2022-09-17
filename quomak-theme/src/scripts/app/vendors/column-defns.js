import { EditDeleteBtn } from '../shared/datatable';
export const ColumnDefns = [
    {
        title: 'Business Name',
        data: 'business_name',
        className: 'business-name'
    },
    {
        title: 'First Name',
        data: 'first_name'
    },
    {
        title: 'Last Name',
        data: 'last_name'
    },
    {
        title: 'Email',
        data: 'email'
    },
    {
        title: 'Mobile',
        data: 'mobile'
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
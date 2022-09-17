import { EditDeleteBtn } from '../../../shared/datatable';
import { get } from 'lodash';
export const ColumnDefns = [
    {
        title: 'Name',
        data: 'vendor.business_name',
        className: 'vendor',
    },
    {
        title: 'Price',
        data: 'price',
        className: 'price'
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
import { DeleteBtn } from '../../../shared/datatable';
import { get } from 'lodash';
export const ColumnDefns = [
    
    {
        title: 'Code',
        data: 'product.code',
        className: 'code'
    },
    {
        title: 'Name',
        data: 'product.name',
        className: 'name',
    },
    
    {
        title: '',
        width: '100px',
        orderable: false,
        render: function (cellValue, cellType, row) {
            return  DeleteBtn
        }
    }
]
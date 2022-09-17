import { EditDeleteBtn } from '../../shared/datatable';
export const ColumnDefns = [
    {
        title: 'Name',
        data: 'name',
        className: 'name'
    },
    {
        title: 'Notes',
        data: 'notes',
        className: 'notes'

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
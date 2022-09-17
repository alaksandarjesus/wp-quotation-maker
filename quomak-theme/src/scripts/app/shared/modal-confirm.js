import { get } from 'lodash';

export class ModalConfirm {

    modalConfirmEle = jQuery(".modal-confirm");

    modalConfirmInstance = null;

    show(args = {}, config = {}) {
        this.modalConfirmEle.find('.modal-title').html(get(args, 'title', 'Title'));
        this.modalConfirmEle.find('.modal-body').html(get(args, 'text', 'Text'));
        this.modalConfirmEle.find('.btn-yes').text(get(args, 'btnYes.text', 'Yes'));
        this.modalConfirmEle.find('.btn-no').text(get(args, 'btnNo.text', 'No'));
        const modalConfirmInstance = new bootstrap.Modal(this.modalConfirmEle[0], config);
        modalConfirmInstance.show();
        this.modalConfirmEle.on('click', '.btn-yes', function () {
            if (get(args, 'btnYes.click', null)) {
                modalConfirmInstance.hide();
                get(args, 'btnYes.click')(modalConfirmInstance);
            }
        });
        this.modalConfirmEle.on('click', '.btn-no', function () {
            modalConfirmInstance.hide();
        });
        this.modalConfirmEle.on('click', '.btn-yes', function () {
            modalConfirmInstance.hide();
        });
        this.modalConfirmEle.on('hidden.bs.modal', ()=>{
            this.modalConfirmEle.off('click');
        })
    }


}
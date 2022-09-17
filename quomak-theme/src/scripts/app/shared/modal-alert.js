import { get } from 'lodash';

export class ModalAlert {

    modalAlertEle = jQuery(".modal-alert");

    modalAlertInstance = null;

    show(args = {}, config = {}) {
        this.modalAlertEle.find('.modal-title').html(get(args, 'title', 'Title'));
        this.modalAlertEle.find('.modal-body').html(get(args, 'text', 'Text'));

        const modalAlertInstance = new bootstrap.Modal(this.modalAlertEle[0], config);
        modalAlertInstance.show();
      
    }


}
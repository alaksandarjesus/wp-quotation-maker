import { ModalConfirm } from '../shared/modal-confirm';
import { get } from  'lodash';
jQuery(function(){
    const logoutEle = jQuery(".logout");
    if(!logoutEle){
        return;
    }
    
    logoutEle.on('click', function(){
        const modalConfirm = new ModalConfirm();
        const args = {
            title: "Confirmation Required",
            text: "Are you sure you want to logout?",
            btnYes: {
                text: "Yes",
                click:onLogoutConfirm
            },
            btnNo: {
                text: "No",
                
            }
        }
        const config = {backdrop:'static', keyboard:false};
        modalConfirm.show(args,  config);
    });

    function onLogoutConfirm(){
        jQuery.ajax({
            action: 'logout',
            method: 'GET',
            success: function(res){
                const success = get(res, 'success', false);
                if(!success){
                    return;
                }
                window.location.href = get(res, 'data.redirect', get(window, 'wpmatrimony_ajax_object.base_url', window.location.origin));
                
            }
        })
    }
});

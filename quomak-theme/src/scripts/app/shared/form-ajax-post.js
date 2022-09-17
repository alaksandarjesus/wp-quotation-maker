import { forEach, keys, get } from "lodash";
export const FormAjaxPost = (form, ev, action, Rules, onSuccess, onError, onComplete)=>{
    ev.preventDefault();
            ev.stopPropagation();
            const form$ = jQuery(form);
            const data = {};
            forEach(keys(Rules), (rule) => {
                data[rule]= form$.find("[name="+rule+"]").val();
            });
            form$.find('.btn-submit').prop('disabled', true);
            jQuery.ajax({
                action: action,
                method: 'POST',
                data: data,
                success: function (res) {
                    const success = get(res, 'success', false);
                    if(!success){
                    form$.find('.btn-submit').prop('disabled', false);
                    }
                    if(onSuccess){
                        onSuccess(res);
                    }
                },
                error: function (err) {
                    form$.find('.btn-submit').prop('disabled', false);
                    if(onError){
                        onError(err)
                    }
                },
                complete: function () {
                    if(onComplete){
                        onComplete()
                    }
                }
            });
}
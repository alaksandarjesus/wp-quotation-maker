import { Rules, Messages } from './validation';
import { forEach, keys, get} from 'lodash';

jQuery(function(){
    const vendorForm = jQuery("form.vendor");
    if(!vendorForm.length){
        return;
    }

    vendorForm.validate({
        rules: Rules,
        message: Messages,
        submitHandler: function(form, event){
            event.preventDefault();
            event.stopPropagation();
            const form$ = jQuery(form);
            const data = {};
            forEach(keys(Rules), (rule) => {
                data[rule]= form$.find("[name="+rule+"]").val();
            });

            jQuery.ajax({
                action: 'vendors/vendor',
                method: 'POST',
                data: data,
                success: function (res) {
                    const success = get(res, 'success', false);
                    const redirect = get(res, 'data.redirect', false);
                    if (!success) {
                        return;
                    }
                    if(redirect){
                        window.location.href = redirect;
                    }

                },
                error: function () {

                },
                complete: function () {

                }
            })
        }
    })
})
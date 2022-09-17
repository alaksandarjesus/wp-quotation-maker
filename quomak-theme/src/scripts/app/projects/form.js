import { Rules, Messages } from './validation';
import { forEach, keys, get} from 'lodash';

jQuery(function(){
    
    const projectForm = jQuery("form.project");
    if(!projectForm.length){
        return;
    }
    projectForm.validate({
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
                action: 'projects/project',
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
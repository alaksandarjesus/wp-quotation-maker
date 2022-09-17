import { Rules, Messages } from './validation';
import { forEach, keys, get} from 'lodash';

jQuery(function(){
    const projectCategoryForm = jQuery("form.project-category");
    if(!projectCategoryForm.length){
        return;
    }

    projectCategoryForm.validate({
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
            form$.find('.btn-submit').prop('disabled', true);

            jQuery.ajax({
                action: 'projects/categories/category',
                method: 'POST',
                data: data,
                success: function (res) {
                    const success = get(res, 'success', false);
                    const redirect = get(res, 'data.redirect', false);
                    if (!success) {
                        form$.find('.btn-submit').prop('disabled', false);
                        return;
                    }
                    if(redirect){
                        window.location.href = redirect;
                    }

                },
                error: function () {
                    form$.find('.btn-submit').prop('disabled', false);
                },
                complete: function () {

                }
            })
        }
    })
})
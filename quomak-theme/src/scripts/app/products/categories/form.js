import { Rules, Messages } from './validation';
import { forEach, keys, get} from 'lodash';

jQuery(function(){
    const productCategoryForm = jQuery("form.product-category");
    if(!productCategoryForm.length){
        return;
    }

    productCategoryForm.validate({
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
                action: 'products/categories/category',
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
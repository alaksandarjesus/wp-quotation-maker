import { FormAjaxPost } from '../../../shared/form-ajax-post';
import { Rules, Messages } from './validation';
import { Autocomplete } from '../../../shared/autocomplete';
import { get } from 'lodash';

jQuery(function () {
    const productRelatedForm = jQuery("form.product-related");

    if (!productRelatedForm) {
        return;
    }

    productRelatedForm.validate({
        rules: Rules,
        messages: Messages,
       submitHandler: (form, event)=>{
        FormAjaxPost(form, event, 'products/product/related', Rules, onSuccess)
       }
    });

    function onSuccess(res) {
    }
    const fields = {label:'name', id:'uuid'};
    Autocomplete(productRelatedForm.find("[name=product_name]"), 'products/search', fields, onProductSelect);
    
    function onProductSelect(event, ui){
        productRelatedForm.find('[name=related_product_uuid]').val(get(ui, 'item.id'));
    }
})
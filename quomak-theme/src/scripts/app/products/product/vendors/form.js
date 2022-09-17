import { FormAjaxPost } from '../../../shared/form-ajax-post';
import { Rules, Messages } from './validation';
import { Autocomplete } from '../../../shared/autocomplete';
import { get } from 'lodash';

jQuery(function () {
    const productVendorsForm = jQuery("form.product-vendor");

    if (!productVendorsForm) {
        return;
    }

    productVendorsForm.validate({
        rules: Rules,
        messages: Messages,
       submitHandler: (form, event)=>{
        FormAjaxPost(form, event, 'products/product/vendors', Rules, onSuccess)
       }
    });

    function onSuccess(res) {
    }

    const fields = {label:'business_name', id:'uuid'};
    Autocomplete(productVendorsForm.find("[name=vendor_name]"), 'vendors/search', fields, onVendorSelect);
    
    function onVendorSelect(event, ui){
        productVendorsForm.find('[name=vendor_uuid]').val(get(ui, 'item.id'));
    }
    
})
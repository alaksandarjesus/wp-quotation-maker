import { isEqual } from "lodash";

jQuery(function(){
    jQuery('.password-toggle').on('click', function(){
       const formGroup = jQuery(this).closest('.form-group');
       if(!formGroup.length){
        console.error("closest form group not found")
        return;
       }
       const passwordEle = formGroup.find("input.password");
       if(!passwordEle){
        console.error("password element not found")
        return;
       }
       const type = passwordEle.attr('type');
       passwordEle.attr('type', isEqual(type, 'password')?'text':'password');
    });
})
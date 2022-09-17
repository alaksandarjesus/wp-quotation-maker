import { get, trim } from 'lodash';
import { Validation } from '../shared/validations';

jQuery(function () {
    const setPasswordForm = jQuery('form.set-password');
    if (!setPasswordForm.length) {
        return;
    }
    setPasswordForm.validate({
        rules: {
            otp: get(Validation, 'otp.rules', {}),
            password: get(Validation, 'password.rules', {}),
            cpassword: get(Validation, 'cpassword.rules', {}),
            
        },
        messages: {
            otp: get(Validation, 'otp.messages', {}),
            password: get(Validation, 'password.messages', {}),
            cpassword: get(Validation, 'cpassword.messages', {}),
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            event.stopPropagation();
            const form$ = jQuery(form);
            const data = {
                username: trim(form$.find('.username').val()),
                key: trim(form$.find('.key').val()),
                otp: trim(form$.find('.otp').val()),
                password: trim(form$.find('.password').val()),
                cpassword: trim(form$.find('.cpassword').val()),
            }
            jQuery.ajax({
                action: 'set-password',
                method: 'POST',
                data: data,
                success: function (res) {
                    const success = get(res, 'success', false);
                    if (!success) {
                        return;
                    }
                    window.location.reload();
                },
                error: function () {

                },
                complete: function () {

                }
            })
        }
    });

});
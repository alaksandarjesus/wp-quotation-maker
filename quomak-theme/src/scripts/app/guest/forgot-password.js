import { get, trim } from 'lodash';
jQuery(function () {
    const forgotPasswordForm = jQuery('form.forgot-password');
    if (!forgotPasswordForm.length) {
        return;
    }
    
    forgotPasswordForm.validate({
        rules: {
            username: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Username/Email is required"
            }
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            event.stopPropagation();
            const form$ = jQuery(form);
            const data = {
                username: trim(form$.find('.username').val()),
            }
            jQuery.ajax({
                action: 'forgot-password',
                method: 'POST',
                data: data,
                success: function (res) {
                    const success = get(res, 'success', false);
                    if (!success) {
                        return;
                    }
                    showSetPasswordForm(res);
                },
                error: function () {

                },
                complete: function () {

                }
            })
        }
    });

    function showSetPasswordForm(res){
        const guestFormElements = jQuery(".guest-forms");
        guestFormElements.find('input').val('');
        guestFormElements.find('form').each(function () {
            const validator = jQuery(this).validate();
            validator.resetForm();
        });
        guestFormElements.find('form:visible').fadeOut(function () {
            const otp = get(res, 'data.otp', '');
            const key = get(res, 'data.key', '');
            const username = get(res, 'data.username', '');
            guestFormElements.find('form.set-password').find('.key').val(key);
            guestFormElements.find('form.set-password').find('.username').val(username);
            guestFormElements.find('form.set-password').find('.otp').val(otp).focus();
            guestFormElements.find('form.set-password').fadeIn();
        });

    }
});
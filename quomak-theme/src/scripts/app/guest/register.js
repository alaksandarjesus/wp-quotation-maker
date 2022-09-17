import { get, trim } from 'lodash';
import { Validation } from '../shared/validations';
jQuery(function () {
    const registerForm = jQuery('form.register');
    if (!registerForm.length) {
        return;
    }
    registerForm.validate({
        rules: {
            firstname: get(Validation, 'firstname.rules', {}),
            lastname: get(Validation, 'lastname.rules', {}),
            username: get(Validation, 'username.rules', {}),
            email: get(Validation, 'email.rules', {}),
        },
        messages: {
            firstname: get(Validation, 'firstname.messages', {}),
            lastname: get(Validation, 'lastname.messages', {}),
            username: get(Validation, 'username.messages', {}),
            email: get(Validation, 'email.messages', {})
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            event.stopPropagation();
            const form$ = jQuery(form);
            const data = {
                firstname: trim(form$.find('.firstname').val()),
                lastname: trim(form$.find('.lastname').val()),
                username: trim(form$.find('.username').val()),
                email: trim(form$.find('.email').val()),
            }
            jQuery.ajax({
                action: 'register',
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
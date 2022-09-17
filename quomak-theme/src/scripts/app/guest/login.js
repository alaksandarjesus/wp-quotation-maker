import { get, trim, omit } from 'lodash';
import { Validation } from '../shared/validations';
jQuery(function () {
    const loginForm = jQuery('form.login');
    if (!loginForm.length) {
        return;
    }
    const usernameRules = omit(get(Validation, 'username.rules', {}), ['pattern']);
    const omitted =  omit(usernameRules, ['pattern']);
    loginForm.validate({
        rules: {
            username: usernameRules,
            password: get(Validation, 'password.rules', {})
        },
        messages: {
            username: get(Validation, 'username.messages', {}),
            password: get(Validation, 'password.messages', {})
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            event.stopPropagation();
            const form$ = jQuery(form);
            const data = {
                username: trim(form$.find('.username').val()),
                password: trim(form$.find('.password').val()),
            }
            jQuery.ajax({
                action: 'login',
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
    })
});